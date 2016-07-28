<?php
/*------------------------------------------------------------------------
 # com_j2store - J2Store
# ------------------------------------------------------------------------
# author    Priya bose - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2012 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/
/** Check to ensure this file is included in Joomla! */
defined('_JEXEC') or die( 'Restricted access' );
jimport('joomla.filesystem.file');
$image_path = JUri::root();
$offer_badge_image = $this->layoutparams->get('product_offer_image', '');
$link = JRoute::_('index.php?option=com_j2store&view=products&task=view&id='.$this->item->product_id);
?>

	<!-- on Before display product -->
	<div class="j2store-before-display-product">
		<?php echo $this->item->event->J2StoreBeforeProductDisplay;?>
	</div>
	<!-- Form action starts here -->
	<form action="<?php echo JRoute::_('index.php?option=com_j2store&view=mycart'); ?>" method="post" name="j2storeProductForm" id="j2store-product-list" class="j2storeProductForm">
			<!-- Before displaying product Images -->
			<div class="j2store-before-display-productimages">
				<?php echo  $this->item->event->J2StoreBeforeDisplayProductImages;?>
			</div>
			<!--Main Image-->
			<?php if($this->layoutparams->get('show_product_list_thumb_image', false)): ?>

				<?php  if((isset($this->item->listview_thumb)) && ($this->item->listview_thumb) && JFile::exists(JPATH_SITE.'/'.$this->item->listview_thumb)):?>
					<?php if($this->layoutparams->get('product_list_link_thumb_to_product', false)): ?>
						<a itemprop="url" class="j2store-item-title-link" href="<?php echo $link?>">
					<?php endif; ?>
						<img class="j2store-item-productlist-thumbimage" itemprop="image" src="<?php echo $image_path.$this->item->listview_thumb;?>" alt="<?php echo $this->item->product_name; ?>" />

					<?php if($this->layoutparams->get('product_list_link_thumb_to_product', false)): ?>
						</a>
					<?php endif;?>

				<?php endif;?>

			<?php endif;?>
			<!-- After Displaying product images -->
			<div class="j2store-before-display-productimages">
				<?php echo $this->item->event->J2StoreAfterDisplayProductImages;?>
			</div>

			<!-- Before Display product Title -->
			<div class="j2store-before-display-product-title">
				<?php echo $this->item->event->J2StoreBeforeDisplayProductTitle;?>
			</div>

			<!-- Title -->
			<?php if($this->layoutparams->get('show_product_list_title', 1)):?>
				<h3 class="j2store-item-title" itemprop="name">
					<?php if($this->layoutparams->get('list_title_linkable', 1)):?>
					<a itemprop="url" class="j2store-item-title-link" href="<?php echo $link?>">
					<?php endif; ?>
						<?php echo $this->item->product_name;?>

					<?php if($this->layoutparams->get('list_title_linkable', 1)):?>
					</a>
					<?php endif; ?>
				</h3>
			<?php endif;?>

			<!-- After display product title -->
			<div class="j2store-after-display-product-title">
				<?php echo $this->item->event->J2StoreAfterDisplayProductTitle;?>
			</div>


			<!-- Item sku -->
			<?php if($this->layoutparams->get('product_list_show_sku', 1) && !empty($this->item->item_sku)): ?>
			<div class="j2store-item-sku">
				<span class="j2store-product-item-label"><?php echo JText::_('J2STORE_SKU');?></span>
				<span class="j2store-product-item-sku"  itemprop="sku"><?php echo (isset($this->item->item_sku)) ? $this->item->item_sku : "" ;?></span>
			</div>
			<?php endif;?>

			<!-- Price block -->
			<?php echo $this->loadTemplate('price'); ?>

			<!-- Stock -->
			<?php echo $this->loadTemplate('stock'); ?>

			<!-- Options -->
			<?php if($this->layoutparams->get('show_product_list_options', 1)): ?>
				<div class="j2store-product-options-groups">
					<?php  echo $this->item->optionhtml;?>
				</div>
			<?php endif;?>

			<!-- Cart block -->
				<!-- is catalogue mode enabled?-->
				<?php if(!$this->params->get('show_addtocart', 0)):?>
					<?php echo $this->loadTemplate('cart'); ?>
				<?php endif; //catalogue mode check ?>
				

			<?php if(isset($this->item->tagtitle)):?>
			<div class="j2store-product-tags">
				<span class="j2store-product-tags-list -badge badge-info"><?php echo $this->item->tagtitle;?></span>
			</div>
			<?php endif;?>

			<?php if($this->layoutparams->get('show_product_list_sdesc', 1)):?>
			<span itemprop="description"  class="j2store-product-description">
				<?php echo $this->item->short_description;?>
			</span>
			<?php endif;?>

			<?php if($this->layoutparams->get('show_product_list_ldesc')):?>
				<div itemprop="description" class="j2store-product-description">
					<?php echo $this->item->long_description;?>
				</div>
			<?php endif;?>
			<!-- hidden inputs -->
			<input type="hidden" name="return" value="<?php echo base64_encode( JUri::getInstance()->toString() ); ?>" />
			<input type="hidden" value="<?php  echo $this->item->product_id; ?>"  name="product_id"/>
			<input type="hidden" name="option" value="com_j2store" />
			<input type="hidden" name="productlayout" value="1" />
			<input type="hidden" name="view" value="mycart" />
			<input type="hidden" id="task" name="task" value="add" />
			<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		<!-- after displaying an product -->
		<div class="j2store-after-display-product">
			<?php echo $this->item->event->J2StoreAfterProductDisplay;?>
		</div>
