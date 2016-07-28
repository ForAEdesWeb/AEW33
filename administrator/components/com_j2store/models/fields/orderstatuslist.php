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
defined('_JEXEC') or die('Restricted access');

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');


class JFormFieldOrderstatusList extends JFormFieldList {

	protected $type = 'OrderstatusList';

	public function getInput() {
		require_once(JPATH_ADMINISTRATOR.'/components/com_j2store/models/orderstatuses.php');
		$model = new J2StoreModelOrderstatuses();
		$orderlist = $model->getItems();
		//generate country filter list
		$orderstatus_options = array();
		$orderstatus_options[] =  JHTML::_('select.option','*', JText::_('JALL'));
		foreach($orderlist as $row) {
			$orderstatus_options[] =  JHTML::_('select.option', $row->orderstatus_id, JText::_($row->orderstatus_name));
		}
		return JHTML::_('select.genericlist', $orderstatus_options, $this->name, 'onchange=', 'value', 'text', $this->value);
	}
}
