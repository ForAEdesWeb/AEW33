<?php
/*------------------------------------------------------------------------
 # com_j2store - J2Store
# ------------------------------------------------------------------------
# author    Ramesh Elamathi - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2012 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/
/** Check to ensure this file is included in Joomla! */
defined('_JEXEC') or die( 'Restricted access' );
$instock_text = JText::_($this->layoutparams->get('product_list_instock_alternative_text', 'J2STORE_IN_STOCK'));
?>
<?php if($this->layoutparams->get('product_list_show_option_stock', 0) && J2STORE_PRO==1 && isset($this->item->option_stock) && $this->item->manage_stock == 1):?>
<div class="j2store-product-option-stock">
<?php if($this->item->inventory->can_allow):?>
	<span class="j2store-instock-text"><?php echo $instock_text; ?></span>
	<?php foreach ($this->item->option_stock as $os): ?>
		<?php if($os->quantity > 0): ?>

		<span class="option-stock-combination option-stock-combination-<?php echo $os->productquantity_id; ?>">
			<?php if(!empty($os->product_attribute_names)): ?>
				<span class="option-combination-name">
					<?php echo $os->product_attribute_names; ?> :
				</span>
			<?php endif; ?>

			<span class="option-combination-quantity">
	 			<?php echo $os->quantity; ?>
			</span>
	</span>
		<?php endif; ?>
	<?php endforeach; ?>

	<?php elseif($this->item->inventory->backorder && $this->item->inventory->can_allow == 0):?>
				<?php echo JText::_('J2STORE_ADDTOCART_BACKORDER_ALERT'); ?>
	<?php else: ?>
			<span><link itemprop="availability"
			itemtype="http://schema.org/OutOfStock" /><?php echo JText::_( "J2STORE_OUT_OF_STOCK" ); ?></span>
	<?php endif; ?>
</div>
<?php endif; ?>


<?php if($this->layoutparams->get('product_list_show_stock', 0) && J2STORE_PRO==1 && $this->item->manage_stock == 1):?>
<div class="j2store-product-stock" itemprop="offers" itemscope
	itemtype="http://schema.org/Offer">
				<?php if($this->item->inventory->can_allow):?>
						<?php if($this->item->product_stock > 0): ?>
							<span class="j2store-product-item-qty">
								<link itemprop="availability" href="http://schema.org/InStock" /><?php echo $instock_text; ?>
								<?php echo $this->item->product_stock ;?>
							</span>
						<?php endif; ?>
					<?php elseif($this->item->inventory->backorder && $this->item->inventory->can_allow == 0):?>
							<?php echo JText::_('J2STORE_ADDTOCART_BACKORDER_ALERT'); ?>
					<?php else: ?>
						<span><link itemprop="availability"
			itemtype="http://schema.org/OutOfStock" /><?php echo JText::_( "J2STORE_OUT_OF_STOCK" ); ?></span>
					<?php endif; ?>

				</div>
<?php endif;?>