<?php
/*------------------------------------------------------------------------
 # com_j2store - J2Store
# ------------------------------------------------------------------------
# author    Priya bose - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2012 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/



// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the J2Store component
 *
 * @static
 * @package		Joomla
 * @subpackage	J2Store
 * @since 1.0
*/
JLoader::register('J2StoreView',  JPATH_ADMINISTRATOR.'/components//com_j2store/views/view.php');
class J2StoreViewProducts extends J2StoreView
{

 	public function display($tpl = null)
	{
 		$app = JFactory::getApplication();

 		//get the active menu details
 		$menu = $app->getMenu()->getActive();

 		//if any menu template choosen then that template will
 		if(isset($menu->params)){
 			//first get the subtemplate from the menu
 			$template = $menu->params->get('sub_template');
 			if(empty($template)) {
				//now get it from the store profile
				$store = J2StoreHelperCart::getStoreAddress();
				$template = isset($store->store_default_template)?$store->store_default_template:'';
 			}
 		}
 		if(empty($template)) $template = 'default';

 		//look for the in the views/products folder
 		$this->_addPath('template', JPATH_SITE.'/components/com_j2store/templates');
 		$this->_addPath('template', JPATH_SITE.'/components/com_j2store/templates/'.$template);

 		// Look for overrides in J2Store template structure
 		$this->_addPath('template', JPATH_SITE.'/templates/'.$app->getTemplate().'/html/com_j2store/templates/'.$template);
 		$this->_addPath('template', JPATH_SITE.'/templates/'.$app->getTemplate().'/html/com_j2store/templates/default');

 		//look for in the template overrides folder (Joomla structure)
 		$this->_addPath('template', JPATH_SITE.'/templates/'.$app->getTemplate().'/html/com_j2store/products/default');
 		$this->_addPath('template', JPATH_SITE.'/templates/'.$app->getTemplate().'/html/com_j2store/products/'.$template);

		parent::display($tpl);

	}

}
