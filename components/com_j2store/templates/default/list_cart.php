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
$checkout_link = JRoute::_('index.php?option=com_j2store&view=mycart');
?>

				<?php if($this->item->inventory->can_allow || $this->item->inventory->backorder):?>
					<!-- product quantity -->
					<?php if($this->layoutparams->get('product_list_show_qtybox', 1)):?>
	                 <div class="j2store-quantity">
		     		 	<div id='product_quantity_input_<?php echo $this->item->product_id; ?>' class="j2store-product-quantity-input">
							<span class="j2store-product-item-label">
								<?php echo $this->layoutparams->get('product_list_qty_alternative_text', JText::_('J2STORE_ADDTOCART_QUANTITY'));?></span>
								<input
									 style="width:<?php echo $this->layoutparams->get('show_qtybox_width', '30');?>px"
									 size="3"
									 class="input-mini j2store-product-qtybox"
									 id="add_to_cart_qty_input-<?php echo $this->item->product_id;?>"
									 type="text"
									 value="<?php echo $this->item->product_quantity; ?>"
									 name="product_qty" />


								<ul class="quantity-icon">
					         		<li>
					         			<?php $arrow_up =$this->layoutparams->get('qty_plus_icon','fa fa-chevron-up') ;?>
					         			<i class="<?php echo $arrow_up;?>"  onclick="j2storeQtyPlus('add_to_cart_qty_input-<?php echo $this->item->product_id;?>')"></i>
						         	</li>
								    <li>
								    	<?php $arrow_down = $this->layoutparams->get('qty_minus_icon','fa fa-chevron-up');?>
								    	<i class="<?php echo $arrow_down;?>"  onclick="j2storeQtyMinus('add_to_cart_qty_input-<?php echo $this->item->product_id;?>')">
								    	</i>
								  	</li>
								 </ul>
								 <?php if(isset($this->item->item_minimum_notice)):?>
								<br />
								<small class="j2store-minmum-quantity muted"><?php echo $this->item->item_minimum_notice; ?></small>
								<?php endif; ?>
						</div>
					</div>
					<?php else:?>
						<input type="hidden" name="product_qty" value="<?php echo $this->item->product_quantity; ?>" size="3" />
				    <?php endif; ?>

			<!-- cart button -->
			<?php if($this->layoutparams->get('product_list_show_add_to_cart', 1)):?>
				<span class="j2store-product-item-label" >
					<?php $cart_text = JText::_($this->layoutparams->get('product_list_addtocart_alternative_text', 'J2STORE_ADD_TO_CART'));?>
				</span>
				<input id="addtoCartBtn" type="submit" class="j2store-item-cart-button button <?php echo $this->layoutparams->get('add_to_cartbtn_class', ''); ?>" value="<?php echo $cart_text;?>" />
				<a style="display:none;" class="checkout-link" href="<?php echo $checkout_link; ?>"><?php echo JText::_('J2STORE_CHECKOUT')?></a>
			<?php endif;?>

			<?php else: ?>
				<div class="j2store_no_stock">
					<input value="<?php echo JText::_('J2STORE_OUT_OF_STOCK'); ?>" type="button" class="j2store-out-of-stock-button btn btn-warning" />
				</div>
			<?php endif; //inventory check ?>

			<div class="error_container">
				<div class="j2product"></div>
				<div class="j2stock"></div>
			</div>
