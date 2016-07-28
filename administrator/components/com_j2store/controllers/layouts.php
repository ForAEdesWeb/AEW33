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


// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


jimport('joomla.application.component.controllerform');

class J2StoreControllerLayouts extends JControllerForm{



	function __construct($config = array())
	{
		parent::__construct($config);
		// Register Extra tasks
		$this->registerTask('unpublish','publish');
		$this->registerTask( 'trash', 'remove' );
		$this->registerTask( 'delete', 'remove' );
	}


	/**
	 * Method to publi and unpublish items
	 */
	function publish()
	{

		$app = JFactory::getApplication();

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = $app->input->get( 'cid', array(), 'array' );
		$values = array('publish' => 1, 'unpublish' => 0);
		$task     = $this->getTask();
		$value   = JArrayHelper::getValue($values, $task, 0, 'int');

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'J2STORE_SELECT_AN_ITEM_TO_PUBLISH' ) );
		}

		$table = $this->getModel('layout')->getTable();
		if(!$table->publish($cid, $value)) {
			echo "<script> alert('".$table->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_j2store&view=layouts' );
	}

	function remove()
	{		// Check for request forgeries

	JRequest::checkToken() or jexit( 'Invalid Token' );
	$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
	JArrayHelper::toInteger($cid);
	if (count( $cid ) < 1) {
		JError::raiseError(500, JText::_( 'J2STORE_SELECT_AN_ITEM_TO_DELETE' ) );
	}
	JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_j2store/tables');

	 $table = JTable::getInstance('layout','Table');




	for($a=0; $a < count($cid); $a++ ){

		if(!$table->delete($cid[$a])) {

			$msg = $table->getError();
		} else {
			$msg = JText::_('J2STORE_LAYOUT_DELETED_SUCCESSFULLY');
		}
	}
	$this->setRedirect( 'index.php?option=com_j2store&view=layouts', $msg);
	}




}

