<?php
/*------------------------------------------------------------------------
 # com_j2store - J2Store
# ------------------------------------------------------------------------
# author    Sasi varna kumar - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2014 - 19 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * Jsecommerce model.
 *
 * @package		Joomla.Site
 * @subpackage	com_jsecommerce
 * @since 2.5
*/
class J2StoreModelLayout extends JModelAdmin
{
	protected $text_prefix = 'COM_J2STORE';

	protected $view_list = 'layout';

	/**
	 * Method to getForm
	 * (non-PHPdoc)
	 * @see JModelForm::getForm()
	 * @result form
	 */
	public function getForm($data = array(), $loadData = true)
	{

		// Initialise variables.
		$app	= JFactory::getApplication();
		// Get the form.
		$form = $this->loadForm('com_j2store.layout', 'layout', array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form)) {
			return false;
		}

		return $form;
	}

	/**
	 * Method to get table data (non-PHPdoc)
	 * @see JModelLegacy::getTable()
	 */
	public function getTable($type = 'layout', $prefix = 'Table', $config = array())
	{

		return JTable::getInstance($type, $prefix, $config);
	}


	public function getItem($pk = null)
	{
		if ($item = parent::getItem($pk)) {
			// Convert the params field to an array.
		}


		return $item;
	}


	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_j2store.edit.layout.data', array());

		// if data is empty
		if (empty($data)) {
			//get the data
			$data = $this->getItem();
			// now we want to get an data in object type
			// so here data->params type array is now converted in to object
			// now we can just assing the required data into new object
			// layoutid, layoutname ,sate ordering for the further processing
			$new_data = JArrayHelper::toObject($data->params);
			$new_data->layout_id = $data->layout_id;
			$new_data->layout_name = $data->layout_name;
			$new_data->state = $data->state;
			$new_data->ordering = $data->ordering;
		}
		return $new_data;
	}


	 protected function prepareTable($table)
	{
		jimport('joomla.filter.output');
		$date = JFactory::getDate();
		$user = JFactory::getUser();

	}

}
