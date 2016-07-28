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

class JFormFieldMyCategoryList extends JFormFieldList {

	protected $type = 'MyCategoryList';

	/**
	 * Method to get the field input for a tag field.
	 *
	 * @return  string  The field input.
	 *
	 * @since   3.1
	 */
	public function getInput() {
		//get the list of categories for the com_content

		$items = $this->getCategories();
		//JHtmlCategory::options($extension);
		/*
		$j = new JVersion();
		if(substr($j->RELEASE, 0, 3) == '2.5') {

		}else{
			$items = JHtmlCategory::options('com_content');
		} */
		//set the name like jform[params][categories][]
		$this->name = $this->name.'[]';
		$options = array();

		foreach($items as $row)
		{
			$options[] = JHTML::_('select.option', $row->value,$row->text);
		}
		$array = (array) $this->value;
		foreach($array as $key=>$value) {
			$val = (array) $value;
			foreach($val as $v) {
				$newarray[] = $v;
			}
		}

		$dropdown =JHTML::_('select.genericlist', $options, $this->name, array('multiple'=>'true'), 'value', 'text', $newarray);
		return $dropdown;
	}

	public function getCategories(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query = $db->getQuery(true)
				->select('a.id, a.title, a.level')
				->from('#__categories AS a')
				->where('a.parent_id > 0');
		// Filter on extension.
		$query->where('extension =com_content');
		$query->where('a.published = 1');
		$items = $db->loadObjectList();
		// Assemble the list options.


		foreach ($items as &$item)
		{
			$repeat = ($item->level - 1 >= 0) ? $item->level - 1 : 0;
			$item->title = str_repeat('- ', $repeat) . $item->title;
			//static::$items[$hash][] = JHtml::_('select.option', $item->id, $item->title);
		}
		return $items;
	}
}