<?php
/*------------------------------------------------------------------------
 # com_j2store - J2Store
# ------------------------------------------------------------------------
# author    Sasi varna kumar - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2014 - 19 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/

defined('JPATH_BASE') or die;


jimport('joomla.plugin.plugin');
jimport('joomla.html.parameter');

class plgSearchJ2store extends JPlugin
{

    function onContentSearchAreas()
    {
    	if($this->_isj2storeInstalled()){
        	return $this->onSearchAreas();
    	}else{
    		return array();
    	}
    }

    /**
     * Checks the extension is installed
     *
     * @return boolean
     */
    function _isj2storeInstalled()
    {
    	$success = false;

    	jimport('joomla.filesystem.file');
    	if (JFile::exists(JPATH_ADMINISTRATOR.'/components/com_j2store/j2store.php'))
    	{
    		$success = true;
    		if ( !class_exists('J2store') ) {
    			JLoader::register( "J2store", JPATH_ADMINISTRATOR."/components/com_j2store/j2store.php" );
    		}
    	}
    	return $success;
    }


    function onContentSearch($text, $phrase = '', $ordering = '', $areas = null)
    {
        return $this->onSearch($text, $phrase, $ordering, $areas);
    }

    function onSearchAreas()
    {
        JPlugin::loadLanguage('plg_search_j2store', JPATH_ADMINISTRATOR);
        static $areas = array('j2store' => 'PLG_J2STORE_ITEMS');
        return $areas;
    }

    function onSearch($text, $phrase = '', $ordering = '', $areas = null)
    {
        JPlugin::loadLanguage('plg_search_j2store', JPATH_ADMINISTRATOR);
        jimport('joomla.html.parameter');
        $mainframe = JFactory::getApplication();
        $app = JFactory::getApplication();
        $user = JFactory::getUser();
        $db = JFactory::getDBO();
        $groups = implode(',', $user->getAuthorisedViewLevels());
        $jnow = JFactory::getDate();
        $now =  $jnow->toSql();

        //2014-10-08 08:27:51

        $nullDate = $db->getNullDate();

        $accessCheck = " IN(".implode(',', $user->getAuthorisedViewLevels()).") ";

        $tagIDs = array();
        $itemIDs = array();

        $searchText = $text;
        if (is_array($areas))
        {
            if (!array_intersect($areas, array_keys($this->onSearchAreas())))
            {
                return array();
            }
        }


        $plugin = JPluginHelper::getPlugin('search', 'j2store');
        $pluginParams = class_exists('JParameter') ? new JParameter($plugin->params) : new JRegistry($plugin->params);

        $limit = $pluginParams->def('search_limit', 50);

        $text = JString::trim($text);
        if ($text == '')
        {
            return array();
        }

        switch ($phrase)
        {
        	case 'exact':
        		$text = $db->quote('%' . $db->escape($text, true) . '%', false);
        		$wheres2 = array();
        		$wheres2[] = 'p.item_sku LIKE ' . $text;
     			$where = '(' . implode(') OR (', $wheres2) . ')';
        		break;

        	case 'all':
        	case 'any':
        	default:
        		$words = explode(' ', $text);
        		$wheres = array();

        		foreach ($words as $word)
        		{
        			$word = $db->quote('%' . $db->escape($word, true) . '%', false);
        			$wheres2 = array();
        			$wheres2[] = 'p.item_sku LIKE ' . $word;
        			$wheres[] = implode(' OR ', $wheres2);
        		}

        		$where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
        		break;
        }

        switch ($ordering)
        {
        	case 'oldest':
        		$order = 'a.created ASC';
        		break;

        	case 'popular':
        		$order = 'a.hits DESC';
        		break;

        	case 'alpha':
        		$order = 'a.title ASC';
        		break;

        	case 'category':
        		$order = 'c.title ASC, a.title ASC';
        		break;

        	case 'newest':
        	default:
        		$order = 'a.created DESC';
        		break;
        }

        $rows = array();
        $query = $db->getQuery(true);

        // Search articles.
        if ($limit > 0)
        {
        	$query->clear();

        	// SQLSRV changes.
        	$case_when = ' CASE WHEN ';
        	$case_when .= $query->charLength('a.alias', '!=', '0');
        	$case_when .= ' THEN ';
        	$a_id = $query->castAsChar('a.id');
        	$case_when .= $query->concatenate(array($a_id, 'a.alias'), ':');
        	$case_when .= ' ELSE ';
        	$case_when .= $a_id . ' END as slug';

        	$case_when1 = ' CASE WHEN ';
        	$case_when1 .= $query->charLength('c.alias', '!=', '0');
        	$case_when1 .= ' THEN ';
        	$c_id = $query->castAsChar('c.id');
        	$case_when1 .= $query->concatenate(array($c_id, 'c.alias'), ':');
        	$case_when1 .= ' ELSE ';
        	$case_when1 .= $c_id . ' END as catslug';


        	$query->select('p.*');
        	$query->from('#__j2store_prices as p');
        	$query->where('p.product_enabled = 1');
        	$query->where( $where  );

        	$query->select('a.title AS title, a.metadesc, a.metakey, a.created AS created')
        	->select($query->concatenate(array('a.introtext', 'a.fulltext')) . ' AS text')
        	->select('c.title AS section, ' . $case_when . ',' . $case_when1 . ', ' . '\'2\' AS browsernav')
        	->leftJoin('#__content as a ON a.id=p.article_id')
        	->join('INNER', '#__categories AS c ON c.id=a.catid')
         	->where(
        			'a.state=1 AND c.published = 1 AND a.access IN (' . $groups . ') '
        			. 'AND c.access IN (' . $groups . ') '
        			. 'AND (a.publish_up = ' . $db->quote($nullDate) . ' OR a.publish_up <= ' . $db->quote($now) . ') '
        			. 'AND (a.publish_down = ' . $db->quote($nullDate) . ' OR a.publish_down >= ' . $db->quote($now) . ')'
        	)
	       	->group('a.id, a.title, a.metadesc, a.metakey, a.created, a.introtext, a.fulltext, c.title, a.alias, c.alias, c.id')
        	->order($order);
        	// Filter by language.
        	if ($app->isSite() && JLanguageMultilang::isEnabled())
        	{
        		$query->where('a.language in (' . $db->quote($tag) . ',' . $db->quote('*') . ')')
        		->where('c.language in (' . $db->quote($tag) . ',' . $db->quote('*') . ')');
        	}
        	$db->setQuery($query, 0, $limit);
        	$list = $db->loadObjectList();
        	$limit -= count($list);
        	if (isset($list))
        	{
        		foreach ($list as $key => $item)
        		{
        			$list[$key]->href = ContentHelperRoute::getArticleRoute($item->slug, $item->catslug);
        		}
        	}
        	$rows[] = $list;
        }
        $results = array();
        if (count($rows))
        {
            foreach ($rows as $row)
            {
                $new_row = array();
                foreach ($row as $key => $item)
                {
                    $item->browsernav = '';
                    $item->tag = $searchText;
                    if (searchHelper::checkNoHTML($item, $searchText, array('text', 'title', 'metakey', 'metadesc', 'section', 'image_caption', 'image_credits', 'video_caption', 'video_credits', 'extra_fields_search', 'tag')))
                    {
                        $new_row[] = $item;
                    }
                }
                $results = array_merge($results, (array)$new_row);
            }
        }

        return $results;
    }



}