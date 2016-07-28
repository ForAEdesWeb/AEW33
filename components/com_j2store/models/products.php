<?php
/*------------------------------------------------------------------------
# com_j2store - J2Store
# ------------------------------------------------------------------------
# author    Priya Bose - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2014 - 19 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/


// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once (JPATH_SITE.'/components/com_j2store/helpers/cart.php');

class J2StoreModelProducts extends J2StoreModel
{
	/**
	 * @var array
	 */

	var $_data = null;

	var $_limit =null;

	/**
	 *
	 * @var email
	 */
	var $_id = null;

	/**
	 * @var integer
	 */
	var $_total = null;

	/**
	 * Pagination object
	 *
	 * @var object
	 */
	var $_pagination = null;
	var $_article_type = 0;

	/**
	 * Constructor
	 *
	 * @since 2.5
	 */
	function __construct()
	{
		parent::__construct();
		$app=JFactory::getApplication();
		$option = 'com_j2store';
		$ns = $option.'.products';
		// Get the pagination request variables
		$menu = $app->getMenu()->getActive();

		if(isset($menu->params) && $menu->params->get('page_limit')){
			$limit = $menu->params->get('page_limit');
		}else{
			$limit		= $app->getUserStateFromRequest( 'global.list.limit', 'limit',$app->getCfg('list_limit') , 'int' );
		}
		$limitstart	= $app->getUserStateFromRequest( $ns.'limitstart', 'limitstart', 0, 'int' );

		$categoryId = $app->getUserStateFromRequest($ns . 'filter_category','filter_category');
		$category_title = $app->getUserStateFromRequest($ns.'category_title','category_title');
		$filter_sort = $app->getUserStateFromRequest($ns.'filter_sort','filter_sort');
		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('filter_category', $categoryId);
		$this->setState('filter_sort', $filter_sort);
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
		$this->setState('category_title',$category_title);
//		$this->setState('filter_optionvalue',$filter_option_value);
		$id = $app->input->getInt('id');
		$this->setId($id);


	}

	/**
	 *
	 * @access	public
	 */
	function setId($id)
	{
		// Set address id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}


	function getId() {
		return $this->_id;
	}



	/**
	 * Method to get Data
	 * @access public
	 * @return array
	 */
	function getData()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$query = $this->_buildQuery();
			//$this->_data = $this->_getList($query, $this->getState('limitstart'), $limit);
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}


		return $this->_data;
	}

	/**
	 *
	 * @access public
	 * @return integer
	 */
	function getTotal()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_total))
		{
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
		}

		return $this->_total;
	}

	/**
	 * Method to get a pagination object
	 *
	 * @access public
	 * @return integer
	 */
	function getPagination()
	{

		// Lets load the content if it doesn't already exist
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}
		return $this->_pagination;
	}

	function _buildQuery()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('p.* ,p.id as product_id')->from('#__content AS p');


		if(version_compare(JVERSION ,'3.0','ge')){

			$tagId = $this->getState('filter_tag',0);

			if (isset($tagId) && $tagId && is_numeric($tagId))
			{
				$query->select('tagmap.*');

				$query->where($db->quoteName('tagmap.tag_id') . ' = ' . (int) $tagId)
					->join(
						'LEFT', $db->quoteName('#__contentitem_tag_map', 'tagmap')
						. ' ON ' . $db->quoteName('tagmap.content_item_id') . ' = ' . $db->quoteName('p.id')
						. ' AND ' . $db->quoteName('tagmap.type_alias') . ' = ' . $db->quote('com_content.article')
					);
				$query->leftJoin('#__tags as tag ON tag.id ='.$tagId);
				$query->select('tag.title as tagtitle');
			}
		}
		$this->_buildContentJoin($query);
		$this->_buildContentWhere($query);
		$this->_buildContentOrderBy($query );
		$this->_buildContenthaving($query);
		return $query;
	}


	/**
	 * Method to build joinsQuery
	 * @param string $query
	 * @return string $query
	 */
	private function _buildContentJoin($query) {

		//select all data from prices table

		$query->select('price.*');

		$query->innerJoin('#__j2store_prices AS price ON price.article_id=p.id');

		$query->select('rating.*');
		$query->leftJoin('#__content_rating as rating ON rating.content_id = p.id');
	}



	/**
	 * Method to build OrderBy query
	 * @param string $query
	 * @retrun string query
	 */
	function _buildContentOrderBy(&$query)
	{
		$app = JFactory::getApplication();
		$db = JFactory::getDbo();
		$option = 'com_j2store';
		$ns='com_j2store.products';

		$filter_order		= $this->getState('filter_order','p.ordering');
		$filter_order_Dir = $this->getState('filter_order_Dir','ASC');
		$filter_sort = $app->getUserStateFromRequest($ns.'filter_sort','filter_sort', '');

		if(isset($filter_sort) && ($filter_sort)){
			$query->order($filter_sort);
		}elseif($filter_order){
			$query->order($filter_order.' '.$filter_order_Dir);
		}

		$query->order('p.id');
	}

	function _buildContentWhere($query)
	{
		$app = JFactory::getApplication();
		$db = JFactory::getDbo();
		$user = JFactory::getUser();
		$option = 'com_j2store';
		$ns='com_j2store.products';

		//get the filter category from state
		$filter_category =$this->getState('filter_category');

		$filter_tag=$this->getState('filter_tag','0');

		//get the filter optionvalue from state
		$filter_optionvalue	= $this->getState('filter_optionvalue','0');

		$search				= $this->getState('search','');

		if (strpos($search, '"') !== false) {
			$search = str_replace(array('=', '<'), '', $search);
		}

		$search = JString::strtolower($search);

		//if search exists
		if ($search) {
			$where = array();
			$where[] ='LOWER(p.title) LIKE '.$db->Quote( '%'.$db->escape( $search, true ).'%', false );
			$where[] = 'LOWER(price.item_sku) LIKE ' .$db->Quote( '%'.$db->escape( $search, true ).'%', false );
			$where[] = 'LOWER(price.item_price) LIKE '.$db->Quote( '%'.$db->escape( $search, true ).'%', false );
			$query->where( '(' . implode( ' OR ', $where ) . ')' );
		}

		$menu = $app->getMenu()->getActive();
		if( isset($menu->params) && $menu->params->get('categories') && !$filter_category){
			$cat = implode(',',$menu->params->get('categories'));
			$query->where('p.catid IN ('. $cat.')' );

		}elseif($filter_category){
			//check categoryid exists in the state
			//fetch the items nased on the query

			// 是否顯示子分類
			if ($menu->params->get('show_sub_categories', 0))
			{
				$db = JFactory::getDbo();
				$categoriesQuery = $db->getQuery(true);

				// get category lft rgt
				$categoriesQuery->select('lft, rgt')->from('#__categories')->where('id='.$filter_category);

				$db->setQuery($categoriesQuery);
				$category = $db->loadObject();

				// clear query
				$categoriesQuery = $db->getQuery(true);

				// load child category
				$categoriesQuery->select('id')->from('#__categories')->where('lft >= ' . $category->lft . ' AND rgt <= ' . $category->rgt);

				$db->setQuery($categoriesQuery);
				$categorys = $db->loadObjectList();

				$cids = array();

				foreach($categorys as $cat)
				{
					$cids[] = $cat->id;
				}

				$cids = implode(',',$cids);

				$query->where('p.catid IN (' . $cids . ')');
			}
			else
			{
				$query->where('p.catid='.$filter_category);
			}
		}

		if(!$user->authorise('core.admin'))
		{
			$groups=implode(',',$user->getAuthorisedViewLevels());
			$query->where('p.access IN (' . $groups.')');
		}
		$query->where('price.product_enabled =1');
		$query->where('p.state =1');

	}

	/**
	 * Method to buildContentHaving Query
	 * @param string $query
	 * @return string $query
	 */
	function _buildContenthaving($query){
		$option = 'com_j2store';

		$ns='com_j2store.products';
		//get the filter price  range from the state
 		$filter_price_from = $this->getState('filter_price_from');

 		$filter_price_to = $this->getState('filter_price_to');

 		//check filter price from exists
		if (isset($filter_price_from ) &&  strlen( $filter_price_from ) )
		{
			//check the item price matches the range
			$query->having( "price.item_price >= '" . ( int ) $filter_price_from . "'" );
		}
		if ((isset($filter_price_to)) &&  strlen( $filter_price_to ) )
		{
			//check the item price matches the range
			$query->having( "price.item_price <= '" . ( int ) $filter_price_to . "'" );
		}

	}

	/**
	 * Method to getItem
	 * @params type int id
	 * @result products
	 */
	public function getItem(){
		$id = $this->getId();
		$product = J2StoreHelperCart::getItemInfo($id);
		//set the correct quantity
		if(isset($product->min_sale_qty) && $product->min_sale_qty > 1 && J2STORE_PRO == 1) {
			$product->product_quantity = (int) $product->min_sale_qty;
			$product->item_minimum_notice = JText::sprintf('J2STORE_MINIMUM_QUANTITY_NOTIFICATION', $product->product_name, (int) $product->min_sale_qty);
		} else {
			$product->product_quantity = 1;
		}

		//include the model file path
		JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_j2store/models');

		//create obj for cartmodel class
		$cart_model = JModelLegacy::getInstance('Mycart', 'J2StoreModel');

		//now get the productoptions based on the id
		$attributes = $cart_model->getProductOptions($id);

		//let calcuate the product option based on the stock
		if(count($attributes) && $product->manage_stock == 1 && J2STORE_PRO == 1) {
			//get unavailable attribute options
			$attributes = $cart_model->processAttributeOptions($attributes, $product);
		}

		//assign the attributes
		$product->attributes = $attributes;

		//assign th prices
		$product->prices = J2StorePrices::getPrice($id, $product->product_quantity);

		if(J2STORE_PRO == 1 && $product->manage_stock == 1) {
			JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_j2store/models');
			$qtyModel = JModelLegacy::getInstance('ProductQuantities', 'J2StoreModel');
			$qtyModel->setState('filter_product', $product->product_id);
			$qtyModel->setState('filter_productid', $product->product_id);
			$product->option_stock = $qtyModel->getList();
			$product->product_stock = $qtyModel->getQuantityTotal();
		} else {
			$product->product_stock = 99;
		}
		$product->product = $product;
		$product->inventory = J2StoreInventory::isAllowed($product);
		//get all tags

		if(version_compare(JVERSION ,'3.0','ge')){
			$product->product_tags = $this->getProductTags($id);
		}

		$this->executePlugins($product);

		return $product;
	}



	/**
	 * Method to get All Ratings voted for the product
	 * @param int type $id
	 * @result Objeclist
	 */
	public function getRatings($id){
		//get the db obj
		$db = JFactory::getDbo();

		//get the query class
		$query = $db->getQuery(true);

		//now give needed fields  to be fechted from the content_rating table
		$query->select('rating.*');
		$query->from('#__content_rating as rating');

		//query must satisfy the condition
		$query->where('rating.content_id ='.$id);
		$db->setQuery($query);

		//load all the objectlist
		$result= $db->loadObjectList();
		return $result;
	}


	/**
	 * Method to get Product Tags
	 * @params int type id
	 * @result loadObjectlist
	 */
	public function getProductTags($id){
		//get the db obj
		$db = JFactory::getDbo();
		//get the query
		$query = $db->getQuery(true);
		//now this query will fecth all data from the tag_map table
		$query->select('tagmap.*');
		$query->from('#__contentitem_tag_map as tagmap');

		//must satisfy the where condition
		$query->where("tagmap.content_item_id = ".$id);

		//to get the tag name we need to join the table tags
		$query->leftJoin('#__tags as tag ON tag.id = tagmap.tag_id');

		//fetch title
		$query->select('tag.title as tagtitle');
		$db->setQuery($query);
		$result= $db->loadObjectList();
		return $result;
	}


	private function executePlugins(&$product) {

		$app = JFactory::getApplication();
		//lets import the j2store plugin
		JPluginHelper::importPlugin('j2store');

		if(!isset($product->event) || !is_object($product->event)) {
			$product->event = new JObject();
		}
			$product->event->J2StoreBeforeProductDisplay = '';
			$product->event->J2StoreBeforeDisplayProductTitle= '';
			$product->event->J2StoreAfterDisplayProductTitle= '';
			$product->event->J2StoreBeforeDisplayProductPrice= '';
			$product->event->J2StoreAfterDisplayProductPrice= '';
			$product->event->J2StoreBeforeDisplayProductDescription= '';
			$product->event->J2StoreAfterDisplayProductDescription= '';
			$product->event->J2StoreBeforeDisplayProductImages= '';
			$product->event->J2StoreAfterDisplayProductImages= '';
			$product->event->J2StoreAfterProductDisplay = '';

		//before display product
		$results = $app->triggerEvent( 'onJ2StoreBeforeProductDisplay', array($product) );
		$product->event->J2StoreBeforeProductDisplay = implode('/n', $results);

		//before Product Title
		$results = $app->triggerEvent( 'onJ2StoreBeforeDisplayProductTitle', array($product) );
		$product->event->J2StoreBeforeDisplayProductTitle = implode('/n', $results);

		//After Product Title
		$results = $app->triggerEvent( 'onJ2StoreAfterDisplayProductTitle', array($product) );
		$product->event->J2StoreAfterDisplayProductTitle = implode('/n', $results);

		//images before
		$results = $app->triggerEvent( 'onJ2StoreBeforeDisplayProductImages', array($product) );
		$product->event->J2StoreBeforeDisplayProductImages = implode('/n', $results);

		//images after
		$results = $app->triggerEvent( 'onJ2StoreAfterDisplayProductImages', array($product) );
		$product->event->J2StoreAfterDisplayProductImages = implode('/n', $results);

		//before Product Price
		$results = $app->triggerEvent( 'onJ2StoreBeforeDisplayProductPrice', array($product) );
		$product->event->J2StoreBeforeDisplayProductPrice = implode('/n', $results);

		//after Product Price
		$results = $app->triggerEvent( 'onJ2StoreAfterDisplayProductPrice', array($product) );
		$product->event->J2StoreAfterDisplayProductPrice = implode('/n', $results);

		//before product description
		$results = $app->triggerEvent( 'onJ2StoreBeforeDisplayProductDescription', array($product) );
		$product->event->J2StoreBeforeDisplayProductDescription = implode('/n', $results);

		//after product description
		$results = $app->triggerEvent( 'onJ2StoreAfterDisplayProductDescription', array($product) );
		$product->event->J2StoreAfterDisplayProductDescription = implode('/n', $results);

		//After Product Display
		$results = $app->triggerEvent( 'onJ2StoreAfterProductDisplay', array($product) );
		$product->event->J2StoreAfterProductDisplay = implode('/n', $results);

	}

	public function getSortFields()
	{
		//containes sorting fields
		//both in ascending and descending

		return array(
				''=> JText::_('J2STORE_ADDTOCART_SELECT'),
				'p.title  ASC' => JText::_('J2STORE_PRODUCT_NAME_ASCENDING'),
				'p.title  DESC' => JText::_('J2STORE_PRODUCT_NAME_DESCENDING'),
				'price.item_price  ASC' => JText::_('J2STORE_PRODUCT_PRICE_ASCENDING'),
				'price.item_price  DESC' => JText::_('J2STORE_PRODUCT_PRICE_DESCENDING'),
				'price.item_sku  ASC' => JText::_('J2STORE_PRODUCT_SKU_ASCENDING'),
				'price.item_sku  DESC' => JText::_('J2STORE_PRODUCT_SKU_DESCENDING')
		);
	}

	public function getCategories($cat){
		//get the db object
		$db = JFactory::getDbo();
		if($cat){
			$selected_cat = implode(',',$cat);
		}
		//get the query
		$query = $db->getQuery(true);
		// query to fetch all data
		$query->select('*');
		$query->from('#__categories');
		$query->where('extension ='.$db->quote('com_content'));
		if(isset($cat)){
			$query->where('id IN ('.$selected_cat.')');
		}
		$query->order('lft ASC');
		$db->setQuery($query);
		//load objectlist and return the data
		$results = $db->loadObjectList();
		return $results;
	}

    /**
     * @param $cats
     * @return array
     */
    public function sortCategories($cats)
    {
        $cloneCats = $cats;
        $treeCats = array();
        $treeKey = 0;

        foreach ($cats as $cat)
        {
            $parent = $this->catFoundClosestParent($cat, $cloneCats);

            $treeCats[$treeKey] = $cat;

            // is root
            if ($parent == null)
            {
                $treeCats[$treeKey]->isRoot = true;
                $treeCats[$treeKey]->parentCat = null;
            }
            else
            {
                // 如果沒有女
                if (! isset($parent->childCat))
                {
                    $parent->childCat = array();
                }

                // 這是他的女
                $parent->childCat[] = $cat;

                $treeCats[$treeKey]->isRoot = false;
                $treeCats[$treeKey]->parentCat = $parent;
            }

            $treeKey++;
        }

        return $treeCats;
    }

    public function catFoundClosestParent($cat, $parents)
    {
        $returnValue = null;

        foreach ($parents as $parent)
        {
            if ($this->isCloserParent($cat, $returnValue, $parent))
            {
                $returnValue = $parent;
            }
        }

        return $returnValue;
    }

    /**
     * @param $cat
     * @param $now
     * @param $new
     * @return bool
     */
    public function isCloserParent($cat, $now, $new)
    {
        // for init
        if (! is_object($now))
        {
            if ($this->isParent($new, $cat))
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        if (! $this->between($new->lft, $cat->lft, $now->lft))
        {
            return false;
        }

        if (! $this->between($new->rgt, $now->rgt, $cat->rgt))
        {
            return false;
        }

        if (! $this->isParent($new, $cat))
        {
            return false;
        }

        return true;
    }

    /**
     * @param $parent
     * @param $sum
     * @return bool
     */
    public function isParent($parent, $sum)
    {
        return (($parent->lft < $sum->lft) and ($parent->rgt > $sum->rgt));
    }

    /**
     * @param $v
     * @param $max
     * @param $min
     * @return bool
     */
    public function between($v, $max, $min)
    {
        return (($max > $v) and ($v > $min));
    }
}
