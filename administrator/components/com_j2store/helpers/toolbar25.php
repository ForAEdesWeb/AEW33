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
// No direct access
defined('_JEXEC') or die;

jimport('joomla.html.toolbar');
jimport('joomla.html.toolbar.toolbar.button');

class J2StoreToolBar25 extends JToolBar
{
	/** @var array The links to be rendered in the toolbar */
	protected $linkbar = array();

	public function __construct($config = array()) {}

	protected function renderSubmenu()
	{
		$views = array(
				'cpanel',
				'J2STORE_MAINMENU_SALES' => array(
												array('name'=>'orders','icon'=>'fa fa-list-alt'),
												array('name'=>'coupons','icon'=>'fa fa-scissors'),
												),
				'J2STORE_MAINMENU_CATALOG' => array(
												array('name'=>'products','icon'=>'fa fa-tags'),
												array('name'=>'options','icon'=>'fa fa-list-ol'),
												),
				'J2STORE_MAINMENU_DESIGN' => array(
												array('name'=>'layouts','icon'=>'fa fa-desktop'),
												),
				'J2STORE_MAINMENU_LOCALISATION' => array(
												array('name'=>'countries','icon'=>'fa fa-globe'),
												array('name'=>'zones','icon'=>'fa fa-flag'),
												array('name'=>'geozones','icon'=>'fa fa-pie-chart'),
												array('name'=>'taxrates','icon'=>'fa fa-calculator'),
												array('name'=>'taxprofiles','icon'=>'fa fa-sitemap'),
												array('name'=>'lengths','icon'=>'fa fa-arrows-v'),
												array('name'=>'weights','icon'=>'fa fa-arrows-h'),
												array('name'=>'orderstatuses','icon'=>'fa fa-check-square'),
												),
				'J2STORE_MAINMENU_SETUP' => array(
												array('name'=>'storeprofiles','icon'=>'fa fa-edit'),
												array('name'=>'currencies','icon'=>'fa fa-usd'),
												array('name'=>'shipping','icon'=>'fa fa-truck'),
												array('name'=>'payment','icon'=>'fa fa-credit-card'),
												array('name'=>'emailtemplates','icon'=>'fa fa-envelope'),
												array('name'=>'fields','icon'=>'fa fa-cog'),
												),
				'J2STORE_MAINMENU_REPORTS' => array(
						array('name'=>'report','icon'=>'fa fa-signal'),
						),
		);



		//show product attribute migration menu only for the upgraded users

		require_once (JPATH_COMPONENT_ADMINISTRATOR.'/helpers/version.php');
		if(J2StoreVersion::getPreviousVersion() == '2.0.2' && J2STORE_ATTRIBUTES_MIGRATED==false) {
			$views['J2STORE_MAINMENU_TOOLS'] = array('migrate');
		}

		foreach($views as $label => $view) {
			if(!is_array($view)) {
				$this->addSubmenuLink($view);
			} else {
				$label = JText::_($label);
				$this->appendLink($label, '', false);
				foreach($view as $v) {
					$this->addSubmenuLink($v['name'], $label, $v['icon']);
				}
			}
		}
	}

	private function addSubmenuLink($view, $parent = null, $icon=null)
	{
		static $activeView = null;
		if(empty($activeView)) {
			$activeView = JFactory::getApplication()->input->getCmd('view','cpanel');
		}

		$key = strtoupper('J2STORE_'.strtoupper($view));

		$name = JText::_($key);

		$link = 'index.php?option=com_j2store&view='.$view;

		$active = $view == $activeView;

		if(strtolower($view) == 'options') {
			$name = JText::_('J2STORE_PRODUCT_GLOBAL_OPTIONS');
		}

		if(strtolower($view) == 'cpanel') {
			$name = JText::_('J2STORE_DASHBOARD');
		}

		if(strtolower($view) == 'currencies') {
			$name = JText::_('J2STORE_CURRENCY');
		}

		if(strtolower($name) == 'lengths') {
			$name = JText::_('J2STORE_LENGTHS');
		}

		if(strtolower($name) == 'weights') {
			$name = JText::_('J2STORE_WEIGHTS');
		}

		if(strtolower($name) == 'emailtemplates') {
			$name = JText::_('J2STORE_EMAILTEMPLATES');
		}

		if(strtolower($name) == 'migrate') {
			$name = JText::_('J2STORE_MIGRATE');
		}

		$this->appendLink($name, $link, $active, $icon, $parent);
	}


	public function renderLinkbar() {

		$app = JFactory::getApplication();
		$tmpl = $app->input->getCmd('tmpl');
		if($tmpl == 'component') {
			return;
		}

		$this->renderSubMenu();
		$links = $this->getLinks();
		$db = JFactory::getDbo();
		// Get installed version
		$query = $db->getQuery(true);
		$query->select($db->quoteName('manifest_cache'))->from($db->quoteName('#__extensions'))->where($db->quoteName('name').' = '.$db->quote('com_j2store'));
		$db->setQuery($query);
		$row = json_decode($db->loadResult());

		$vars = new JObject();
		$vars->links = $links;
		$vars->manifest = $row;
		echo $html = $this->getLayout('submenu', $vars);

	}

	function getLayout($layout, $vars) {
		$app = JFactory::getApplication();

		// get the template and default paths for the layout
		$defaultPath = JPATH_ADMINISTRATOR.'/components/com_j2store/views/cpanel/tmpl/'.$layout.'.php';
		// if the site template has a layout override, use it
		jimport('joomla.filesystem.file');
		$path = $defaultPath;
		ob_start();
		include($path);
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}



	public function appendLink($name, $link = null, $active = false, $icon = null, $parent = '')
	{
		$linkDefinition = array(
				'name'		=> $name,
				'link'		=> $link,
				'active'	=> $active,
				'icon'		=> $icon
		);
		if(empty($parent)) {
			$this->linkbar[$name] = $linkDefinition;
		} else {
			if(!array_key_exists($parent, $this->linkbar)) {
				$parentElement = $linkDefinition;
				$parentElement['link'] = null;
				$this->linkbar[$parent] = $parentElement;
				$parentElement['items'] = array();
			} else {
				$parentElement = $this->linkbar[$parent];
				if(!array_key_exists('dropdown', $parentElement) && !empty($parentElement['link'])) {
					$newSubElement = $parentElement;
					$parentElement['items'] = array($newSubElement);
				}
			}

			$parentElement['items'][] = $linkDefinition;
			$parentElement['dropdown'] = true;

			$this->linkbar[$parent] = $parentElement;
		}
	}


	public function &getLinks()
	{
		return $this->linkbar;
	}

	public static  function _custom($task = '', $icon = '', $iconOver = '', $alt = '', $listSelect = true, $x = false, $taskName = 'shippingTask')
	{


		$bar = JToolBar::getInstance('toolbar');

		//strip extension
		$icon	= preg_replace('#\.[^.]*$#', '', $icon);

		// Add a standard button
		$bar->appendButton( 'J2Store', $icon, $alt, $task, $listSelect, $x, $taskName );
	}

	public static function custom($task = '', $icon = '', $iconOver = '', $alt = '', $listSelect = true, $x = false, $taskName = 'shippingTask')
	{
		$bar = JToolBar::getInstance('toolbar');

		//strip extension
		$icon	= preg_replace('#\.[^.]*$#', '', $icon);

		// Add a standard button
		$bar->appendButton( $this->_name, $icon, $alt, $task, $listSelect, $x, $taskName );
	}

	/**
	 * Writes the common 'new' icon for the button bar
	 * @param string An override for the task
	 * @param string An override for the alt text
	 * @since 1.0
	 */
	public static function addNew($task = 'add', $alt = 'New', $taskName = 'shippingTask')
	{
		$bar = JToolBar::getInstance('toolbar');
		// Add a new button
		$bar->appendButton( $this->_name, 'new', $alt, $task, false, false, $taskName );
	}
}


class JToolbarButtonJ2Store25 extends JButton {


	function fetchButton( $type='J2Store', $name = '', $text = '', $task = '', $list = true, $hideMenu = false, $taskName = 'shippingTask' )
	{
		$i18n_text	= JText::_($text);
		$class	= $this->fetchIconClass($name);
		$doTask	= $this->_getCommand($text, $task, $list, $hideMenu, $taskName);

		$html	= "<a href=\"#\" onclick=\"$doTask\" class=\"toolbar\">\n";
		$html .= "<span class=\"$class\" title=\"$i18n_text\">\n";
		$html .= "</span>\n";
		$html	.= "$i18n_text\n";
		$html	.= "</a>\n";

		return $html;
	}

	function fetchId( $type='Confirm', $name = '', $text = '', $task = '', $list = true, $hideMenu = false )
	{
		return $this->_name.'-'.$name;
	}

	function _getCommand($name, $task, $list, $hide, $taskName)
	{
		$todo		= JString::strtolower(JText::_( $name ));
		$message	= JText::sprintf( 'J2STORE_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST_TO', $todo );
		$message	= addslashes($message);

		if ($list) {
			$cmd = "javascript:if(document.adminForm.boxchecked.value==0){alert('$message');}else{ submitJ2StoreButton('$task', '$taskName')}";
		} else {
			$cmd = "javascript:submitJ2StoreButton('$task', '$taskName')";
		}


		return $cmd;
	}
}