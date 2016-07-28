<?php
/*------------------------------------------------------------------------
 # mod_j2store_products - J2Store
# ------------------------------------------------------------------------
# author    ThemeParrot - ThemeParrot http://www.ThemeParrot.com
# copyright Copyright (C) 2014 ThemeParrot.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://ThemeParrot.com
# Based on Latest Articles module of Joomla
-------------------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die('Restricted access');
?>

<div class="mod_j2store_products<?php echo $moduleclass_sfx; ?> j2store_products">

			<ul class="j2store_products_container">

				<?php foreach($list as $item) :
				if(!empty($item->addtocart_text)) {
					$cart_text = JText::_($item->addtocart_text);
				} else {
					$cart_text = JText::_('J2STORE_ADD_TO_CART');
				}
				?>
				<li class="j2product product-<?php echo $item->j2store_product_id;?>  j2store_product_block">
					<?php if($params->get('show_image', 1)):?> <?php $image_path = '';
						$image_path = ModJ2StoreProductsHelper::getImage($item, $params);
						?>
					<?php if(!empty($image_path)):?>
					<div class="j2store_product_image_block" style="<?php echo $style;?>">
						<span class="j2store_product_image"> <img
									src="<?php echo JURI::root().$image_path;?>"
									alt="<?php echo $item->product_name; ?>"
									width="<?php echo $params->get('image_size_width');?>"
									height="<?php echo $params->get('image_size_width', 'auto');?>"
									/>
						</span>
					</div> <?php endif;?> <?php endif; ?> <?php
					if(!$params->get('show_image', 1) || empty($image_path)) {
						$span = '12';
					} else {
						$span = '6';
					}
					?>
					<div class="j2store_product_content_block">
						<?php if($params->get('show_title', 1)):?>
						<h2 class="j2store_product_title">
							<?php if($params->get('link_titles', 1)):?>
							<a href="<?php echo $item->link; ?>"
								class="j2store_product_title_link"> <?php echo $item->product_name; ?>
							</a>
							<?php else:?>
								<?php echo $item->product_name; ?>
							<?php endif;?>
						</h2>
						<?php endif; ?>

						<?php if($params->get('show_introtext', 1)):?>
						<div class="j2store_product_introtext">
							<?php echo $item->source->displayIntrotext; ?>
						</div>
						<?php endif; ?>

						<?php if ($params->get('show_readmore')) :?>
						<a class="j2store_product_readmore <?php echo $item->active; ?>"
							href="<?php echo $item->link; ?>"> <?php echo JText::_('MOD_J2STORE_PRODUCT_READ_MORE'); ?>
						</a>
						<?php endif;?>

						<!-- Price Container  -->
						<?php if($params->get('show_price', 1)):?>
							<div class="product-price-container" id="j2store_product_price_<?php echo $item->j2store_product_id; ?>">
								<?php $class='';?>
									<?php if(isset($item->pricing->is_discount_pricing_available)) $class='strike'; ?>

									<div class="base-price <?php echo $class?>">
										<span class="product-element-value">
											<?php echo J2Store::product()->displayPrice($item->pricing->base_price, $item, $main_params);?>
										</span>
									</div>

								<?php /** *  If Special Price Exists	 */?>

								<?php if(isset($item->pricing->is_discount_pricing_available)):?>
									 <div class="sale-price">
										<span class="product-element-value">
											<?php echo J2Store::product()->displayPrice($item->pricing->price, $item, $main_params);?>
										</span>
									</div>
								<?php endif; ?>

							<?php if($main_params->get('display_price_with_tax_info', 0) ): ?>
								<div class="tax-text">
									<?php echo J2Store::product()->get_tax_text(); ?>
								</div>
							<?php endif; ?>

							</div>
						<?php endif; ?>

							<!-- contains cart related section -->
						<div class="j2store_product_cart j2store-product-list-cart">
						<form action="<?php echo JRoute::_('index.php?option=com_j2store&view=mycart'); ?>"
							method="post" name="j2storeProductForm"
							data-product_id="<?php echo $item->j2store_product_id; ?>"
							data-product_type="<?php echo $item->product_type; ?>"
							id="j2store-addtocart-form-<?php echo $item->j2store_product_id; ?>"
							class="j2store-addtocart-form">

						<?php if($params->get('show_cartbutton',1) && $item->product_type == 'simple'):?>
						<?php //this params is from module.xml file
							$cart_type = $params->get('list_show_cart', 1); ?>
						<?php if($cart_type == 1 && ($item->product_type == 'simple' || $item->product_type == 'downloadable' ))  : ?>

						<!-- Here product options  -->
							<?php  require( JModuleHelper::getLayoutPath('mod_j2store_products','options_v3'));?>
							<?php  require( JModuleHelper::getLayoutPath('mod_j2store_products','cart_v3'));?>
						<?php elseif( ($cart_type == 2 && count($item->options)) || $cart_type == 3 ):?>
							<a href="<?php echo $item->product_link; ?>" class="<?php echo $params->get('choosebtn_class', 'btn btn-success'); ?>"><?php echo JText::_('J2STORE_VIEW_PRODUCT_DETAILS'); ?></a>
							<?php echo J2Store::plugin()->eventWithHtml('AfterAddToCartButton', array($item, J2Store::utilities()->getContext('cart'))); ?>
								<?php if($params->get('list_enable_quickview',0)):?>
									<?php JHTML::_('behavior.modal', 'a.modal'); ?>
									<a itemprop="url" style="display:inline;position:relative;"
										class="modal j2store-product-quickview-modal"
										ref="{handler:'iframe',size:{x: window.innerWidth-180, y: window.innerHeight-180}}"
										href="<?php echo $item->quickview; ?>">
										<i class="fa fa-eye"></i>&nbsp;<?php echo JText::_('J2STORE_PRODUCT_QUICKVIEW');?>
									</a>
								<?php endif;?>
							<?php else:?>
								<?php require( JModuleHelper::getLayoutPath('mod_j2store_products','cart_v3'));?>
							<?php endif;?>
						<?php else:?>
									<a href="<?php echo $item->product_link; ?>" class="<?php echo $params->get('choosebtn_class', 'btn btn-success'); ?>"><?php echo JText::_('J2STORE_VIEW_PRODUCT_DETAILS'); ?></a>
									<?php echo J2Store::plugin()->eventWithHtml('AfterAddToCartButton', array($item, J2Store::utilities()->getContext('cart'))); ?>
								<?php if($params->get('list_enable_quickview',0)):?>
									<?php JHTML::_('behavior.modal', 'a.modal'); ?>
									<a itemprop="url" style="display:inline;position:relative;"
										class="modal j2store-product-quickview-modal"
										ref="{handler:'iframe',size:{x: window.innerWidth-180, y: window.innerHeight-180}}"
										href="<?php echo $item->quickview; ?>">
										<i class="fa fa-eye"></i>&nbsp;<?php echo JText::_('J2STORE_PRODUCT_QUICKVIEW');?>
									</a>
									<?php endif;?>
						<?php endif;?>
								<input type="hidden" name="option" value="com_j2store" />
								<input type="hidden" name="view" value="carts" />
								<input type="hidden" name="task" value="addItem" />
								<input type="hidden" name="ajax" value="1" />
								<?php echo JHTML::_( 'form.token' ); ?>
								<input type="hidden" name="return" value="<?php echo base64_encode( JUri::getInstance()->toString() ); ?>" />
							<div class="j2store-notifications"></div>
						</form>
					</div>
				</div>
			</li>
		<?php endforeach;?>
	</ul>
</div>
