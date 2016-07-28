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
//j3 compatibility
if(!defined('DS')){
	define('DS',DIRECTORY_SEPARATOR);
}
jimport('joomla.utilities.date');

require_once (JPATH_ADMINISTRATOR.'/components/com_j2store/library/prices.php');
require_once (JPATH_SITE.'/components/com_j2store/helpers/cart.php');
require_once (JPATH_SITE.'/components/com_j2store/helpers/downloads.php');
jimport('joomla.filesystem.file');
if (version_compare(JVERSION, '3.0', 'lt')) {
	if(JFile::exists(JPATH_LIBRARIES.'/joomla/database/table/content.php')) {
		require_once(JPATH_LIBRARIES.'/joomla/database/table/content.php');
	}
}
class plgContentJ2store extends JPlugin
{

	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage('com_j2store', JPATH_ADMINISTRATOR);
		$this->loadLanguage();
	}

	public function onContentPrepare($context, $article, $params, $page = 0)
	{
		$j2params = JComponentHelper::getParams('com_j2store');
		if($j2params->get('addtocart_placement', 'default') == 'default') {
			return false;
		}

		//print_r($article);

		// simple performance check to determine whether bot should process further
		if (strpos($article->text, 'j2storecart') === false && strpos($article->text, '{j2store}') === false) {
			return true;
		}

		// expression to search for j2storecart
		$regex		= '/{j2storecart\s+(.*?)}/i';
		//$regex		= '/{j2storecart\}/i';

		// Find all instances of plugin and put in $matches for loading j2store cart
		// $matches[0] is full pattern match, $matches[1] is the article id
		preg_match_all($regex, $article->text, $matches, PREG_SET_ORDER);
		// No matches, skip this
		if ($matches) {
			foreach ($matches as $match) {
				//$match[0] has the text.
				//check again

				if (empty($match[1])) {
					break;
				}

				$article_id = (int) $match[1];

				$item = new JObject();
				$item->id = $article_id;
				$item->text = $article->text;
				$output = $this->_loadCart($item, $params);
				$article->text = preg_replace("|$match[0]|", addcslashes($output, '\\$'), $article->text, 1);
			}
		}

		$regex		= '/{j2store}(.*?){\/j2store}/';
		preg_match_all($regex, $article->text, $newmatches, PREG_SET_ORDER);
		if(count($newmatches[0])) {
			foreach($newmatches as $newmatch) {
				if (empty($newmatch[1])) {
					break;
				}
				$values = explode('|', $newmatch[1]);
				//first value should always be the ID.
				if($values[0]) {
					$html = $this->getProduct($values, $article->text);
					$article->text = str_replace($newmatch[0], $html, $article->text);
				}

			}
		}

	}

	function onContentAfterDisplay($option, $item, $params)
	{
		//k2 check
		if(strpos($option, 'com_k2') !== false){
			return '';
		}

		$mainframe = JFactory::getApplication();
		$opt = substr($option,0,11);
		if($opt !='com_content' || empty($item->id)) {
			$output = '';
		}

		$j2params = JComponentHelper::getParams('com_j2store');
		if($j2params->get('addtocart_placement', 'default') == 'tag') {
			$output = '';
		} else {
			$output = $this->_loadCart($item, $params);
		}
		return $output;
	}

	function onContentPrepareForm($form, $data)
	{

		$app = JFactory::getApplication();
		if($app->isSite()) {
			return true;
		}
		if (!($form instanceof JForm))
		{
			$this->_subject->setError('JERROR_NOT_A_FORM');
			return false;
		}

		// Check we are manipulating a valid form.
		$name = $form->getName();

		if (!in_array($name, array('com_content.article'))) {
			return true;
		}

		// Add the registration fields to the form.
		JForm::addFormPath(dirname(__FILE__).'/j2store');
		JForm::addFieldPath(dirname(__FILE__).'/j2store/fields');
		$form->loadFile('j2store', false);

		// Load the data from j2store_prices table into the form
		$articleId = isset($data->id) ? $data->id : 0;

		// Load the price data from the database.
		if($articleId ) {
			$db = JFactory::getDbo();
			$query='SELECT * FROM #__j2store_prices' .
					' WHERE article_id = '.(int) $articleId;
			$db->setQuery($query);

			$price = $db->loadObject();
			// Check for a database error.
			if ($db->getErrorNum())
			{
				$this->_subject->setError($db->getErrorMsg());
				return false;
			}

			if( isset($price) )
			{
				$data->attribs['product_enabled']=$price->product_enabled;
				$data->attribs['item_price']=$price->item_price;
				$data->attribs['special_price']=$price->special_price;
				$data->attribs['item_tax']=$price->item_tax;
				$data->attribs['item_shipping']=$price->item_shipping;
				$data->attribs['item_sku']=$price->item_sku;
			}
			return true;
		}
		return;
	}

	/**
	 * Example after save content method
	 * Article is passed by reference, but after the save, so no changes will be saved.
	 * Method is called right after the content is saved
	 *
	 * @param	string		The context of the content passed to the plugin (added in 1.6)
	 * @param	object		A JTableContent object
	 * @param	bool		If the content is just about to be created
	 *
	 */

	function onContentAfterSave($context, $data, $isNew)
	{

		$app = JFactory::getApplication();
		if($app->isSite()) {
			return true;
		}
		// Check we are manipulating a valid form.
		if (!in_array($context, array('com_content.article'))) {
			return true;
		}
		$articleId = isset($data->id) ? $data->id : 0;

		//no id found, return
		if($articleId == 0) return true;

		// convert the joomla article attributes from json to object

		$attribs = json_decode($data->attribs);
		if($attribs->j2product) {
			JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_j2store/tables');
			$product = JTable::getInstance('Prices','Table');
			$product->load(array('article_id'=>$articleId));

			$product->bind($attribs->j2product);
			$product->article_id = $articleId;
			$product->item_tax = $attribs->item_tax;
			$product->store();
		}

		//now save product stock

		$this->_addProductStock($attribs, $articleId);

		//save metrics
		$this->_addMetrics($attribs, $articleId);

		//save options
		$this->_addProductOptions($attribs, $articleId);

		//save group prices
		$this->_addGroupPrices($attribs,$articleId);

		JPluginHelper::importPlugin('j2store');
		$app->triggerEvent('onJ2StoreAfterSaveProduct', array($attribs, $articleId));

		return true;
	}

	private function _addGroupPrices($attribs,$articleId){
		//check if empty article id
		if(!$articleId) return;

		if(!isset($attribs->cgroupprice)) return;

		JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_j2store/tables');
		//get the group prices
		$group_prices = $attribs->cgroupprice->group_price;
		$row  = JTable::getInstance('groupprice','Table');
 		foreach($group_prices as $gp){
 			$gp->product_id = $articleId;
			try{
					$row->save($gp);
				}catch(Exception $e){

					return;
				}
	 		}
		return true;
	}

	private function _addProductStock($attribs, $articleId) {

		//no arti
		if(!$articleId) return;

		//first get the array
		$stock = $attribs->item_stock;
		//get the table
		$row = JTable::getInstance('Prices', 'Table');
		try {
			$row->load(array('article_id'=>$articleId));
		}catch (Exception $e) {
			//do nothing. It may be a new record
		}

		//bind the data
		try {
			$row->bind($stock);
		}catch (Exception $e) {
			//no data found. so return
			return;
		}


		//now we need to see if the checkboxes are not set. If not, then we got to zero them
		if(!isset($stock->use_store_config_min_out_qty)) {
			$row->use_store_config_min_out_qty = 0;
		}

		if(!isset($stock->use_store_config_min_sale_qty)) {
			$row->use_store_config_min_sale_qty = 0;
		}

		if(!isset($stock->use_store_config_max_sale_qty)) {
			$row->use_store_config_max_sale_qty = 0;
		}

		if(!isset($stock->use_store_config_notify_qty)) {
			$row->use_store_config_notify_qty = 0;
		}

		try {
			$row->store();
		}catch (Exception $e) {
			//no data found. so return
			return;
		}

	}

	/**
	 * Remove all item price information for the given article ID from j2store-price table
	 *
	 * Method is called before article data is deleted from the database
	 *
	 * @param	string	The context for the content passed to the plugin.
	 * @param	object	The data relating to the content that was deleted.
	 */
	function onContentAfterDelete($context, $data)
	{
		$articleId = isset($data->id) ? $data->id : 0;

		//$articleId	= JArrayHelper::getValue($data, 'id', 0, 'int');

		if ($articleId)
		{
			try
			{
				$db = JFactory::getDbo();
				$db->setQuery('DELETE FROM #__j2store_prices WHERE article_id = '.$articleId );

				if (!$db->query()) {
					throw new Exception($db->getErrorMsg());
				}
			}
			catch (JException $e)
			{
				$this->_subject->setError($e->getMessage());
				return false;
			}
		}
		return true;
	}

	protected function _loadCart($item, $article_params) {

		$lang = JFactory::getLanguage();
		$lang->load('com_j2store');
		$j2params = JComponentHelper::getParams('com_j2store');

		if(empty($item->id) || is_int($item->id == false)) {
			return '';
		}

		$product_enabled = J2StorePrices::getItemEnabled($item->id);

		if ($product_enabled == 1 ) {
			$this->_updateCurrency();
			$content = '';
			$content = J2StoreHelperCart::getAjaxCart($item);
			$output = $content;
		} else {
			$output = '';
		}

		//free file attachments
		$freefiles = J2StoreDownloads::getDownloadHtml($item->id);
		$output = $freefiles.$output;
		return $output;
	}

	private function getProduct($values, $text) {

		$html = '';

		$product_id = $values[0];
		$product_enabled = J2StorePrices::getItemEnabled($product_id);
		if(!$product_enabled) return $html;

		$this->_updateCurrency();
		if(in_array('price', $values)) {
			$prices = J2StorePrices::getPrice($product_id);
			$html .= '<span class="j2store-product-price">';
			$html .= J2StorePrices::number($prices->product_price);
			$html .= '</span>';
		}
		return $html;

	}

	function _updateCurrency() {
		$session = JFactory::getSession();
		//if auto update currency is set, then call the update function
		$store_config = J2StoreHelperCart::getStoreAddress();

		//session based check. We dont want to update currency when we load each and every item.
		if($store_config->config_currency_auto && !$session->has('currency_updated', 'j2store')) {
			require_once (JPATH_ADMINISTRATOR.'/components/com_j2store/models/currencies.php');
			$currency_model = new J2StoreModelCurrencies();
			$currency_model->updateCurrencies();
			$session->set('currency_updated', '1', 'j2store');
		}

	}

	function _addProductOptions($attribs, $product_id) {
		JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_j2store/tables');


		//get option IDs and save them as product option ids
		$pa_options = isset($attribs->item_options->product_option_ids)?$attribs->item_options->product_option_ids:null;
		//get whether the option is required.
		$pa_option_required = isset($attribs->item_options->product_option_required)?$attribs->item_options->product_option_required:null;

		if(isset($pa_options) && count($pa_options) && isset($pa_option_required) ) {

			//convert option required values object to array
			$registry = new JRegistry;
			$registry->loadObject($pa_option_required );
			$pa_option_required = $registry->toArray();

			foreach ($pa_options as $option_id) {
				$table =  JTable::getInstance('ProductOptions', 'Table');
				//save this stock in the product quantities table.
				$table->product_id = $product_id;
				$table->option_id = $option_id;
				if($pa_option_required[$option_id]) {
					$table->required = 1;
				} else {
					$table->required = 0;
				}
				$table->store();
			}

		}

		//if user modified his option preferences, we got to get the changes and save them as well.
		$modified_option_required = $attribs->item_options->product_option_required_save;
		if(isset($modified_option_required) && count($modified_option_required ) ) {
			foreach($modified_option_required as $po_id=>$value) {
				$item =  JTable::getInstance('ProductOptions', 'Table');
				$item->load($po_id);
				$item->required = $value;
				$item->store();
			}
		}


	}

	function _addMetrics($attribs, $product_id) {

		if(!empty($product_id) && $product_id > 0) {
			JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_j2store/tables');
			$row = JTable::getInstance('Prices','Table');
			$row->load(array('article_id'=>$product_id));
			//save metrics
			if(isset($attribs->item_metrics) && is_object($attribs->item_metrics)) {
				$metrics = 	$attribs->item_metrics;
				$data = JArrayHelper::fromObject($metrics);

				$data['price_id'] = $row->price_id;
				$row = JTable::getInstance('prices','Table');
				$row->bind($data);
				$row->store();
			}
		}


	}

}