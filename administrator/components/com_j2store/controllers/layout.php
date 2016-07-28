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

jimport('joomla.application.component.controller');

class J2StoreControllerLayout extends J2StoreController {

function __construct($config = array())
	{
		parent::__construct($config);
		// Register Extra tasks
		$this->registerTask( 'save', 'save' );
		$this->registerTask( 'apply', 'save' );
		$this->registerTask( 'trash', 'remove' );
		$this->registerTask( 'delete', 'remove' );
		$this->registerTask('close','cancel');
		$this->registerTask('unpublish','publish');

	}

	/**
	 * Method to cancel edit task and redirect
	 * to default layout
	 *
	 */
	function cancel(){
		$msg = JText::_( 'J2STORE_LAYOUT_CANCELED' );
		$link = 'index.php?option=com_j2store&view=layouts';
		$this->setRedirect($link, $msg);
	}

	/**
	 * Method to (non-PHPdoc)
	 * @see J2StoreController::display()
	 */
	function display($cachable = false, $urlparams = array()) {

		$task = $this->getTask();

		if($task =='edit' || $task == 'add'){

			JRequest::setVar( 'hidemainmenu', 1 );
			JRequest::setVar( 'layout', 'edit'  );
			JRequest::setVar( 'view'  , 'layout');
			JRequest::setVar( 'edit', true );
			$model = $this->getModel('layout');
		}
		parent::display();

	}


	function save()
	{
		$app = JFactory::getApplication();

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$post	= JRequest::get('post');

		$data = $post['jform'];

		$task = $app->input->get('task');

		$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$layout_id = (int) $cid[0];

		if($data['layout_name']){

			JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_j2store/tables');

			$layout_data = JTable::getInstance('Layout', 'Table');

			if(isset($layout_id)){
				$layout_data->load($layout_id);
			}
			$new_data =array();
			$new_data['layout_id'] = (isset($layout_id)) ? $layout_id : "" ;
			$new_data['layout_name'] = $data['layout_name'];
			$new_data['state'] = $data['state'];

			//now include the params the data
			$registry = new JRegistry();
			$registry->loadArray($data);
			$new_data['params'] = $registry->toString('JSON');

			if ($layout_data->save($new_data)) {

				$msg = JText::_( 'J2STORE_LAYOUT_SAVED' );

			} else {

				$msg = JText::_( 'J2STORE_ERROR_LAYOUT_SAVING' );
				$msgType='Warning';
			}

			switch($task){

				case 'apply':

					$link = 'index.php?option=com_j2store&view=layout&task=layout.edit&layout_id='.$layout_data->layout_id;

					break;

				case 'save':

					$link = 'index.php?option=com_j2store&view=layouts';

					break;
			}
		}else{

			$link = 'index.php?option=com_j2store&view=layout&task=layout.edit&layout_id='.$layout_id;
			$msg = JText::_( 'J2STORE_ERROR_LAYOUT_NAME_MISSING' );
			$msgType='Warning';
		}



		$this->setRedirect($link, $msg,$msgType);
	}







}

