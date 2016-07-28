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

/**
 * Form Field Class for Displaying Tags
 * @author weblogicx
 * return JHTML
 */

class JFormFieldLayoutList extends JFormFieldList {

	protected $type = 'LayoutList';

	/**
	 * Method to get the field input for a tag field.
	 *
	 * @return  string  The field input.
	 *
	 * @since   3.1
	 */
	public function getInput() {
		$items = $this->getJ2Storelayouts();
		$options = array();
		$options[] = JHTML::_('select.option', '0', JText::_('J2STORE_SELECT_OPTION'));
		foreach($items as $row)
		{
			$options[] = JHTML::_('select.option', $row->layout_id,$row->layout_name);
		}
		$dropdown =JHTML::_('select.genericlist', $options, $this->name, '', 'value', 'text', $this->value);
		return $dropdown;

	}
	/**
	 * Methed to get J2store
	 */
	function getJ2StoreLayouts(){
		$db = JFactory::getDbo();
		$query= $db->getQuery(true);
		$query->select("*")->from('#__j2store_layouts');
		$query->where('state=1');
		$db->setQuery($query);
		return $db->loadObjectList();
	}


	public function setFieldValue($fieldname='', $value='') {
		if(isset($fieldname))
		{
			$this->name=$fieldname;
		}
		if(isset($value)){
			$this->value=$value;
		}
	}
}