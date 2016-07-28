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

class JFormFieldTagList extends JFormFieldList {

	protected $type = 'TagList';

	/**
	 * Method to get the field input for a tag field.
	 *
	 * @return  string  The field input.
	 *
	 * @since   3.1
	 */
	public function getInput() {

		require_once(JPATH_ADMINISTRATOR.DS.'models'.DS.'products.php');
		$model = new J2StoreModelProducts;
		echo $model;

		//$tags = $model->getTagList();
		$options=$model->getProducts();

		$options = array();
		$options[] = JHTML::_('select.option', '0', 'Select Name');
		foreach($options as $row)
		{
			$options[] = JHTML::_('select.option', $row->id, $row->path);
		}
		$dropdown =JHTML::_('select.genericlist', $options, $this->name, 'onchange=', 'value', 'text', $this->value);

		//echo $dropdown;
		return $dropdown;


		/* // Generate Tag List
		$tag_options = array();
		$tag_options[] = JHTML::_('select.option', '', JText::_('J2STORE_SELECT_NAME'));
		foreach($result as $row)
		{
			$tag_options[] = JHTML::_('select.option', $row->catid, $row->title);
		} */

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