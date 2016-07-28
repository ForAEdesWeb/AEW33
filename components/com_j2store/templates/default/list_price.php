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
//get the price text
$price_text = JText::_($this->layoutparams->get('product_list_price_alternative_text', 'J2STORE_ITEM_PRICE'));

?>
		<div class="j2store-before-display-product-price">
			<?php echo $this->item->event->J2StoreBeforeDisplayProductPrice; ?>
		</div>

		<div class="j2store-product-prices">

		<!-- Base price of the product -->
		<?php if($this->layoutparams->get('show_product_list_price', 1)): ?>
			<?php if($this->params->get('show_price_field', 1)):?>
				<span class="j2store-product-item-label"><?php echo $price_text; ?></span>
				<?php if((isset($this->item->prices->product_specialprice) && $this->item->prices->product_specialprice > 0) || (isset($this->item->prices->product_customer_groupprice) && $this->item->prices->product_customer_groupprice >=0)) echo '<strike>'; ?>
				<span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
					<span itemprop="price" class="text" id="product_price_<?php echo $this->item->product_id; ?>" class="product_price" itemprop="price">
						<?php echo J2StoreHelperCart::dispayPriceWithTax($this->item->prices->product_baseprice, $this->taxClass->getProductTax($this->item->prices->product_baseprice,$this->item->product_id), $this->params->get('price_display_options', 1)); ?>
					</span>
				</span>
			<?php if((isset($this->item->prices->product_specialprice) && $this->item->prices->product_specialprice > 0) || (isset($this->item->prices->product_customer_groupprice) && $this->item->prices->product_customer_groupprice >=0)) echo '</strike>'; ?>
			<?php endif; ?>

		<?php endif; ?>

		<!-- Do we have an offer. Display it here -->

		<?php if( $this->layoutparams->get('show_product_list_price_discount_percentage', 1)):?>
			<?php if((isset($this->item->prices->product_specialprice) || (isset($this->item->prices->product_customer_groupprice)) )):?>
			    <?php if((isset($this->item->prices->product_price)) && (isset($this->item->prices->product_baseprice))  && $this->item->prices->product_price > 0):
					    //Offer Percent  = (1- (sales price - original price ))* 100
				   $discount =(1 - ($this->item->prices->product_price / $this->item->prices->product_baseprice) ) * 100; ?>
				   <?php if($discount > 0): ?>
				    <span class="product-discount-offer" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
			    		<?php  echo JText::sprintf('J2STORE_PRODUCT_OFFER', round($discount)) ."%";?>
				    </span>
				    <?php endif;?>
		  		 <?php endif;?>
			<?php endif;?>
		<?php endif;?>

		  <?php if($this->layoutparams->get('show_product_list_special_price', 1) && isset($this->item->prices->product_specialprice)):?>
		  		<span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
					<span itemprop="price" id="product_special_price_<?php echo $this->item->product_id; ?>" class="product-special-price">
						<?php echo J2StoreHelperCart::dispayPriceWithTax($this->item->prices->product_specialprice, $this->taxClass->getProductTax($this->item->prices->product_specialprice,$this->item->product_id), $this->params->get('price_display_options', 1)); ?>
					</span>
				</span>
		<?php endif;?>

		<!--  we may have a customer group price -->
		  <?php if(isset($this->item->prices->product_customer_groupprice) && !empty($this->item->prices->product_customer_groupprice)):?>
		  		<span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
					<span itemprop="price" id="product_special_price_<?php echo $this->item->product_id; ?>" class="product-special-price">
						<?php echo J2StoreHelperCart::dispayPriceWithTax($this->item->prices->product_price, $this->taxClass->getProductTax($this->item->prices->product_price,$this->item->product_id), $this->params->get('price_display_options', 1)); ?>
					</span>
				</span>
		<?php endif;?>
		</div>


		<div class="j2store-after-display-product-price">
			<?php echo $this->item->event->J2StoreAfterDisplayProductPrice; ?>
		</div>