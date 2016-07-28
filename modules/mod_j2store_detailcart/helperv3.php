<?php
/*------------------------------------------------------------------------
 # mod_j2store_cart - J2Store Cart
# ------------------------------------------------------------------------
# author    Ramesh Elamathi - ThemeParrot http://www.themeparrot.com
# copyright Copyright (C) 2012 ThemeParrot.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
-------------------------------------------------------------------------*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
class modJ2StoreDetailCartHelper {

	public  static  $_order;
	public  static  $_taxes;
	public  static $_shipping;
	public  static $_coupons;
	public  static $_vouchers;


	public static function getItems(){
		$app = JFactory::getApplication();
		$cart_order ;
		$cart_items;

		$items  =F0FModel::getTmpInstance('Carts','J2StoreModel')->getItems();
		//trigger plugin events
		$i=0;
		$onDisplayCartItem = array();
		foreach( $items as $item)
		{
			ob_start();
			$app->triggerEvent('onJ2StoreDisplayCartItem', array( $i, $item ) );
			$cartItemContents = ob_get_contents();
			ob_end_clean();
			if (!empty($cartItemContents))
			{
				$onDisplayCartItem[$i] = $cartItemContents;
			}
			$i++;
		}

		$event_onDisplayCartItem =  $onDisplayCartItem;

		$order = F0FModel::getTmpInstance('Orders', 'J2StoreModel')->populateOrder($items)->getOrder();
		$order->validate_order_stock();
		self::$_order = $order;

		$cart_items = $order->getItems();

		foreach($cart_items as $item) {
			if(isset($item->orderitemattributes) && count($item->orderitemattributes)) {
				foreach($item->orderitemattributes as &$attribute) {
					if($attribute->orderitemattribute_type == 'file') {
						unset($table);
						$table = F0FTable::getInstance('Upload', 'J2StoreTable');
						if($table->load(array('mangled_name'=>$attribute->orderitemattribute_value))) {
							$attribute->orderitemattribute_value = $table->original_name;
						}
					}
				}
			}
		}

		self::$_taxes = $order->getOrderTaxrates();
		self::$_shipping = $order->getOrderShippingRate();
		self::$_coupons = $order->getOrderCoupons();
		self::$_vouchers = $order->getOrderVouchers();


		return $cart_items;
	}
	private static function getTotals() {

	}


	public static function getCountryName($country_id){
		$session = JFactory::getSession();
		$db = JFactory::getDbo();
		$query=$db->getQuery(true);
		$query->select("country_name")->from("#__j2store_countries");
		$query->where("j2store_country_id=".$db->q($country_id));
		$db->setQuery($query);
		return $db->loadResult();
	}

	public static function getZoneName($country_id,$zone_id){
		$db = JFactory::getDbo();
		$query=$db->getQuery(true);
		$query->select("zone_name")->from("#__j2store_zones");
		$query->where("country_id=".$db->q($country_id));
		$query->where("j2store_zone_id=".$db->q($zone_id));
		$db->setQuery($query);
		return $db->loadResult();
	}

	public function getValidShippingMethodAjax(){

	}

	public function getEstimatedshippingAjax(){

	}

}