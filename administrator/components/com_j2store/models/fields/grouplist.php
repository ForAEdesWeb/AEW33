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


class JFormFieldGroupList extends JFormFieldList {

	protected $type = 'GroupList';
	public function getInput() {
		if(version_compare(JVERSION, '3.0', 'lt')) {
			require_once(JPATH_LIBRARIES.'/joomla/html/html/user.php');
		}
		$groupList=JHtmlUser::groups();

		//generate country filter list
		$group_options = array();
		$group_options[] =  JHTML::_('select.option','*', JText::_('JALL'));
		foreach($groupList as $row) {
			$group_options[] =  JHTML::_('select.option', $row->value, JText::_($row->text));
		}
		return JHTML::_('select.genericlist', $group_options, $this->name, 'onchange=', 'value', 'text', $this->value);
	}
}
