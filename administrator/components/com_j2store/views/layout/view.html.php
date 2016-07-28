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

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the J2Store Component
*/
class J2StoreViewLayout extends J2StoreView
{
	protected $form;
	protected $item;
	protected $state;

	/**
	 * Method to display view
	 * (non-PHPdoc)
	 * @see JViewLegacy::display()
	 */
	function display($tpl = null)
	{
		//get the app obj
		$app = JFactory::getApplication();

		//get the task
		$task = $app->input->get('task');

		//get the form
		$this->form	= $this->get('Form');

		// Get data from the model
		$this->item = $this->get('Item');
		// inturn calls getState in parent class and populateState() in model
		$this->state = $this->get('State');
		$this->params = JComponentHelper::getParams('com_j2store');
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

		//add toolbar
		$this->addToolBar($task);
		$toolbar = new J2StoreToolBar();
		$toolbar->renderLinkbar();
		// Display the template
		parent::display($tpl);
		// Set the document
		$this->setDocument();
	}

	protected function addToolBar($task) {
		// setting the title for the toolbar string as an argument
		JToolBarHelper::title('J2Store - '.JText::_('J2STORE_LAYOUT'),'j2store-logo');
		if($task =='edit' || $task == 'add'){
			JToolBarHelper::apply('layout.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('layout.save', 'JTOOLBAR_SAVE');
			JToolBarHelper::cancel('layout.cancel', 'JTOOLBAR_CLOSE');
		}
	}

	protected function setDocument() {
		// get the document instance
		$document = JFactory::getDocument();
		// setting the title of the document
		$document->setTitle(JText::_('J2STORE_LAYOUT'));
	}

}
