<?php
/**
 * @package J2Store
* @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
* @license GNU GPL v3 or later
*/
// No direct access to this file
defined ( '_JEXEC' ) or die ();

defined('_JEXEC') or die('Restricted access');

require_once (JPATH_ADMINISTRATOR.'/components/com_j2store/library/plugins/shipping.php');
require_once (JPATH_ADMINISTRATOR.'/components/com_j2store/library/base.php');
require_once (JPATH_ADMINISTRATOR.'/components/com_j2store/library/tax.php');
require_once (JPATH_SITE.'/components/com_j2store/helpers/utilities.php');
require_once (JPATH_SITE.'/components/com_j2store/helpers/cart.php');

class plgJ2StoreShipping_Usps extends J2StoreShippingPlugin
{
	/**
	 * @var $_element  string  Should always correspond with the plugin's filename,
	 *                         forcing it to be unique
	 */
    var $_element   = 'shipping_usps';
    private $_isLog      = false;
	private $usps_username = '';
	private $usps_password = '';

    function __construct($subject, $config) {
    	parent::__construct($subject, $config);
    	$this->usps_username = trim($this->params->get('usps_username', ''));
    	$this->usps_password = trim($this->params->get('usps_password', ''));
    	$this->_isLog      = $this->params->get('show_debug')?true:false;
    }

	/**
	 * Method to get shipping rates from the USPS
	 *
	 * @param string $element
	 * @param object $order
	 * @return an array of shopping rates
	 */

   function onJ2StoreGetShippingRates($element, $order)
    {
    	$rates = array();
    	//initialise system variables
    	$app = JFactory::getApplication();
    	$db = JFactory::getDbo();

    	// Check if this is the right plugin
    	if (!$this->_isMe($element))
        {
            return $rates;
        }

        //set the address
        $order->setAddress();

        //get the shipping address
        $address = $order->getShippingAddress();

        $geozone_id = $this->params->get('usps_geozone', 0);

        //get the geozones
		$query = $db->getQuery(true);
		$query->select('gz.*,gzr.*')->from('#__j2store_geozones AS gz')
			->leftJoin('#__j2store_geozonerules AS gzr ON gzr.geozone_id = gz.geozone_id')
			->where('gz.geozone_id='.$geozone_id)
			->where('gzr.country_id='.$db->q($address['country_id']).' AND (gzr.zone_id=0 OR gzr.zone_id='.$db->q($address['zone_id']).')');
		$db->setQuery($query);
		$grows = $db->loadObjectList();

		if (!$geozone_id) {
			$status = true;
		} elseif ($grows) {
			$status = true;
		} else {
			$status = false;
		}

		if ($status) {
			$rates = $this->getRates($address);
		}
		//print_r($rates);
    	return $rates;
    }

    /**
     * Method to get rates from the USPS shipping API
     *
     * @param array $address
     * @return array rates array
     */

    private function getRates($address) {

    	$rates = array();
    	$status = true;

    	$shipping_status = false;
    	//first check if shippable items are in cart
    	JModelLegacy::addIncludePath( JPATH_SITE.'/components/com_j2store/models' );
    	$model = JModelLegacy::getInstance( 'Mycart', 'J2StoreModel');
    	$products = $model->getDataNew();
    	foreach ($products as $product) {
    		if ($product['shipping']) {
    			$shipping_status = true;
    		}
    	}

    	if($shipping_status === false) return $rates;

    	$currencyObject = J2StoreFactory::getCurrencyObject();
    	$store_address = J2StoreHelperCart::getStoreAddress();

    	$domestic_services = $this->params->get('domestic_services');
    	$inernational_services = $this->params->get('international_services');
    	$quote_data = array();
    	$method_data = array();

    	$cart_weight_total = J2StoreHelperCart::getWeight();

    	$weightObject = J2StoreFactory::getWeightObject();
    	$weight = $weightObject->convert($cart_weight_total, $store_address->config_weight_class_id, $this->params->get('usps_weight_class_id'));

    	$weight = ($weight < 0.1 ? 0.1 : $weight);
    	$pounds = floor($weight);
    	$ounces = round(16 * ($weight - $pounds), 2); // max 5 digits

    	$postcode = str_replace(' ', '', $address['postal_code']);

    	//get country data
    	$countryObject = $this->getCountry($address['country_id']);

    	if ($countryObject->country_isocode_2 == 'US') {
    		$xml  = '<RateV4Request USERID="' . $this->usps_username . '">';
    		$xml .= '	<Package ID="1">';
    		$xml .=	'		<Service>ALL</Service>';
    		$xml .=	'		<ZipOrigination>' . substr($this->params->get('usps_postcode'), 0, 5) . '</ZipOrigination>';
    		$xml .=	'		<ZipDestination>' . substr($postcode, 0, 5) . '</ZipDestination>';
    		$xml .=	'		<Pounds>' . $pounds . '</Pounds>';
    		$xml .=	'		<Ounces>' . $ounces . '</Ounces>';

    		// Prevent common size mismatch error from USPS (Size cannot be Regular if Container is Rectangular for some reason)
    		if ($this->params->get('usps_container') == 'RECTANGULAR' && $this->params->get('usps_size') == 'REGULAR') {
    			$this->params->set('usps_container', 'VARIABLE');
    		}

    		$xml .=	'		<Container>' . $this->params->get('usps_container') . '</Container>';
    		$xml .=	'		<Size>' . $this->params->get('usps_size') . '</Size>';
    		$xml .= '		<Width>' . $this->params->get('usps_width') . '</Width>';
    		$xml .= '		<Length>' . $this->params->get('usps_length') . '</Length>';
    		$xml .= '		<Height>' . $this->params->get('usps_height') . '</Height>';

    		// Calculate girth based on usps calculation
    		$xml .= '		<Girth>' . (round(((float)$this->params->get('usps_length') + (float)$this->params->get('usps_width') * 2 + (float)$this->params->get('usps_height') * 2), 1)) . '</Girth>';


    		$xml .=	'		<Machinable>' . ($this->params->get('usps_machinable') ? 'true' : 'false') . '</Machinable>';
    		$xml .=	'	</Package>';
    		$xml .= '</RateV4Request>';

    		$request = 'API=RateV4&XML=' . urlencode($xml);
    	}else {
    		$countries = $this->getCountries();
    		if (isset($countries[$countryObject->country_isocode_2])) {
    			$xml  = '<IntlRateV2Request USERID="' . $this->usps_username . '">';
    			$xml .=	'	<Package ID="1">';
    			$xml .=	'		<Pounds>' . $pounds . '</Pounds>';
    			$xml .=	'		<Ounces>' . $ounces . '</Ounces>';
    			$xml .=	'		<MailType>All</MailType>';
    			$xml .=	'		<GXG>';
    			$xml .=	'		  <POBoxFlag>N</POBoxFlag>';
    			$xml .=	'		  <GiftFlag>N</GiftFlag>';
    			$xml .=	'		</GXG>';
    			$xml .=	'		<ValueOfContents>' . J2StoreHelperCart::getSubTotal() . '</ValueOfContents>';
    			$xml .=	'		<Country>' . $countries[$countryObject->country_isocode_2] . '</Country>';

    			// Intl only supports RECT and NONRECT
    			if ($this->params->get('usps_container') == 'VARIABLE') {
    				$this->params->set('usps_container', 'NONRECTANGULAR');
    			}

    			$xml .=	'		<Container>' . $this->params->get('usps_container') . '</Container>';
    			$xml .=	'		<Size>' . $this->params->get('usps_size') . '</Size>';
    			$xml .= '		<Width>' . $this->params->get('usps_width') . '</Width>';
    			$xml .= '		<Length>' . $this->params->get('usps_length') . '</Length>';
    			$xml .= '		<Height>' . $this->params->get('usps_height') . '</Height>';
    			$xml .= '		<Girth>' . $this->params->get('usps_girth') . '</Girth>';
    			$xml .= '		<CommercialFlag>N</CommercialFlag>';
    			$xml .=	'	</Package>';
    			$xml .=	'</IntlRateV2Request>';

    			$request = 'API=IntlRateV2&XML=' . urlencode($xml);
    		} else {
    			$status = false;
    		}
    	}

    	if ($status) {

    		$result = $this->_sendRequest($request);
    		$handling = $this->params->get('handling', '0');
    		if ($result) {
    			if ($this->params->get('show_debug')) {
    				$this->_log("USPS DATA SENT: " . urldecode($request));
    				$this->_log("USPS DATA RECV: " . $result);
    			}

    			$dom = new DOMDocument('1.0', 'UTF-8');
    			$dom->loadXml($result);
    			$rate_response = $dom->getElementsByTagName('RateV4Response')->item(0);
    			$intl_rate_response = $dom->getElementsByTagName('IntlRateV2Response')->item(0);
    			$error = $dom->getElementsByTagName('Error')->item(0);

    			$firstclasses = array (
    					'First-Class Mail Parcel',
    					'First-Class Mail Large Envelope',
    					'First-Class Mail Letter',
    					'First-Class Mail Postcards'
    			);

    			if ($rate_response || $intl_rate_response) {

    				if ($countryObject->country_isocode_2 == 'US') {
    					$allowed = array(0, 1, 2, 3, 4, 5, 6, 7, 12, 13, 16, 17, 18, 19, 22, 23, 25, 27, 28, 30, 31, 55, 56, 62,63);

    					$package = $rate_response->getElementsByTagName('Package')->item(0);

    					$postages = $package->getElementsByTagName('Postage');

    					if ($postages->length) {
    						foreach ($postages as $postage) {
    							$classid = $postage->getAttribute('CLASSID');

    							if (in_array($classid, $allowed)) {
    								if ($classid == '0') {
    									$mailservice = $postage->getElementsByTagName('MailService')->item(0)->nodeValue;

    									foreach ($firstclasses as $k => $firstclass)  {
    										if ($firstclass == $mailservice) {
    											$classid = $classid . $k;
    											break;
    										}
    									}

    									if (in_array('usps_domestic_' . $classid, $domestic_services)) {
    										$cost = $postage->getElementsByTagName('Rate')->item(0)->nodeValue;
    										$price = $currencyObject->convert($cost, 'USD', $store_address->config_currency);
    										$rate = array();
    										$rate['name']    = $postage->getElementsByTagName('MailService')->item(0)->nodeValue;
    										$rate['code']    = 'usps.' . $classid;
    										$rate['price']   = $price ;
    										$rate['extra']   = (float)$handling;
    										$rate['total']   = $price;
    										$rate['tax']     = "0.00";
    										$rate['element'] = $this->_element;
    										$rates[] = $rate;
    									}

    								} elseif (in_array('usps_domestic_' . $classid, $domestic_services)) {
    									$cost = $postage->getElementsByTagName('Rate')->item(0)->nodeValue;
    									$price = $currencyObject->convert($cost, 'USD', $store_address->config_currency);

    									$rate = array();
    									$rate['name']    = $postage->getElementsByTagName('MailService')->item(0)->nodeValue;
    									$rate['code']    = 'usps.' . $classid;
    									$rate['price']   = $price ;
    									$rate['extra']   = (float)$handling;
    									$rate['total']   = $price;
    									$rate['tax']     = "0.00";
    									$rate['element'] = $this->_element;
    									$rates[] = $rate;
    								}
    							}
    						}
    					} else {
    						$error = $package->getElementsByTagName('Error')->item(0);

    						$method_data = array(
    								'code'       => 'usps',
    								'title'      => JText::_('usps_error_text'),
    								'quote'      => $quote_data,
    								'error'      => $error->getElementsByTagName('Description')->item(0)->nodeValue
    						);
    					}
    				} else {
    					$allowed = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16,17,18,19,20,21,22,
								23,
								24,
								25,
								26,
								27
						);

						$package = $intl_rate_response->getElementsByTagName ( 'Package' )->item ( 0 );

						$services = $package->getElementsByTagName ( 'Service' );
						if (isset ( $inernational_services ) && ! empty ( $inernational_services )) {

							foreach ( $services as $service ) {
								$id = $service->getAttribute ( 'ID' );

								if (in_array ( $id, $allowed ) && in_array ( 'usps_international_' . $id, $inernational_services )) {
									$title = $service->getElementsByTagName ( 'SvcDescription' )->item ( 0 )->nodeValue;

									if ($this->params->get ( 'usps_display_time' )) {
										$title .= ' (' . JText::_ ( 'usps_text_eta' ) . ' ' . $service->getElementsByTagName ( 'SvcCommitments' )->item ( 0 )->nodeValue . ')';
									}

									$cost = $service->getElementsByTagName ( 'Postage' )->item ( 0 )->nodeValue;
									$price = $currencyObject->convert ( $cost, 'USD', $store_address->config_currency );

									$rate = array ();
									$rate ['name'] = $title;
									$rate ['code'] = 'usps.' . $id;
    							$rate['price']   = $price ;
    							$rate['extra']   = (float)$handling;
    							$rate['total']   = $price;
    							$rate['tax']     = "0.00";
    							$rate['element'] = $this->_element;
    							$rates[] = $rate;
    						}
    					}

						}
    				}
    			} elseif ($error) {
    				$method_data = array(
    						'code'       => 'usps',
    						'title'      => JText::_('usps_error_text'),
    						'quote'      => $quote_data,
    						'error'      => $error->getElementsByTagName('Description')->item(0)->nodeValue
    				);
    			}
    		}
    	}

    	if(count($rates)) {
	    	//if the shipping is taxable, calculate it here.
	    	$tax_class_id = $this->params->get('usps_tax_class_id', '');

	    	if($tax_class_id) {
	    		$j2tax = new J2StoreTax();

	    		$newRates = array();
	    		foreach ($rates as $rate) {
	    			$newRate = array();
	    			$newRate['name'] = JText::_($rate['name']);
	    			$newRate['code'] = $rate['code'];
	    			$newRate['price'] = $rate['price'];
	    			$newRate['extra'] = $rate['extra'];
	    			$shipping_method_tax_total = $j2tax->getTax(($newRate['price'] + $newRate['extra']), $tax_class_id);
	    			$newRate['tax'] = round($shipping_method_tax_total, 2);
	    			$newRate['total'] = $rate['total'] + $newRate['tax'];
	    			$newRate['element'] = $rate['element'];
	    			$newRates[] = $newRate;
	    		}
	    		unset($rates);
	    		$rates = $newRates;
	    	}
    	}
    	return $rates;

    }

    /**
     *
     * @param string $request
     * @return mixed
     */

    private function _sendRequest($request) {
    	$url = $this->_getActionUrl();

    	$curl = curl_init();

    	curl_setopt($curl, CURLOPT_URL, $url.'?' . $request);
    	curl_setopt($curl, CURLOPT_HEADER, 0);
    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    	$result = curl_exec($curl);

    	curl_close($curl);

    	// strip reg, trade and ** out 01-02-2011
    	$result = str_replace('&amp;lt;sup&amp;gt;&amp;amp;reg;&amp;lt;/sup&amp;gt;', '', $result);
    	$result = str_replace('&amp;lt;sup&amp;gt;&amp;amp;trade;&amp;lt;/sup&amp;gt;', '', $result);
    	$result = str_replace('&amp;lt;sup&amp;gt;&amp;#8482;&amp;lt;/sup&amp;gt;', '', $result);
    	$result = str_replace('&amp;lt;sup&amp;gt;&amp;#174;&amp;lt;/sup&amp;gt;', '', $result);

    	$result = str_replace('**', '', $result);
    	$result = str_replace("\r\n", '', $result);
    	$result = str_replace('\"', '"', $result);

    	return $result;
    }

    /**
     *
     * @return string USPS shipping API url
     */

    private function _getActionUrl() {

    	if($this->params->get('use_sandbox', '0')) {
    		$url = 'http://stg-production.shippingapis.com/ShippingApi.dll';
    	} else {
    		$url = 'http://production.shippingapis.com/ShippingAPI.dll';
    	}

    	return $url;
    }

    /**
     * Simple logger
     *
     * @param string $text
     * @param string $type
     * @return void
     */
    function _log($text, $type = 'message')
    {
    	if ($this->_isLog) {
    		$file = JPATH_ROOT . "/cache/{$this->_element}.log";
    		$date = JFactory::getDate();

    		$f = fopen($file, 'a');
    		fwrite($f, "\n\n" . $date->format('Y-m-d H:i:s'));
    		fwrite($f, "\n" . $type . ': ' . $text);
    		fclose($f);
    	}
    }


    function getCountries() {
    	$db = JFactory::getDbo();
    	$query = $db->getQuery(true);
    	$query->select('*')->from('#__j2store_countries');
    	$db->setQuery($query);
    	return $db->loadAssocList('country_isocode_2', 'country_name');
    }

    function getCountry($country_id) {
    	$db = JFactory::getDbo();
    	$query = $db->getQuery(true);
    	$query->select('*')->from('#__j2store_countries')->where('country_id='.$db->q($country_id));
    	$db->setQuery($query);
    	return $db->loadObject();
    }
}