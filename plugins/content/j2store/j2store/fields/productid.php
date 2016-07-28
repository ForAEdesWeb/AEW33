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

// No direct access to this file
defined('_JEXEC') or die;

// import the list field type
jimport('joomla.form.helper');
/**
 * Product ID Field class for the J2Store component
 */
class JFormFieldProductID extends JFormFieldText
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'ProductID';

	protected function getInput()
	 {
	 	$app = JFactory::getApplication();
	 	$product_id = $app->input->get('id');
	 	$html = '';
		JPluginHelper::importPlugin('j2store');
	 	//trigger plugin event
		$results = $app->triggerEvent('onJ2StoreBeforeProductForm', array($product_id));
		$html .= trim(implode("\n", $results));

		$vars = new JObject();
		$vars->product_id = $product_id;

		JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_j2store/tables');
		$vars->product = JTable::getInstance('Prices', 'Table');
		$vars->product->load(array('article_id'=>$product_id));

		$html .= $this->_getLayout('product', $vars, 'j2store', 'content');


		return $html;
	}


	/**
	 * Gets the parsed layout file
	 *
	 * @param string $layout The name of  the layout file
	 * @param object $vars Variables to assign to
	 * @param string $plugin The name of the plugin
	 * @param string $group The plugin's group
	 * @return string
	 * @access protected
	 */
	function _getLayout($layout, $vars = false, $plugin = 'j2store', $group = 'j2store' )
	{

		ob_start();
		$layout = $this->_getLayoutPath( $plugin, $group, $layout );
		include($layout);
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}


	/**
	 * Get the path to a layout file
	 *
	 * @param   string  $plugin The name of the plugin file
	 * @param   string  $group The plugin's group
	 * @param   string  $layout The name of the plugin layout file
	 * @return  string  The path to the plugin layout file
	 * @access protected
	 */
	function _getLayoutPath($plugin, $group, $layout = 'default')
	{
		$app = JFactory::getApplication();

		// get the template and default paths for the layout
		$templatePath = JPATH_SITE.'/templates/'.$app->getTemplate().'/html/plugins/'.$group.'/'.$plugin.'/'.$layout.'.php';
		$defaultPath = JPATH_SITE.'/plugins/'.$group.'/'.$plugin.'/'.$plugin.'/tmpl/'.$layout.'.php';

		// if the site template has a layout override, use it
		jimport('joomla.filesystem.file');
		if (JFile::exists( $templatePath ))
		{
			return $templatePath;
		}
		else
		{
			return $defaultPath;
		}
	}


}
