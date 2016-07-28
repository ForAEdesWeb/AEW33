<?php
/*------------------------------------------------------------------------
 # mod_j2store_products - J2Store
# ------------------------------------------------------------------------
# author    ThemeParrot - ThemeParrot http://www.ThemeParrot.com
# copyright Copyright (C) 2014 ThemeParrot.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://ThemeParrot.com
# Based on Latest Articles module of Joomla
-------------------------------------------------------------------------*/
defined('_JEXEC') or die;
jimport( 'joomla.application.module.helper' );
// Include the syndicate functions only once
require_once (JPATH_ADMINISTRATOR.'/components/com_j2store/version.php');

//incase j2store product pages aren't published
$document =JFactory::getDocument();
$document->addScript(JURI::root(true).'/media/j2store/js/j2store.js');

if(version_compare(J2STORE_VERSION, '3.0.0', 'ge')) {
	if (!defined('F0F_INCLUDED'))
	{
		include_once JPATH_LIBRARIES . '/f0f/include.php';
	}
	//we are using latest version.
	require_once (JPATH_SITE.'/modules/mod_j2store_products/helperv3.php');
	require_once (JPATH_ADMINISTRATOR.'/components/com_j2store/helpers/j2store.php');

	$main_params = J2Store::config ();


} else {
	//require_once __DIR__ . '/helperv2.php';
	require_once (JPATH_SITE.'/modules/mod_j2store_products/helperv2.php');
}

$list = ModJ2StoreProductsHelper::getList($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
//important module id
$module_id = $module->id;  // module id
require JModuleHelper::getLayoutPath('mod_j2store_products', $params->get('layout','default'));
