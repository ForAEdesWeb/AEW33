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

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');


require_once (JPATH_ADMINISTRATOR.'/components/com_j2store/library/j2item.php');
require_once (JPATH_ADMINISTRATOR . '/components/com_j2store/library/plugins/_base.php');
require_once (JPATH_SITE . '/components/com_j2store/helpers/utilities.php');
class plgJ2StoreExtraimages extends J2StorePluginBase {

	/**
	 * @var $_element  string  Should always correspond with the plugin's filename,
	 *                         forcing it to be unique
	 */
	var $_element   = 'extraimages';

	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	/**
	 * Method to display input to upload images
	 * @param int  $product_id
	 * @return html
	 */
	public function onJ2StoreProductFormInput($product_id){

		$vars = new JObject();

		//check product id exist
		if(isset($product_id)){

			//get the article item
			$article=J2StoreItem::getArticle($product_id);

			//get the j2store price for the above item
			$price =J2StoreItem::_getJ2Item($product_id);

			//assign the product id into vars
			$vars->product_id = $product_id;

			if(isset($price->additional_image)){
				$vars->additional_image =json_decode($price->additional_image);
			}
			$vars->asset_id = $article->asset_id;
		}

		//check asset id exist else get from app
		if (!isset($vars->asset_id))
		{
			$vars->asset_id = JFactory::getApplication()->input->get('option');
		}
		//check already main image exist
		$vars->main_image =(isset($price->main_image)) ? $price->main_image :"";
		$vars->listview_thumb =(isset($price->listview_thumb)) ? $price->listview_thumb:"";
		$vars->no_of_additional_image = $this->params->get('no_of_additional_img',5);
		
		//load the layot and return the result
		$result = $this->_getLayout('default', $vars);

		return $result;
	}

	/**
	 * Method to save data
	 * @param array type $attribs
	 * @param int type $articleId
	 * @return array
	 */
	function onJ2StoreAfterSaveProduct($attribs, $articleId)
	{
		//get the app object
		$app = JFactory::getApplication();

		//get the post data
		$post = $app->input->getArray($_POST);


		//assign the main image
		$main_image = $post['jform']['attribs']['main_image'];
		$listview_thumb = $post['jform']['attribs']['listview_thumb'];
		//get the additional image and need
		// to encode the data
		$additional_image = $post['jform']['attribs']['additional_image'];
		$additional_image=json_encode($additional_image);

		//now check article id exist
		if($articleId){
				//get the prices table
				JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_j2store/tables');
				//now create table object
				$row = JTable::getInstance('prices','Table');
				//load the id in the table to get the row
				$row->load(array('article_id'=>$articleId));

				//assign the additional image
				// and main image in to the row
				$row->additional_image = $additional_image;
				$row->main_image = $main_image;
				$row->listview_thumb = $listview_thumb;

				//now save the row
				if ( !$row->save())
				{
				$messagetype = 'notice';
				$message = JText::_( 'J2STORE_ERROR_SAVING_CHANGES' )." - ".$row->getError();
				}
			}
	}

}
