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
   if(version_compare(JVERSION ,'3.0','lt')){
	$doc = JFactory::getDocument();
	$doc->addStyleSheet(JUri::root().'media/j2store/css/bootstrap-advanced-ui.css');
	$doc->addScript(JUri::root().'media/j2store/js/bootstrap-advanced-ui.js');
   }
   $action = JRoute::_('index.php?option=com_j2store&view=layout');
   JHtml::_('behavior.keepalive');
  ?>

<div class="j2store">
<div class="alert alert-block alert-info"><?php echo JText::_('J2STORE_PRODUCT_LAYOUT_HELP_TEXT'); ?></div>
	<div class="alert alert-block alert-warning">
	<strong>
		<?php echo JText::_('J2STORE_PRODUCTS_HELP_TEXT_MORE'); ?>
	</strong>
	</div>
<h3><?php echo JText::_('J2STORE_LAYOUT'); ?></h3>
<form action="<?php echo $action; ?>" method="post" name="adminForm" id="adminForm" class="form-horizontal">
   <?php //print_r($this->item); ?>
   <div id="layout-edit">
   <div class="row-fluid">
	   <div class="span12 form-inline">
	      <div class="control-group">
	         <label class="control-label">
	         <?php echo $this->form->getLabel('layout_name'); ?>
	         </label>
	         <div class="controls">
	            <?php echo $this->form->getInput('layout_name'); ?>
	         </div>
	      </div>
	      <div class="control-group">
	         <label class="control-label">
	         <?php echo $this->form->getLabel('state'); ?>
	         </label>
	         <div class="controls">
	            <?php echo $this->form->getInput('state'); ?>
	         </div>
	      </div>
	   </div>
   </div>

   <div class="row-fluid">
	   <div class="span12">
    	  <ul class="nav nav-tabs">
    	   <li class="active">
            	<a href="#common" data-toggle="tab">
            	<?php echo JText::_('J2STORE_LAYOUT_TYPE_COMMON');?>
            	</a>
         	</li>
        	 <li >
            	<a href="#list" data-toggle="tab">
            		<?php echo JText::_('J2STORE_LAYOUT_TYPE_LIST');?>
            	</a>
         	</li>
         	<li>
            	<a href="#product" data-toggle="tab">
            	<?php echo JText::_('J2STORE_LAYOUT_TYPE_PRODUCT');?>
            	</a>
         	</li>

      </ul>
      <div class="tab-content">
      	<div class="tab-pane active" id="common">
			<?php echo $this->loadTemplate('common');?>
      	</div>
         <!-- end of tab content -->
         <div class="tab-pane" id="list">
			<?php echo $this->loadTemplate('list');?>
         </div>
         <div class="tab-pane" id="product">
			<?php echo $this->loadTemplate('detail');?>

      	</div>

      <input type="hidden" name="option" value="com_j2store" />
      <input type="hidden" name="view" value="layout"/>
      <input type="hidden" name="layout_id" value="<?php echo $this->item->layout_id; ?>" />
      <input type="hidden" name="cid[]" value="<?php echo $this->item->layout_id; ?>"/>
      <input type="hidden" name="task" value=""/>
      <?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>


