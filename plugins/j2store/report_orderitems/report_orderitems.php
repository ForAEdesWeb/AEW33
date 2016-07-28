<?php
/*------------------------------------------------------------------------
# com_j2store - J2Store
# ------------------------------------------------------------------------
# author    Ramesh Elamathi - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2012 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');
require_once(JPATH_ADMINISTRATOR.'/components/com_j2store/library/plugins/report.php');

class plgJ2StoreReport_Orderitems extends J2StoreReportPlugin
{
	function __construct($subject, $config) {
		parent::__construct($subject, $config);
		$this->loadLanguage('com_j2store', JPATH_ADMINISTRATOR);
	}
	/**
	 * @var $_element  string  Should always correspond with the plugin's filename,
	 *                         forcing it to be unique
	 */
    var $_element   = 'report_orderitems';

    /**
     * Overriding
     *
     * @param $options
     * @return unknown_type
     */
    function onJ2StoreGetReportView( $row )
    {
    	if (!$this->_isMe($row))
    	{
    		return null;
    	}

    	$html = $this->viewList();

    	return $html;
    }

    /**
     * Validates the data submitted based on the suffix provided
     * A controller for this plugin, you could say
     *
     * @param $task
     * @return html
     */
    function viewList()
    {
    	$app = JFactory::getApplication();
    	$option = 'com_j2store';
    	$ns = $option.'.report';
    	$html = "";
    	JToolBarHelper::title(JText::_('J2STORE_REPORT').'-'.JText::_('PLG_J2STORE_'.strtoupper($this->_element)),'j2store-logo');
    	JToolbarHelper::back('J2STORE_BACK_TO_REPORT','index.php?option=com_j2store&view=report');
    	//JToolbarHelper::custom(JText::_('PLG_J2STORE_EXPORT_ORDERITEMS'), 'index.php?option=com_j2store&view=report&reportTask=export');
    	J2StoreToolBar::_custom('export', 'new', 'new', 'J2STORE_EXPORT_ORDERS', false, false, 'reportTask');

	   	$vars = new JObject();

	   	$this->includeCustomModel('ReportOrderitems');
    	$this->includeCustomTables();
    	$model = JModelLegacy::getInstance('Reportorderitems', 'J2StoreModel');

    	$model->setState('filter_search', $app->input->getString('filter_search'));
    	$model->setState('filter_orderstatus', $app->input->getString('filter_orderstatus'));
    	$model->setState('filter_order', $app->input->getString('filter_order'));
    	$model->setState('filter_order_Dir', $app->input->getString('filter_order_Dir'));

    	// Get the pagination request variables
		$limit		= $app->getUserStateFromRequest( 'global.list.limit', 'limit', $app->getCfg('list_limit'), 'int' );
		$limitstart	= $app->getUserStateFromRequest( $ns.'.limitstart', 'limitstart', 0, 'int' );

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$model->setState('limit', $limit);
		$model->setState('limitstart', $limitstart);


    	$list = $model->getList();
    	$vars->total = $model->getTotal();
    	$vars->pagination = $model->getPagination();
    	$vars->state = $model->getState();
    	$vars->list = $list;
    	$vars->params = JComponentHelper::getParams('com_j2store');
    	$vars->orderStatus = $this->getOrderStatus();
    	$id = $app->input->getInt('id', '0');
    	$vars->id = $id;
    	$form = array();
    	$form['action'] = "index.php?option=com_j2store&view=report&task=view&id={$id}";
    	$vars->form = $form;
    	$html = $this->_getLayout('default', $vars);

    	return $html;
    }
	/**
	 * Method to get
	 */
    public function getOrderStatus(){
    	$db = JFactory::getDbo();
    	$query = $db->getQuery(true);
    	$query->select("*")->from("#__j2store_orderstatuses");
    	$db->setQuery($query);
    	$row = $db->loadObjectList();
    	$data =array();
		$data[] = '-- '.JText::_('J2STORE_ORDER_STATUS').' --';
    	foreach($row as $item){
    		$data[$item->orderstatus_id] = JText::_($item->orderstatus_name);
    	}
    	return $data;
    }


}

