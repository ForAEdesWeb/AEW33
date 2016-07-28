<?php
/*------------------------------------------------------------------------
# com_j2store - J2Store
# ------------------------------------------------------------------------
# author    Gokila Priya - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2012 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/
// Check to ensure this file is included in Joomla!

defined('_JEXEC') or die( 'Restricted access' );
require_once(JPATH_SITE.'/components/com_j2store/models/_base.php');
class J2storeModelReportOrderitems extends J2storeModelBase
{
	public $cache_enabled = false;

	public $filter_search;
	public $filter_orderstatus;
	public $filter_order;
	public $filter_order_dir;


	function __construct()
	{
		parent::__construct();
		$app = JFactory::getApplication();
		$option = 'com_j2store';
		$ns = $option.'.report';
		// Get the pagination request variables
		$this->filter_search = $app->input->getString('filter_search','');
		$this->filter_orderstatus = $app->input->getInt('filter_orderstatus',0);
		//$this->filter_order =  $app->input->getString('filter_order','tbl.order_id');
		 $this->filter_order_from_date =  $app->getUserStateFromRequest($ns.'filter_order_from_date','filter_order_from_date','','');
		 $this->filter_order_to_date =  $app->getUserStateFromRequest($ns.'filter_order_to_date','filter_order_to_date','','');
		 $this->filter_order_customer = $app->getUserStateFromRequest($ns.'filter_order_customer','filter_order_customer','','');
		$this->filter_order_customer_email = $app->getUserStateFromRequest($ns.'filter_order_customer_email','filter_order_customer_email','','');
		$this->filter_order_product =$app->getUserStateFromRequest($ns.'filter_order_product','filter_order_product','','');


		$this->filter_order =  $app->getUserStateFromRequest($ns.'filter_order','filter_order','tbl.order_id','');



		$this->filter_order_Dir =  $app->input->getString('filter_order_Dir','ASC');

		$filter_name      =  $app->getUserStateFromRequest($ns.'orderitem_name', 'filter_name', '', '');
		$filter_date      = $app->getUserStateFromRequest($ns.'modified_date', 'filter_date', '', '');
		$filter_order_id  = $app->getUserStateFromRequest($ns.'order_id', 'filter_order_id', '', '');

		$limit		= $app->getUserStateFromRequest( 'global.list.limit', 'limit', $app->getCfg('list_limit'), 'int' );
		$limitstart	= $app->getUserStateFromRequest( $ns.'.limitstart', 'limitstart', 0, 'int' );

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);

		$this->setState('filter_search',  $this->filter_search);
		$this->setState('filter_orderstatus',  $this->filter_orderstatus);
		$this->setState('filter_order_Dir',  $this->filter_order_Dir);
		$this->setState('filter_order',  $this->filter_order);
		$this->setState('filter_name',  $filter_name);
		$this->setState('filter_date', $filter_date );
		$this->setState('filter_order_id',$filter_order_id);

		$this->setState('filter_order_from_date', $this->filter_order_from_date );
		$this->setState('filter_order_to_date', $this->filter_order_to_date );
		$this->setState('filter_order_customer',$this->filter_order_customer);
		$this->setState('filter_order_customer_email',$this->filter_order_customer_email);
		$this->setState('filter_order_product',$this->filter_order_product);
	}

	protected function _buildQueryWhere($query)
	{
		$filter           = $this->getState('filter');
		$filter_search    = $this->getState('filter_search');
		$filter_orderstatus    = $this->getState('filter_orderstatus');
		$filter_id_from   = $this->getState('filter_id_from');
		$filter_id_to     = $this->getState('filter_id_to');
		$filter_name      = $this->getState('filter_name');

		$filter_order_from_date= $this->getState('filter_order_from_date');
		$filter_order_to_date = $this->getState('filter_order_to_date');
		$filter_order_customer = $this->getState('filter_order_customer');
		$filter_order_customer_email = $this->getState('filter_order_customer_email');
		$filter_order_product = $this->getState('filter_order_product');
		if ($filter_search)
		{

			$key	= $this->_db->Quote('%'.$this->_db->escape( trim( strtolower( $filter_search ) ) ).'%');
			$where = array();
			$where[] = 'LOWER(orderinfo.billing_first_name) LIKE '.$key;
			$where[] = 'LOWER(orderinfo.billing_first_name) LIKE '.$key;
			$query->where('('.implode(' OR ', $where).')');

		}

		if ($filter_orderstatus)
		{
			$query->where('tbl.order_state_id='.$this->_db->q($filter_orderstatus));
		}

		//filters  from creaded_date to upto creaded_date
		if($filter_order_from_date  && $filter_order_to_date){
			$query->where("tbl.created_date BETWEEN '$filter_order_from_date' AND '$filter_order_to_date'");
		}

		//filter for customer Name
		if($filter_order_customer){
			$key =  $this->_db->Quote('%'.$this->_db->escape( trim( strtolower($filter_order_customer ) ) ).'%');
			$where[] = 'LOWER(orderinfo.billing_first_name) LIKE '.$key;
			$where[] = 'LOWER(orderinfo.billing_first_name) LIKE '.$key;
			$query->where('('.implode(' OR ', $where).')');
		}

		//filter based on customer email
		if($filter_order_customer_email){
			$query->where('tbl.user_email='.$this->_db->q($filter_order_customer_email));
		}




	}
	 protected function _buildQueryJoins($query)
	{
		//$query->join('LEFT', '#__j2store_orders AS orders ON tbl.order_id = orders.order_id');
		$query->join('INNER', '#__j2store_orderinfo AS orderinfo ON orderinfo.order_id = tbl.order_id');
		//
		$query->join('LEFT', '#__j2store_orderstatuses AS orderstatus ON tbl.order_state_id = orderstatus.orderstatus_id');

	}

	protected function _buildQueryFields($query)
	{
		$field = array();
		//$field[] = " orders.*";
		$field[] = "orderinfo.billing_first_name";
		$field[] = "orderinfo.billing_last_name";
		$field[] = "CASE WHEN tbl.invoice_prefix IS NULL or tbl.invoice_number = 0 THEN
						tbl.id
  					ELSE
						CONCAT(tbl.invoice_prefix, '', tbl.invoice_number)
					END
				 	AS invoice";

		//$field[] = " orderatt.*";
		$field[] = " orderstatus.*";
		$query->select( $this->getState( 'select', 'tbl.*' ) );
		$query->select( $field );
	}

	protected function _buildQueryGroup($query)
	{
		$query->group('tbl.order_id');
		//$query->group('orderitem.product_id,tbl.order_id');
	}
	function _buildQueryOrder($query)
	{
		$mainframe = JFactory::getApplication();
		$option = 'com_j2store';
		$ns = $option.'.report';
		$filter_order		= $mainframe->getUserStateFromRequest( $ns.'filter_order',		'filter_order',		'tbl.order_id',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $ns.'filter_order_Dir',	'filter_order_Dir',	'',				'word' );
		$query->order($filter_order.' '.$filter_order_Dir)->order('tbl.order_id');

	}
	 public function getList($refresh = false)
	{

		//get the product name to be filtered
		$filter_order_product = $this->getState('filter_order_product');

		//now get the lists
		$list = parent::getList($refresh);

		// If no item in the list, return an array()
		if( empty( $list ) ){
			return array();
		}

		$params = JComponentHelper::getParams('com_j2store');
		$show_tax = $params->get('show_tax_total');

		JModelLegacy::addIncludePath( JPATH_SITE.DS.'components'.DS.'com_j2store'.DS.'models' );

		$_results =array();
		foreach($list as &$single)
		{
			$model = JModelLegacy::getInstance( 'OrderItems', 'J2StoreModel' );
			$model->setState( 'filter_orderid', $single->order_id);
			$model->setState( 'filter_product_name', $filter_order_product);
			$model->setState( 'direction', 'ASC' );
			$orderitems = $model->getList();

			//to check orderitems exits
			if(count($orderitems)){

				$_results[] = $single;

					foreach ($orderitems as &$item)
					{
						$item->orderitem_price = $item->orderitem_price + floatval( $item->orderitem_attributes_price );
						$taxtotal = 0;
						if($show_tax)
						{
							$taxtotal = ($item->orderitem_tax / $item->orderitem_quantity);
						}
						$item->orderitem_price = $item->orderitem_price + $taxtotal;
						$item->orderitem_final_price = $item->orderitem_price * $item->orderitem_quantity;
						$single->order_subtotal += ($taxtotal * $item->orderitem_quantity);
					}
				$single->orderitems = $orderitems;

			}
		}
		return $_results;
		//return $list;
	}





	public function getOrderProduct($id){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')->from('#__j2store_orders');
		$query->where('id ='.$db->q($id));
		$db->setQuery($query);
		$result = $db->loadObjectList();
		return $result;
	}
/**
	* @access public
	* @return integer
	*/
	function getTotal()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_total))
		{
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
		}

		return $this->_total;
	}

	/**
	 * Method to get Processed array of data for Export
	 * @param object array $data
	 * return array
	 */
	public function export($data){

		//include the prices library
		require_once(JPATH_ADMINISTRATOR.'/components/com_j2store/library/prices.php');

		//get the data to be exported
		$items = $this->getList();

		//here we process objectlist into array list
		$export_data =$this->getProcessedDataArray($items);

		require_once (JPATH_ADMINISTRATOR.'/components/com_j2store/library/csv.php');

		//get the header fields
		$headers = $this->getExportHeader($export_data);

		//get the data to inserted in writer for export
		$insertExportdata = $this->getProcessedExportData($export_data,$headers);

		$file_name = 'j2store_report_orderitems_export_order_id_'.date('Y-m-d').'_'.time();


		$exporter = new J2StoreCSVExport();

		$exporter->headerAry =  $headers;
		$exporter->dataAry = $insertExportdata;
		$exporter->filename = 'j2store_report_orderitems_export_';
		$exporter->csv();
		$exporter->download();
		JFactory::getApplication()->close();
	}


	/**
	 * Method to get Array list for exporting the data
	 * @param unknown_type $items
	 * @return array list
	 */

	public function getProcessedDataArray($items){
		$export_data =array();

		//loop the items
		foreach($items as $key=>$order){

			//now assign the data in array index
			$export_data[$key]['order_date'] =$order->created_date;
			$export_data[$key]['order_number'] =$order->order_id;
			$export_data[$key]['invoice_number']= $order->invoice;
			$export_data[$key]['customer_name'] = $order->billing_first_name .' '. $order->billing_last_name;
			$export_data[$key]['customer_email']= $order->user_email;
			$export_data[$key]['orderstatus'] =JText::_($order->orderstatus_name);
			$export_data[$key]['currency_code']=$order->currency_code;
			$export_data[$key]['order_subtotal'] = $order->order_subtotal;
			$export_data[$key]['order_shipping_total'] = $order->order_shipping;
			$export_data[$key]['order_shipping_tax'] = $order->order_shipping_tax;
			$export_data[$key]['order_surcharge'] =$order->order_surcharge;
			$export_data[$key]['order_surcharge'] =$order->order_discount;
			$export_data[$key]['order_total']= $order->order_total;

			//now loop each orderitems
			//to display the product details
			foreach($order->orderitems as $i=>$item){
				$i++;

				//now assign the data into the index .. you will get the result eg. product_title_1
				$export_data[$key][$this->getArrayIndexName('product_title',$i)] =$item->orderitem_name;
				$export_data[$key][$this->getArrayIndexName('product_sku',$i)] =$item->orderitem_sku;
				$export_data[$key][$this->getArrayIndexName('product_quantity',$i)] =$item->orderitem_quantity;
				$export_data[$key][$this->getArrayIndexName('product_option',$i)] = '';
				if(isset($item->orderitem_attribute_names) && $item->orderitem_attribute_names){
					$attributes =json_decode(stripcslashes($item->orderitem_attribute_names));
					$string = '';
					foreach($attributes as $a =>$attr){
						$string .=$attr->name.' : '.$attr->value;
					}

					$export_data[$key][$this->getArrayIndexName('product_option',$i)] = $string;
				}
				$export_data[$key][$this->getArrayIndexName('product_tax', $i)] = $item->orderitem_tax;
				$export_data[$key][$this->getArrayIndexName('product_shipping', $i)] = $item->orderitem_shipping;
				$export_data[$key][$this->getArrayIndexName('product_shipping_tax', $i)] = $item->orderitem_shipping_tax;
				$export_data[$key][$this->getArrayIndexName('product_final_price',$i)] = $item->orderitem_final_price;
			}
		}
		return $export_data;
	}

	/**
	 * Method to get Header array
	 * @param unknown_type $export_data
	 * @return array
	 */
	public function getExportHeader($export_data){

		$max = 1;
		//based on the exportdata array
		//process and get the array key having max count
		//for setting  the array keys as header
		foreach($export_data as $exdata) {
			//check array has max count
			if(count($exdata) > $max) {
				$max = count($exdata);
				$item = $exdata;
			}
		}

		//now get the header array
		$fields = array_keys((array)$item);
		//make sure index keys are unique
		$fields =array_unique($fields);
		return $fields;
	}


	/**
	 * Method to replace the empty value with '-' for Exporting
	 * @param array $export_data
	 * @param array $fields
	 * @return result
	 */
	public function getProcessedExportData($export_data,$fields){

		$neworders = array();
		foreach($export_data as &$order) {
			$neworder = array();
			foreach($fields as $field) {
				if(array_key_exists($field,$order)){
					$neworder[$field]= $order[$field];
				} else {
					$neworder[$field] = '-';
				}
			}
			$neworders[] = $neworder;
		}
		return $neworders;
	}



	/**
	 * Method to get concatibated string
	 * @param string type $string
	 * @param int type $i
	 * @return string
	 */
	public function getArrayIndexName($string,$i){
		return $string.'_'.$i;
	}

	/**
	 * Method to get Data
	 * @return result
	 */
	public function getData(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select("orderitem.*")->from("#__j2store_orderitems as orderitem");
		$query->join('LEFT', '#__j2store_orders AS orders ON orderitem.order_id = orders.order_id');
		$query->join('LEFT', '#__j2store_orderinfo AS orderinfo ON orders.order_id = orderinfo.order_id');
		$query->join('LEFT', '#__j2store_orderitemattributes AS orderatt ON orderatt.orderitem_id = orderitem.orderitem_id');
		$query->select("orderitem.*");
		$query->select("orders.*");
		$query->select("orderinfo.billing_first_name , orderinfo.billing_last_name");
		$query->select("orderatt.*");
		$query->group("orders.order_id,orderitem.product_id");
		$db->setQuery($query);
		$results = $db->loadObjectList();
		return $results ;
		}
}
