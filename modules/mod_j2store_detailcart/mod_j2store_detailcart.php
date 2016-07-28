<?php
/*------------------------------------------------------------------------
 # mod_j2store_detailcart - J2Store Cart
# ------------------------------------------------------------------------
# author    Ramesh Elamathi - ThemeParrot http://www.themeparrot.com
# copyright Copyright (C) 2012 ThemeParrot.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
-------------------------------------------------------------------------*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
//require_once (dirname(__FILE__).DS.'helper.php');
$session = JFactory::getSession();
$doc = JFactory::getDocument();
$doc->addStyleSheet(JUri::root(true).'/modules/mod_j2store_detailcart/css/detailcart.css');
$doc->addScript(JUri::root(true).'/media/j2store/js/j2store.js');

include_once (JPATH_ADMINISTRATOR.'/components/com_j2store/version.php');
if(version_compare(J2STORE_VERSION, '3.0.0', 'ge')) {
	if (!defined('F0F_INCLUDED'))
	{
		include_once JPATH_LIBRARIES . '/f0f/include.php';
	}
	//we are using latest version.
	require_once (JPATH_SITE.'/modules/mod_j2store_detailcart/helperv3.php');
	require_once  JPATH_ADMINISTRATOR.'/components/com_j2store/helpers/j2html.php';

	$main_params = J2Store::config();
	$store_item = J2Store::storeProfile();
	$currency = J2Store::currency();
	$store_country_id = $store_item->get('country_id');
	$store_zone_id = $store_item->get('zone_id');
	$store_postcode = $store_item->get('postcode');
	$order = array();
	$items = modJ2StoreDetailCartHelper::getItems();

} else {
	require_once (JPATH_SITE.'/modules/mod_j2store_detailcart/helperv2.php');
	$store_item = J2StoreHelperCart::getStoreAddress();
	$store_country_id = (isset($store_item->country_id)) ?  $store_item->country_id : "";
	$store_zone_id = (isset($store_item->zone_id)) ? $store_item->zone_id : "";
	$store_postcode = (isset($store_item->store_zip)) ? $store_item->store_zip : "";


	// Instantiate global document object
	$doc = JFactory::getDocument();

	$js = <<<JS
	(function ($) {
	$(document).on('click', '#modj2storedetailcart', function () {
	$(".j2store-mdc-error").remove();
	request = {
	'option' : 'com_ajax',
	'module' : 'j2store_detailcart',
	'method' : 'getValidShippingMethod',
	'format' : 'json'
	};
	$.ajax({
	type : 'POST',
	data : request,
	dataType:'json',
	success: function (json) {
	if(json['error']){
			$('.mod-j2storedetailcart-status').html('<p class="j2store-mdc-error text text-warning">'+json['error']['msg']+'</p>');
		}else if(json['link']){
			window.location = json['link'];
		}
	  }
	});
	return false;
	});
	})(jQuery)
JS;
	$doc->addScriptDeclaration($js);

}


$moduleclass_sfx = $params->get('moduleclass_sfx','');
$shipping_method = $session->get('shipping_method', array(), 'j2store');
if($params->get('show_checkout', 1) == 1) {
	//always show checkout
	$show_checkout = true;
} elseif($params->get('show_checkout', 1) == 2) {
	//show only if a shipping method is chosen
	if(isset($shipping_method) && count($shipping_method)) {
		$show_checkout = true;
	} else {
		$show_checkout = false;
	}
}

//
if($session->has('shipping_country_id', 'j2store')){
	$country_id = $session->get('shipping_country_id', '', 'j2store');
}else{
	$country_id = $store_country_id;
}
//check shipping zone id set in the session
if($session->has('shipping_zone_id', 'j2store')){
	$zone_id = $session->get('shipping_zone_id', '', 'j2store');
}else{
	//get the zone id from the store
	$zone_id = $store_zone_id;
}

//check incase Shipping Postcode not set in the session
if($session->has('shipping_postcode','j2store')){
	$postcode = $session->get('shipping_postcode','', 'j2store');
}else{
//get the postcode id from the store
	$postcode =$store_postcode;
}

$items = modJ2StoreDetailCartHelper::getItems();
if(version_compare(J2STORE_VERSION, '3.0.0', 'ge')) {
	$countries = F0FModel::getTmpInstance('Countries','J2StoreModel')->getList();
	$zones = F0FModel::getTmpInstance('Zones','J2StoreModel')->country_id($country_id)->getList();
	$country_name = F0FModel::getTmpInstance('Countries','J2StoreModel')->getItem($country_id)->country_name;
	$zone_name = F0FModel::getTmpInstance('Zones','J2StoreModel')->getItem($zone_id)->zone_name;
}else{
	$countries = modJ2StoreDetailCartHelper::getCountryList();
	$zones = modJ2StoreDetailCartHelper::getZoneList($country_id);
	$country_name = modJ2StoreDetailCartHelper::getCountryName($country_id);
	$zone_name = modJ2StoreDetailCartHelper::getZoneName($country_id, $zone_id);
}

require( JModuleHelper::getLayoutPath('mod_j2store_detailcart',$params->get('layout', 'default')));
