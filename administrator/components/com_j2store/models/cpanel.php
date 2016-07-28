<?php
/*------------------------------------------------------------------------
# com_j2store - J2Store
# ------------------------------------------------------------------------
# author    Ramesh Elamathi - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2014 - 19 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/



// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');

/**
 *
 * @package		Joomla
 * @subpackage	J2Store
 * @since 2.5
 */
class J2StoreModelCpanel extends J2StoreModel
{

	public function checkCurrency() {

		$db = JFactory::getDbo();
		require_once(JPATH_SITE.'/components/com_j2store/helpers/cart.php');
		$storeProfile = J2StoreHelperCart::getStoreAddress();

		//first check if the currency table has a default records at least.
		$query = $db->getQuery(true)->select('*')->from('#__j2store_currency');
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		if(count($rows) < 1) {
			//no records found. Dumb default data
			JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_j2store/tables');
			$item = JTable::getInstance('Currency', 'Table');
			$item->currency_title = 'US Dollar';
			$item->currency_code = 'USD';
			$item->currency_position = 'pre';
			$item->currency_symbol = '$';
			$item->currency_num_decimals = '2';
			$item->currency_decimal = '.';
			$item->currency_thousands = ',';
			$item->currency_value = '1.00000'; //default currency is one always
			$item->currency_modified = JFactory::getDate()->toSql();
			$item->state = 1;
			$item->store();
		}

		$query = $db->getQuery(true)->select('*')->from('#__j2store_currency')->where('currency_value='.$db->q('1.00000'));
		$db->setQuery($query);
		try {
		$currency = $db->loadObject();
		}catch(Exception $e) {
			//do nothing
		}
		//if currency is empty, set it
		if(empty($storeProfile->config_currency) || JString::strlen($storeProfile->config_currency) < 3) {
			if($currency) {
				$sql = $db->getQuery(true)->update('#__j2store_storeprofiles')->set('config_currency='.$db->q($currency->currency_code))
				->where('store_id='.$db->q($storeProfile->store_id));
				$db->setQuery($sql);
				$db->execute();
			}
		}
		
		//check for a default layout. If not, create one.
		$query = $db->getQuery(true)->select('*')->from('#__j2store_layouts')->where('state=1');
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		
		if(count($rows) < 1) {
			//no records found. Dumb default data
			JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_j2store/tables');
			$item = JTable::getInstance('Layout', 'Table');
			$item->layout_name = 'Default Layout';
			$item->state = 1;
			$item->store();
		}
		
		return true;
	}
	
	function fixIndexes() {
	
		$db = JFactory::getDbo();
	
		//geozone rules
		$db->setQuery('SHOW INDEX FROM #__j2store_geozonerules');
		$indexes = $db->loadObjectList();
		$indexExists = false;
		foreach ($indexes as $index)
		{
			if ($index->Key_name == 'georule')
				$indexExists = true;
		}
	
		if(!$indexExists) {
	
			$db->setQuery('ALTER TABLE `#__j2store_geozonerules` ADD UNIQUE INDEX `georule` ( `geozone_id` , `country_id` , `zone_id` )');
			try {
				$db->execute();
			} catch (Exception $e) {
				//return nothing
			}
		}
	
	
		//geozone rules
		$db->setQuery('SHOW INDEX FROM #__j2store_taxrules');
		$indexes = $db->loadObjectList();
		$indexExists = false;
		foreach ($indexes as $index)
		{
			if ($index->Key_name == 'taxrule')
				$indexExists = true;
		}
	
		if(!$indexExists) {
	
			$db->setQuery('ALTER TABLE `#__j2store_taxrules` ADD UNIQUE INDEX `taxrule` ( `taxprofile_id` , `taxrate_id` , `address` )');
			try {
				$db->execute();
			} catch (Exception $e) {
				//return nothing
			}
		}
	
	}

}