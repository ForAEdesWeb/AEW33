<?php
/*------------------------------------------------------------------------
 # mod_j2store_product_advanced
# ------------------------------------------------------------------------
# author    gokila priya - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2014 - 19 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$doc =JFactory::getDocument();
if (version_compare(JVERSION, '3.0', 'ge'))
{
	JHtml::_('jquery.framework');
}
$doc->addScript(JURI::root().'modules/mod_j2store_products/js/owl.carousel.min.js');
$doc->addStylesheet(JURI::root() . 'modules/mod_j2store_products/css/owl.carousel.css');
$doc->addStylesheet(JURI::root() . 'modules/mod_j2store_products/css/owl.theme.css');
$doc->addStylesheet(JURI::root() . 'modules/mod_j2store_products/css/j2store_products.css');
$j2store_path = JPATH_ADMINISTRATOR.'/components/com_j2store/j2store.php';
if(version_compare(J2STORE_VERSION, '3.0.0', 'ge')) {

}else{
if(JFile::exists($j2store_path)) {
	require_once (JPATH_SITE.'/components/com_j2store/helpers/cart.php');
	require_once (JPATH_ADMINISTRATOR.'/components/com_j2store/library/prices.php');
}
}

//assigning module id
$slider_id = 'jowl-slider-'.$module_id;

//image position
$image_position = $params->get('image_position', 'top');

if($image_position == 'top') {
	$style = 'clear:both;';
}elseif($image_position == 'left') {
	$style = 'float:left;';
}elseif($image_position == 'right') {
	$style = 'float:right;';
}
$j2params = JComponentHelper::getParams('com_j2store');
?>
<script>
 jQuery(document).ready(function() {
        jQuery("#<?php echo $slider_id;?>").owlCarousel({
			pagination:false,
			navigation: true,
		    navigationText: [
			"<i class='icon-chevron-left icon-white'></i>",
			"<i class='icon-chevron-right icon-white'></i>"
			],
			 afterInit : function(elem){
				 var that = this;
				 that.owlControls.prependTo(elem);
				 }
          });
 });
</script>

<div class="row-fluid">
	<div class="span12">
		<!-- Enables Product Slider Effects -->
		<?php if($params->get('show_product_slider',1)):?>
		<div class="jowl-module-product-slide">
			<div id="<?php echo $slider_id;?>" class="owl-carousel">
				<?php foreach($list as $item) : ?>
				<div
					class="item j2product product_<?php echo $item->id;?> j2store_product_block">
					<?php if($params->get('show_image', 1)):?>
					<?php $image_path = '';
							$image_path = ModJ2StoreProductsHelper::getImage($item->id, $params); ?>
					<?php if(!empty($image_path)):?>
					<div class="j2store_product_image_block" style="<?php echo $style;?>">
						<span class="j2store_product_image"> <img
									src="<?php echo JURI::root().$image_path;?>"
									alt="<?php echo $item->title; ?>"
									style="width:<?php echo $params->get('image_size_width');?>px;
									height:<?php echo $params->get('image_size_width');?>px;"
								/>
						</span>
					</div>
					<?php endif;?>
					<?php endif; ?>
					<?php
					if(!$params->get('show_image', 1) || empty($image_path)) {
						$span = '12';
					} else {
						$span = '6';
					}
					?>
					<div class="j2store_product_content_block">
						<?php if($params->get('show_title', 1)):?>
						<h5 class="j2store_product_title">
							<?php if($params->get('link_titles', 1)):?>
							<a href="<?php echo $item->link; ?>"
								class="j2store_product_title_link"> <?php echo $item->title; ?>
							</a>
							<?php else:?>
							<?php echo $item->title; ?>
							<?php endif;?>
						</h5>
						<?php endif; ?>
						<?php if($params->get('show_sku', 1) ||  $params->get('show_category', 1)):?>
						<div class="j2store_product_sku_category">
							<?php if($params->get('show_sku', 1)):?>
							<span class="j2store_product_sku"> <small><?php echo $item->product_sku; ?>
							</small>
							</span>
							<?php endif; ?>
							<?php if ($params->get('show_category', 1)) :?>
							<span class="j2store_product_category"> <?php echo $item->displayCategoryTitle; ?>
							</span>
							<?php endif; ?>
						</div>
						<?php endif;?>

						<?php if($params->get('show_introtext', 1)):?>
						<span class="j2store_product_introtext"> <?php echo $item->displayIntrotext; ?>
						</span>
						<?php endif; ?>
						<?php if ($params->get('show_readmore')) :?>
						<a class="j2store_product_readmore <?php echo $item->active; ?>"
							href="<?php echo $item->link; ?>"> <?php echo JText::_('MOD_J2STORE_PRODUCT_READ_MORE'); ?>
						</a>
						<?php endif;?>
						<?php if($params->get('show_price', 1)):?>
						<span id="j2store_product_price_<?php echo $item->product_id; ?>"
							class="j2store_product_price"> <?php if($item->special_price > 0.000) echo '<strike>'; ?>
							<?php  echo J2StoreHelperCart::dispayPriceWithTax($item->price, $item->tax, $j2params->get('price_display_options', 1)); ?>
							<?php if($item->special_price > 0.000) echo '</strike>'; ?>
						</span>
						<!--special price-->
						<?php if($item->special_price > 0.000) :?>
						<span
							id="j2store_product_special_price_<?php echo $item->product_id; ?>"
							class="j2store_product_special_price"> <?php  echo J2StoreHelperCart::dispayPriceWithTax($item->special_price, $item->sp_tax, $j2params->get('price_display_options', 1)); ?>
						</span>
						<?php endif;?>
						<?php endif; ?>
						<?php if($params->get('show_cartbutton', 1)):?>
						<span class="j2store_product_cart"> <?php  echo $item->j2store->cart_block; ?>
						</span>
						<?php endif;?>
					</div>
				</div>
				<?php endforeach;?>
			</div>
		</div>
		<?php else:?>
		<div
			class="mod_j2store_products<?php echo $moduleclass_sfx; ?> j2store_products">
			<ul class="j2store_products_container">
				<?php foreach($list as $item) : ?>
				<li
					class="j2product product_<?php echo $item->id;?> j2store_product_block">
					<?php if($params->get('show_image', 1)):?> <?php $image_path = '';

								$image_path = ModJ2StoreProductsHelper::getImage($item->id, $params); ?>
					<?php if(!empty($image_path)):?>
					<div class="j2store_product_image_block" style="<?php echo $style;?>">
						<span class="j2store_product_image"> <img
									src="<?php echo JURI::root().$image_path;?>"
									alt="<?php echo $item->title; ?>"
									style="width:<?php echo $params->get('image_size_width');?>px;
									height:<?php echo $params->get('image_size_width');?>px;"
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
								class="j2store_product_title_link"> <?php echo $item->title; ?>
							</a>
							<?php else:?>
							<?php echo $item->title; ?>
							<?php endif;?>
						</h2>
						<?php endif; ?>
						<?php if($params->get('show_sku', 1) ||  $params->get('show_category', 1)):?>
						<div class="j2store_product_sku_category">
							<?php if($params->get('show_sku', 1)):?>
							<span class="j2store_product_sku"> <small><?php echo $item->product_sku; ?>
							</small>
							</span>
							<?php endif; ?>
							<?php if ($params->get('show_category', 1)) :?>
							<span class="j2store_product_category"> <?php echo $item->displayCategoryTitle; ?>
							</span>
							<?php endif; ?>
						</div>
						<?php endif;?>
						<?php if($params->get('show_introtext', 1)):?>
						<span class="j2store_product_introtext"> <?php echo $item->displayIntrotext; ?>
						</span>
						<?php endif; ?>
						<?php if ($params->get('show_readmore')) :?>
						<a class="j2store_product_readmore <?php echo $item->active; ?>"
							href="<?php echo $item->link; ?>"> <?php echo JText::_('MOD_J2STORE_PRODUCT_READ_MORE'); ?>
						</a>
						<?php endif;?>
						<?php if($params->get('show_price', 1)):?>
						<span id="j2store_product_price_<?php echo $item->product_id; ?>"
							class="j2store_product_price"> <?php if($item->special_price > 0.000) echo '<strike>'; ?>
							<?php  echo J2StoreHelperCart::dispayPriceWithTax($item->price, $item->tax, $j2params->get('price_display_options', 1)); ?>
							<?php if($item->special_price > 0.000) echo '</strike>'; ?>
						</span>
						<!--special price-->
						<?php if($item->special_price > 0.000) :?>
						<span
							id="j2store_product_special_price_<?php echo $item->product_id; ?>"
							class="j2store_product_special_price"> <?php  echo J2StoreHelperCart::dispayPriceWithTax($item->special_price, $item->sp_tax, $j2params->get('price_display_options', 1)); ?>
						</span>
						<?php endif;?>
						<?php endif; ?>
						<?php if($params->get('show_cartbutton', 1)):?>
						<span class="j2store_product_cart">
							<?php echo $item->j2store->cart_block; ?>
						</span>
						<?php endif; ?>
					</div>
				</li>
				<?php endforeach;?>
			</ul>
		</div>
		<?php endif;?>
	</div>
</div>
