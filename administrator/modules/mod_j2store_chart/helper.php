<?php
/*------------------------------------------------------------------------
# mod_j2store_cart - J2 Store Cart
# ------------------------------------------------------------------------
# author    Sasi varna kumar - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2012 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die('Restricted access');

class modJ2storeChartHelper{

	/**
	 * Method  for Getting Data - year.
	 * @access public
	 * @return array after executing the queries
	 */
	function getYear()
	{
		//Joomla platform factory class.
		$db= JFactory::getDbo();

		/**
		 * Get the current query object or a new JDatabaseQuery object.
		 *
		 * @param   boolean  $new  False to return the current query object, True to return a new JDatabaseQuery object.
		 */
		$query = $db->getQuery(true);

		//sum of order payment amount.
		$query->select('o.order_state_id ,SUM(o.orderpayment_amount) AS total,YEAR(o.created_date) AS dyear,COUNT(*) AS total_num_orders')->from('#__j2store_orders AS o');

		$query->where('o.order_state_id=1');
		//group by year in created date column.
		$query->group('YEAR(o.created_date)');


		/**
		 * Sets the SQL statement string for later execution.
		 *
		 * @param   mixed    $query   The SQL statement to set either as a JDatabaseQuery object or a string.
		 */
		$db->setQuery($query);

		/**
		 * Method to get an array of the result set rows from the database query where each row is an associative array
		 * of ['field_name' => 'row_value'].  The array of rows can optionally be keyed by a field name, but defaults to
		 * a sequential numeric array.
		 */
		$row=$db->loadAssocList();

		return $row;
	}

	/**
	 * Method  for Getting Data - month.
	 * @access public
	 * @return array after executing the queries
	 */
	function getMonth()
	{
		//Joomla platform factory class.
		$db= JFactory::getDbo();

		$today = getdate();
		$year =  $today['year'];
		/**
		 * Get the current query object or a new JDatabaseQuery object.
		 *
		 * @param   boolean  $new  False to return the current query object, True to return a new JDatabaseQuery object.
		 */
		$query = $db->getQuery(true);

		//sum of order payment amount.
		$query->select('o.order_state_id,SUM(o.orderpayment_amount) AS total, DATE_FORMAT(o.created_date,"%M") AS dmonth,COUNT(*) AS total_num_orders')->from('#__j2store_orders AS o');
		$query->where("YEAR(DATE(o.created_date)) = $year");
		$query->where('o.order_state_id=1');
		//group by year in created date column.
		$query->group('MONTH(o.created_date)');

		/**
		 * Sets the SQL statement string for later execution.
		 *
		 * @param   mixed    $query   The SQL statement to set either as a JDatabaseQuery object or a string.
		 */
		$db->setQuery($query);

		/**
		 * Method to get an array of the result set rows from the database query where each row is an associative array
		 * of ['field_name' => 'row_value'].  The array of rows can optionally be keyed by a field name, but defaults to
		 * a sequential numeric array.
		 */
		$row=$db->loadAssocList();

		return $row;
	}

	/**
	 * Method  for Getting Data - date.
	 * @access public
	 * @return array after executing the queries
	 */
	function getDay()
	{
		/**
		 * joomla platform factory class.
		 */
		$db=JFactory::getDbo();
		$today = getdate();
		$month =  $today['mon'];
		$year =  $today['year'];
		/**
		 * Get the current query object or a new JDatabaseQuery object.
		 *
		 * @param   boolean  $new  False to return the current query object, True to return a new JDatabaseQuery object.
		 */
		$query = $db->getQuery(true);
		//sum of order payment amount. DATE_FORMAT(entrydate, '%M')
		$query->select('o.order_state_id ,SUM(o.orderpayment_amount) AS total,DATE_FORMAT(o.created_date,"%d") AS dday, COUNT(*) AS total_num_orders')->from('#__j2store_orders AS o');
		$query->where("YEAR(DATE(o.created_date)) = $year AND MONTH(DATE(o.created_date)) = $month");
		$query->where('o.order_state_id=1');
		//group by year in created date column.
		$query->group('DAY(o.created_date)');


		/**
		 * Sets the SQL statement string for later execution.
		 *
		 * @param   mixed    $query   The SQL statement to set either as a JDatabaseQuery object or a string.
		 */
		$db->setQuery($query);

		/**
		 * Method to get an array of the result set rows from the database query where each row is an associative array
		 * of ['field_name' => 'row_value'].  The array of rows can optionally be keyed by a field name, but defaults to
		 * a sequential numeric array.
		 */
		$rows=$db->loadAssocList();


		if(!$rows){
			foreach($rows as $row){
				$row['dday'] = 1;
				$row['total'] = 0;
			}
		}

		return $rows;

	}

	function getOrders(){

		//get filters
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		//$query->select('o.*');
		$query->select('o.order_state_id,SUM(o.orderpayment_amount) AS total,DATE_FORMAT(o.created_date,"%a,%c %Y") AS dday, COUNT(*) AS total_num_orders');
		$query->where('o.order_state_id=1');
		$query->from('#__j2store_orders AS o');
		$query->select('oi.user_email AS oi_user_email');
		$query->join('LEFT', '#__j2store_orderinfo AS oi ON o.order_id=oi.order_id');
		$query->order('o.created_date DESC')->order('o.id DESC');
		$db->setQuery($query);
		return $db->loadObjectList();

	}
}