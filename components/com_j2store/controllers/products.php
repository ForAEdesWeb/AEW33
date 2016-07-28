<?php
/*------------------------------------------------------------------------
 # com_j2store - J2Store
 # ------------------------------------------------------------------------
 # author    Priya Bose  - Weblogicx India http://www.weblogicxindia.com
 # copyright Copyright (C) 2012 Weblogicxindia.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 # Websites: http://j2store.org
 # Technical Support:  Forum - http://j2store.org/forum/index.html
 -------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
require_once (JPATH_SITE.'/components/com_j2store/helpers/cart.php');


class J2StoreControllerProducts extends J2StoreController {


	function display($cachable = false, $urlparams = array()) {
		//initialist system objects
		$app = JFactory::getApplication();
		$document = JFactory::getDocument();
		//get the product view
		$view = $this->getView( 'products', 'html' );

		//get the component params
		$params = JComponentHelper::getParams('com_j2store');

		$option = 'com_j2store';
		$ns = $option.'.products';

		//get the active menu details
		$menu = $app->getMenu()->getActive();

		//now get the params from the menu
		//now check menu-meta_description available
		//if its availble then set tne meta keyword in html doc
		if($menu->params->get('menu-meta_keywords')){
			$document->setMetadata('keywords',$menu->params->get('menu-meta_keywords'));
		}

		//check meta desc available and set into the document
		if($menu->params->get('menu-meta_description')){
			$document->setDescription($menu->params->get('menu-meta_description'));
		}

		//Menu robots
		if ($menu->params->get('robots'))
		{
			$document->setMetadata('robots', $menu->params->get('robots'));
		}

		$uri = JURI::getInstance();
		$document->setMetaData('og:url', $uri->toString());
		$document->setMetaData('og:title', htmlspecialchars($document->getTitle(), ENT_QUOTES, 'UTF-8'));
		$document->setMetaData('og:type', 'article');
		$document->setMetaData('og:description', strip_tags($document->getDescription()));


		// see if a layout has been chosen for this menu
		if(isset($menu->params) && $menu->params->get('j2store_product_layout')) {

			$layoutId = $menu->params->get('j2store_product_layout');

		} else {
			//take it from the store config
			$store = J2StoreHelperCart::getStoreAddress();

			//TODO to set default product layout value incase store product layout is empty
			$layoutId = (isset($store->store_default_layout)) ? $store->store_default_layout :1 ;
		}

		//get the model
		require_once(JPATH_SITE.'/components/com_j2store/models/products.php');
		JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_j2store/models');

		//get the model
		$model = $this->getModel('products');

		$page_limit = ($menu->params->get('page_limit')) ?  $menu->params->get('page_limit') : 20 ;
		$limit		= $app->getUserStateFromRequest( 'global.list.limit', 'limit', $page_limit, 'int' );
		$limitstart	= $app->getUserStateFromRequest( $ns.'.limitstart', 'limitstart', 0, 'int' );

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		//assign the state
		$state = array();
		$state['limit']  	= $limit;
		$state['limitstart'] = $limitstart;

		$state ['search'] = $app->input->getString('search','');
		$state ['filter_order'] = $app->input->getString('filter_order','p.ordering');
		$state ['filter_order_Dir'] =$app->input->getString('filter_order_Dir','ASC');
		$state ['filter_price_from'] =$app->input->getInt('filter_price_from');
		$state ['filter_price_to'] =$app->input->getInt('filter_price_to');
		$state ['filter_category'] = $app->input->getInt('filter_category');
		$state ['category_title'] = $app->input->get('category_title','');
		$state ['filter_sort'] =$app->getUserStateFromRequest( $ns.'filter_sort','filter_sort', '' );

		$state ['filter_tag'] = $app->input->getString('filter_tag', '');
		$state ['filter_tag_title'] = $app->input->getString('filter_tag_title','');

		// using loop set all the state value in the into model state
		foreach($state as $key =>$value) {
			$model->setState($key, $value);
		}

		//get all the items
		$items =$model->getData();

		// get the total
		$total		= $model->getTotal();

		//get the pagination
		$pagination = $model->getPagination();
		$layout_data = $this->getLayoutData($layoutId);
		if(isset($layout_data->params)){
			$layoutparams = new JRegistry();
			$layoutparams->loadString($layout_data->params);
			$view->assign('layoutparams', $layoutparams);
		}


		//to get optionhtml we need to get the processed data having
		//attributes important in displaying the options
		$products = array();
		foreach($items as $item){
			$model->setId($item->product_id);
			$processed_product = $model->getItem();
			$processed_product->optionhtml= $this->getProductOptionHtml($processed_product,$layout_data);
			$products[] = $processed_product;
		}

		$filters = array();

		//sort fields
		$filters['sort_fields'] = $model->getSortFields();


		//get categories
		$filter_categories = $layoutparams->get('product_list_filter_selected_categories');

		//does the menu has categories. If yes, we will have to override it
		//now set the categories
		if($menu->params->get('categories')){
			$filter_categories = $menu->params->get('categories');
		}

        $filters['filter_categories'] = $model->getCategories($filter_categories);

        // sort filter categories to tree
        $filters['filter_tree_categories'] = $model->sortCategories($filters['filter_categories']);

        // load hidden field
        $filters['filter_hidden_categories'] = $menu->params->get('hidden_categories');

		//price filters
		if(isset($items['0']->item_price)) {
			$priceHigh = abs( $items['0']->item_price );
		}else {
			$priceHigh = 0;
		}

		//create link to be concatinated
		//get the highest price
		$priceHigh = abs(  $layoutparams->get('filter_upper_limit', '1000'));

		$upperPrice = $layoutparams->get( 'filter_upper_limit', '1000' );
		$link = '';
		foreach($items as $item){

			//calculate the price low
			$priceLow = ( count($item) == 1 ) ? 0 : abs( $item[count( $item ) - 1]->item_price );

			//calculate the range price high - low price
			$range = ( abs( $priceHigh ) - abs( $priceLow ) )/4;

			//now round the price
			$roundRange = $this->_priceRound($range, $layoutparams->get( 'round_digit', '100' ), true);

			//get the lowest price
			$roundPriceLow = $this->_priceRound( $priceLow, $layoutparams->get( 'round_digit', '100' ) );

			//load the helper base class
			$ranges[$link.'&filter_price_from='.$roundPriceLow.'&filter_price_to='.$roundRange] = J2StorePrices::number($roundPriceLow).' - '.J2StorePrices::number($roundRange);
			$ranges[$link.'&filter_price_from='.$roundRange.'&filter_price_to='.($roundRange*2)] =J2StorePrices::number($roundRange).' - '.J2StorePrices::number( ( $roundRange*2 ) );
			$ranges[$link.'&filter_price_from='.($roundRange*2).'&filter_price_to='.($roundRange*3)] = J2StorePrices::number( ( $roundRange*2 ) ).' - '.J2StorePrices::number( ( $roundRange*3 ) );
			$ranges[$link.'&filter_price_from='.($roundRange*3).'&filter_price_to='.($upperPrice)] = J2StorePrices::number( ( $roundRange*3 ) ).' - '.J2StorePrices::number( $upperPrice );
			$ranges[$link.'&filter_price_from='.$upperPrice] = JText::_('J2STORE_MORE_THAN').J2StorePrices::number( $upperPrice );
			$view->assign('ranges', $ranges);
		}

		//product tags
		if(version_compare(JVERSION ,'3.0','ge')){
			$product_tags = JHtmlTag::tags('com_content');
			$view->assign('product_tags', $product_tags);
		}

		//assign the items in the  view
		$view->assign( 'items', $products);

		//assign the params in the view
		$view->assign('params',$params);


		//assign the state into list
		$view->assign('lists',$state);
		$view->assign('filters',$filters);
		//assign the pagintion
		$view->assign('pagination',$pagination);

		//assign the total
		$view->assign('total',$total);
		$taxClass = new J2StoreTax();
		$view->assign( 'taxClass', $taxClass);
		$view->assign('list_limit',$limit);


		//finally set the layout
		$view->setLayout('list');

		$view->display();
		return;
	}


	function view(){

		//get the app object
		$app = JFactory::getApplication();

		//get the document obj
		$document = JFactory::getDocument();

		//get the component params
		$params = JComponentHelper::getParams('com_j2store');

		//get the model
		$model = $this->getModel('products');

		//get the view
		$view = $this->getView( 'products', 'html' );

		//get the active menu
		$menu = $app->getMenu()->getActive();

		// see if a layout has been chosen for this menu


		/*
		 * TODO showing error when redirecting from list to detailed view product
		*/

		if(isset($menu->params) && $menu->params->get('j2store_product_layout')) {

			$layoutId = $menu->params->get('j2store_product_layout');

		} else {

			//take it from the store config
			$store = J2StoreHelperCart::getStoreAddress();

			//TODO to set default product layout value incase store product layout is empty
			$layoutId = (isset($store->store_default_layout)) ? $store->store_default_layout :1 ;
		}



		//TODO: Remove this
		//$layoutId = 1;

		//get product data
		$product = $model->getItem();


		//get the layout data based on the id
		$layout_data = $this->getLayoutData($layoutId);

		if(isset($layout_data->params)){
			$layoutparams = new JRegistry();
			$layoutparams->loadString($layout_data->params);
			$view->assign('layout_params', $layoutparams);
		}


		//load the product options html
		$product->optionhtml = $this->getProductOptionHtml($product,$layout_data);


		//htmlspecialchars($product->product_name, ENT_QUOTES, 'UTF-8')

		//get the website url
		$uri = JURI::getInstance();

		//now set the url
		$document->setMetaData('og:url', $uri->toString());

		//set the title
		$document->setMetaData('og:title', $product->product_name);

		//set the type
		$document->setMetaData('og:type', 'article');


		$image = (isset($product->main_image) && $product->main_image )  ? $product->main_image  : "";

		//check main image exists
		if(isset($prduct->main_image)){
			$p_image= JURI::root().$image;
			$document->setMetaData('og:image',$p_image);
		}

		//set the descriptionshort_description
		$document->setMetaData('og:description', strip_tags($product->short_description));
		if (isset($product->metakey))
		{
			$document->setDescription($product->metakey);
			$document->setMetadata('keywords', $product->metakey);
		}

		if ($product->metadesc)
		{
			$document->setDescription($product->metadesc);
			$document->setMetadata('keywords',$product->metadesc);
		}

		//now set the metadata into html
		if($product->metadata) {
			$registry = new JRegistry();
			$registry->loadString($product->metadata);
			$mdata= $registry->toArray();
			foreach($mdata as $key =>$value){
				$document->setMetadata($key, $value);
			}
		}


		//assing the model
		$view->assign('model',$model);

		//assign the item
		$view->assign('item', $product);

		//assign the  params
		$view->assign('params',$params);

		//now assisgn the layout
		$view->setLayout('view');
		$view->display();

	}

	function getProductOptionHtml($product,$layout_data) {

		$model = $this->getModel('products');
		$params = JComponentHelper::getParams('com_j2store');

		//get the view
		$view = $this->getView( 'products', 'html' );

		//assign the controller
		$view->set( '_controller', 'products' );

		//assign the view
		$view->set( '_view', 'products' );
		$view->set( '_doTask', true);
		$view->set( 'hidemenu', true);

		//get the tax class
		$taxClass = new J2StoreTax();
		$view->assign('product', $product);
		$view->assign('taxClass', $taxClass);
		$view->assign('attributes', $product->attributes);
		$view->assign('params', $params);
		$view->assign('layout_data',$layout_data);

		$view->setModel( $model, true );
		$view->setLayout('options');

		ob_start();
		$view->display();
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}



	/**
	 * Method to get the Single row from the layouts table
	 * @param int type $layout_id
	 * @result object
	 */
	public function getLayoutData($layout_id =1){

		//set static variable to avoid duplication and to prevent memory usage
		static $set;

		//get the db class obj
		$db = JFactory::getDbo();

		//get the query fro mdb obj
		$query = $db->getQuery(true);

		// query to get all data in the row
		// by checking the where query
		$query->select("*")->from("#__j2store_layouts");
		$query->where("layout_id=".$layout_id);

		//now set the query
		$db->setQuery($query);

		// load the object and return
		return $set=$db->loadObject();
	}

	/**
	 * Rounding of the the nearest 10s /100s/1000s/ etc depending on the number of digits
	 * @param int $price - price of product
	 * @param int $digit - how many digit to round
	 * @param boolean $up - to round upward
	 * @return int
	 */
	protected function _priceRound( $price , $digit='100', $up = false )
	{
		//based o the digit have to calculate the price
		$price = ( (int) ( $price/$digit) ) * $digit;

		if( $up )
		{
			$price = $price + $digit;
		}

		return (int) $price;
	}

}
