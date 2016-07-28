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

require_once(JPATH_ADMINISTRATOR.'/components/com_j2store/library/reportcontroller.php');

class J2StoreControllerReportOrderitems extends J2StoreControllerReportPlugin
{
	var $_element   = 'report_orderitems';

	/**
	 * constructor
	 */
	function __construct()
	{
		parent::__construct();
		JModelLegacy::addIncludePath(JPATH_SITE.'/plugins/j2store/report_orderitems/report_orderitems/models');
		JTable::addIncludePath(JPATH_SITE.'/plugins/j2store/report_orderitems/report_orderitems/tables');
	}

	function export(){

		$app = JFactory::getApplication();
		$id = $app->input->getInt('id',0);

		$this->includeCustomModel('ReportOrderitems');
    	$model = JModelLegacy::getInstance('Reportorderitems', 'J2StoreModel');
		$data = $model->getData();

		$filename = $model->export($data);
		$url = "index.php?option=com_j2store&view=report&task=view&id=".$id;
		if($filename){

				$msg = JText::_('PLG_J2STORE_REPORT_ORDER_ITEMS_EXPORT_SUCCESS');
				$mtype="Message";
		}else{
			$msg = JText::_('PLG_J2STORE_REPORT_ORDER_ITEMS_EXPORT_FAILED');
			$mtype="Warning";
		}
		$app->redirect($url,$msg,$mtype);
	}



}
