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
require_once(JPATH_SITE.'/components/com_j2store/helpers/cart.php');
require_once (JPATH_ADMINISTRATOR.'/components/com_j2store/library/tax.php');
class modJ2StoreDetailCartHelper {

	public static function getItems() {
		if(!class_exists('J2StoreModelMyCart')){
			require_once(JPATH_SITE.'/components/com_j2store/models/mycart.php');
		}
		$mycart_model = new J2StoreModelMyCart();
		$items=$mycart_model->getTotals();
		if (empty($items)) {
			return array();
		}
		$items =  self::processItems($items);
		return $items;

	}
	private static function processItems($items) {

		$session = JFactory::getSession();
		if(!class_exists('J2StoreModelCheckout')){
			require_once(JPATH_SITE.'/components/com_j2store/models/checkout.php');
		}
		$cart_model = new J2StoreModelMyCart();
		$checkout_model = new J2StoreModelCheckout();
		$tax = new J2StoreTax();
		$params = JComponentHelper::getParams('com_j2store');
		$totals = array();
		$totals['products'] = array();

		foreach ($items['products'] as $product) {
			$product_total = 0;

			foreach ($items['products'] as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}
			//options
			$option_data = array();

			foreach ($product['option'] as $option) {

				$value = $option['option_value'];
				$option_sku = isset($option['option_sku'])?$option['option_sku']:'';
				$option_data[] = array(
						'name'  => $option['name'],
						'option_sku'  => $option_sku,
						'value' => $value
				);
			}

			// Display prices
			$price = $tax->calculate($product['price'], $product['tax_profile_id'], $params->get('show_tax_total'));

			$total = $tax->calculate($product['price'], $product['tax_profile_id'], $params->get('show_tax_total')) * $product['quantity'];

			$tax_amount = '';
			$totals['products'][] = array(
					'key'      => $product['key'],
					'product_id'     => $product['product_id'],
					'product_name'     => $product['name'],
					'product_model'    => $product['model'],
					'product_options'   => $option_data,
					'quantity' => $product['quantity'],
					'price'    => $price,
					'total'    => $total
			);

		}
		unset($items['products']);
		$items['products'] =$totals['products'];

		$showShipping = false;
		if ($isShippingEnabled = $cart_model->getShippingIsEnabled())
		{
			$showShipping = true;
		}

		if($showShipping)
		{
			$rates = $checkout_model->getShippingRates();
			$session->set('shipping_methods', $rates, 'j2store');
			if(count($rates) < 1) {
				$session->set('shipping_method', array(), 'j2store');
			}
		}
		return $items;

	}

	private static function getTotals() {
		$app = JFactory::getApplication();
		$session = JFactory::getSession();
		$tax = new J2StoreTax();
		JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_j2store/models');
		$model = JModelLegacy::getInstance('Mycart', 'J2StoreModel');
		$products =$model->getDataNew();
		$total_data = array();
		$total = 0;

		//products
		$total_data['products'] = $products;

		//sub total
		$total_data['subtotal'] = J2StoreHelperCart::getSubtotal();
		$total +=$total_data['subtotal'];
		//taxes
		$tax_data = array();
		$taxes = J2StoreHelperCart::getTaxes();

		//coupon
		if($session->has('coupon', 'j2store')) {
			$coupon_info = J2StoreHelperCart::getCoupon($session->get('coupon', '', 'j2store'));

			if ($coupon_info) {
				$discount_total = 0;

				if (!$coupon_info->product) {
					$sub_total =J2StoreHelperCart::getSubTotal();
				} else {
					$sub_total = 0;
					foreach ($products as $product) {
						if (in_array($product['product_id'], $coupon_info->product)) {
							$sub_total += $product['total'];
						}
					}
				}

				if ($coupon_info->value_type == 'F') {
					$coupon_info->value = min($coupon_info->value, $sub_total);
				}

				foreach ($products as $product) {
					$discount = 0;

					if (!$coupon_info->product) {
						$status = true;
					} else {
						if (in_array($product['product_id'], $coupon_info->product)) {
							$status = true;
						} else {
							$status = false;
						}
					}

					if ($status) {
						if ($coupon_info->value_type == 'F') {
							$discount = $coupon_info->value * ($product['total'] / $sub_total);
						} elseif ($coupon_info->value_type == 'P') {
							$discount = $product['total'] / 100 * $coupon_info->value;
						}

						if ($product['tax_profile_id']) {

							$tax_rates = $tax->getRateArray($product['total'] - ($product['total'] - $discount), $product['tax_profile_id']);
							foreach ($tax_rates as $tax_rate) {
								//	if ($tax_rate['value_type'] == 'P') {
								$taxes[$tax_rate['taxrate_id']] -= $tax_rate['amount'];
								//	}
							}
						}
					}

					$discount_total += $discount;
				}

				$total_data['coupon'] = array(
						'title'      => JText::sprintf('J2STORE_COUPON_TITLE', $session->get('coupon', '', 'j2store')),
						'value'      => -$discount_total
				);

				//$total_data['coupon'] = $coupon_data;
				//less the coupon discount in the total
				$total -= $discount_total;
			}

		}

		$total_data['total_without_tax'] = $total;

		//taxes
		foreach ($taxes as $key => $value) {
			if ($value > 0) {
				$tax_data[]= array(
						'title'      => $tax->getRateName($key),
						'value'      => $value
				);
				$total += $value;
			}
		}
		$total_data['taxes'] = $tax_data;

		$total_data['total'] = $total;

		return $total_data;
	}

	public static function getCountryList(){
		$db = JFactory::getDbo();
		$query=$db->getQuery(true);
		$query->select("*")->from("#__j2store_countries");
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	public static function getZoneList($country_id){

		$db = JFactory::getDbo();
		$query=$db->getQuery(true);
		$query->select("*")->from("#__j2store_zones");
		$query->where("country_id=".$db->q($country_id));
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	public static function getCountryName($country_id){
		$session = JFactory::getSession();
		$db = JFactory::getDbo();
		$query=$db->getQuery(true);
		$query->select("country_name")->from("#__j2store_countries");
		$query->where("country_id=".$db->q($country_id));
		$db->setQuery($query);
		return $db->loadResult();
	}

	public static function getZoneName($country_id,$zone_id){
		$db = JFactory::getDbo();
		$query=$db->getQuery(true);
		$query->select("zone_name")->from("#__j2store_zones");
		$query->where("country_id=".$db->q($country_id));
		$query->where("zone_id=".$db->q($zone_id));
		$db->setQuery($query);
		return $db->loadResult();
	}

	/**
	 * Method to get Valid Shipping Methods by ajax request
	 *
	 *
	 */
	public function getValidShippingMethodAjax(){

		$session = JFactory::getSession();
		//initliase cart model
		JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_j2store/models');
		$cart_model = new J2StoreModelMyCart();

		//decremental
		$order_ships = false;
		$products = $cart_model->getDataNew();
		foreach($products as $product){
			//check if shipping is enabled for this item
			if(!empty($product['shipping']) ) {
				$order_ships = true;
			}
		}
		//get the list of  shipping methods
		$shipping_methods =$session->get('shipping_methods',array(),'j2store');
		$shpping_method = $session->get('shipping_method',array(),'j2store');
		$shipping_values =$session->get('shipping_values',array(),'j2store');
		$json =array();
		//check product has shipping and shipping method is choosen
		if(isset($order_ships) && $order_ships && isset($shipping_methods) && count($shipping_methods) && isset($shipping_values) && isset($shipping_values['shipping_name']) && $shipping_values['shipping_name']){
			//redirect to cart with the warning msg to select shipping method
			$json['link']=JRoute::_('index.php?option=com_j2store&view=checkout');
		}elseif(count($shipping_methods) < 0){
			$json['error']['msg'] = JText::_('MOD_J2STORE_NO_SHIPPING_METHOD_FOUND');
		}else{
			$json['error']['msg'] = JText::_('MOD_J2STORE_NO_SHIPPING_METHOD_MATCHES');
		}
		echo json_encode($json);
		JFactory::getApplication()->close();
	}

	/**
	 * Method to get shipping Methods after estimate button pressed using ajax call
	 *
	 */
	public function getEstimatedshippingAjax(){
		$session = JFactory::getSession();
		$app = JFactory::getApplication();
		$json =array();
		//get the list of  shipping methods
		$shipping_methods =$session->get('shipping_methods',array(),'j2store');

		if(!count($shipping_methods)){
			$json['error']['msg'] = JText::_('MOD_J2STORE_NO_SHIPPING_METHOD_MATCHES');
		}else{
			$json['success'] = true;
		}
		echo json_encode($json);
		JFactory::getApplication()->close();
	}
}