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
$app= JFactory::getApplication();
$doc = JFactory::getDocument();
$doc->addStyleSheet(JUri::root().'media/j2store/css/font-awesome.min.css');
if(isset($this->layout_data->params)){
	$registry = new JRegistry();
	$registry->loadString($this->layout_data->params);
	$this->layout_params = $registry;
}
$doc->addStyleSheet(JURI::root(true).'/media/j2store/css/j2store-product.css');
$doc->addScript(JURI::root(true).'/media/j2store/js/jquery.elevatezoom.js');
require_once (JPATH_SITE.'/components/com_j2store/helpers/utilities.php');
require_once (JPATH_ADMINISTRATOR.'/components/com_j2store/library/j2item.php');
$action = JRoute::_('index.php');
$showImageBlock = false;
if($this->layout_params->get('show_product_main_image', 1) && isset($this->item->main_image) && !empty($this->item->main_image)) {
$class='span6 col-md-6 col-lg-6 col-sm-6 col-xs-12';
$showImageBlock = true;
}else {
	$class='span12 col-md-12 col-lg-8 col-sm-8 col-xs-12';
}

//registered users check
$allow = true;
$is_register = $this->params->get('isregister', 0);
if($is_register && !JFactory::getUser()->id) {
	//user not logged in. set to false
	$allow = false;
}

?>
<style type="text/css">
.j2store-item-product-thumbimage{
	width : <?php echo (int) $this->layout_params->get('product_main_image_width', 100); ?>px;
}

.j2store-item-additionalimage-preview{
	height : <?php echo $this->layout_params->get('product_additional_image_height', 100); ?>px;
	width : <?php echo $this->layout_params->get('product_additional_image_width', 100); ?>px;
}
.j2store-item-cart-button{
	background:<?php echo $this->layout_params->get('add_to_cartbtn_background_color', '#0055B3');?>;
	color:<?php echo $this->layout_params->get('add_to_cartbtn_text_color', '#fff'); ?>;
}

</style>

<div class="j2store j2store-detail-product" id="j2store-detail-product-<?php echo $this->item->product_id; ?>"  itemscope itemtype="http://schema.org/Product">

	<form id="j2storeDetailProductForm" class="j2storeDetailProduct" enctype="multipart/form-data" name="j2storeProductForm" method="post" action="<?php echo JRoute::_('index.php?option=com_j2store&view=mycart'); ?>">

		<div class="j2store-before-product-display">
			<?php echo $this->item->event->J2StoreBeforeProductDisplay; ?>
		</div>
		<div class="row j2store-product-main">
			<?php if($showImageBlock): ?>
			<div class="span6 col-md-6 col-lg-6 col-sm-6 col-xs-12">
				<!-- load Image Partial layout -->
				<div class="j2store-product-images">
					<?php echo $this->loadTemplate('images');?>
				</div>
			</div>
			<?php endif; ?>
			<div class="<?php echo $class; ?> j2store-item-product-general-details">
				<!-- load General Partial layout -->
				<div class="j2store-product-general-details">

						<div class="j2store-before-display-product-title">
							<?php echo $this->item->event->J2StoreBeforeDisplayProductTitle; ?>
						</div>

						<!-- -Product Name -->
						<?php if($this->layout_params->get('show_product_title', 1)):?>
						<h2 class="j2store-item-product-title" itemprop="name">
							<?php echo $this->item->product_name;?>
						</h2>
						<?php endif;?>

						<!-- OnAfter DisplayProduct Title -->
						<span class="j2store-product-after-display-title">
							<?php echo $this->item->event->J2StoreAfterDisplayProductTitle; ?>
						</span>

						<!-- Sku-->
						<?php if(isset($this->item->item_sku) && !empty($this->item->item_sku) && $this->layout_params->get('show_product_sku', 1)):?>
								<span class="j2store-product-item-label">
									<?php echo JText::_('J2STORE_SKU');?>
								</span>
								<span class="j2store-product-item-sku"  itemprop="sku">
									<?php echo $this->item->item_sku;?>
								</span>
						<?php endif;?>
				</div>

				<div class="j2store-product-price-details">
					<?php  echo $this->loadTemplate('price');?>
				</div>

				<div class="j2store-product-stock-details">
					<?php  echo $this->loadTemplate('stock');?>
				</div>

				<div class="j2store-item-product-options">
					<?php  echo $this->item->optionhtml;?>
				</div>

				<!-- load Cart Partial layout -->
				<!-- is catalogue mode enabled? and load cart template-->
				<?php if(!$this->params->get('show_addtocart', 0)):?>
					<div class="j2store-product-cart-details">
						<?php  echo $this->loadTemplate('cart');?>
					</div>
				<?php endif; //catalogue mode check ?>

			</div>
		</div>

			<div class="row j2store-product-description">
	             <div class="span12 col-md-8 col-lg-8 col-sm-6 col-xs-12">
					 <!-- load Desc Partial layout -->
	    	         <?php echo $this->loadTemplate('desc');?>

							<?php if($this->layout_params->get('show_product_tags', 1) && (isset($this->item->product_tags)) && $this->item->product_tags):?>
								<div class="j2store-product-tags">
									<?php echo JText::_('J2STORE_PRODUCT_TAGS');?>
									<?php foreach ($this->item->product_tags as $tag):?>
										<span class="label label-badge"><?php echo $tag->tagtitle;?></span>
									<?php endforeach;?>
								</div>
							<?php endif;?>


					</div>
			</div>

	    <div class="j2store-after-product-display">
			<?php echo $this->item->event->J2StoreAfterProductDisplay; ?>
		</div>

		<div class="j2store-notification" style="display: none;">
			<div class="message"></div>
		</div>
		<input type="hidden" name="return" value="<?php echo base64_encode( JUri::getInstance()->toString() ); ?>" />
		<input type="hidden" value="<?php echo $this->item->product_id; ?>"  name="product_id"/>
		<input type="hidden" name="option" value="com_j2store" />
		<input type="hidden" name="view" value="mycart" />
		<input type="hidden" id="task" name="task" value="add" />
	</form>
</div>

<?php $action = JRoute::_('index.php?option=com_j2store&view=mycart');?>
<script type="text/javascript">
/** get the cart Text from the layout  **/
var layoutCartText ='<?php echo JText::_($this->layout_params->get('product_addtocart_alternative_text', 'J2STORE_ADD_TO_CART'));?>';
(function($) {
	$(document).ready(function(){

		$('.j2storeDetailProduct').each(function(){
		$(this).submit(function(e) {
			e.preventDefault();
			var form = $(this);

			/* Get input values from form */
			var values = form.serializeArray();


		$.ajax({
			url: j2storeURL+'index.php',
			type: 'post',
			data: values,
			dataType: 'json',
			beforeSend :function(){
				form.find("#addtocartBtn").attr('value','<?php echo JText::_('J2STORE_PRODUCT_ITEM_ADDING_TO_CART');?>');
			},
			success: function(json) {
				form.find('.j2success, .j2warning, .j2attention, .j2information, .j2error').remove();
				$('.j2store-notification').hide();
				if (json['error']) {
					$("#addtocartBtn").attr('value',layoutCartText);
					if (json['error']['option']) {
						for (i in json['error']['option']) {
							form.find('#option-' + i).after('<span class="j2error">' + json['error']['option'][i] + '</span>');
						}
					}
					if (json['error']['stock']) {
						form.find('.j2stock').after('<span class="j2error">' + json['error']['stock'] + '</span>');
					}

					if (json['error']['product']) {
						form.find('.j2product').after('<span class="j2error">' + json['error']['product'] + '</span>');
					}

				}
				if (json['success']) {
					doMiniCart();
					form.find("#j2store-add-to-cart-successmsg").fadeIn();
					form.find("#j2store-add-to-cart-successmsg").html("<span class='text text-success j2success'><strong>"+ json['successmsg'] +"</strong></span>");
					form.find("#addtocartBtn").attr('value','<?php echo JText::_('J2STORE_PRODUCT_ITEM_ADDED');?>');
					form.find("#j2store-add-to-cart-successmsg").fadeOut(2000);
					$(".checkout-link").hide();
					form.find(".checkout-link").show();

				}
			}

		});

		});
		});

	});

	})(j2store.jQuery);



/**
 * Method to get Increament Qty
 * @params string type id
 * return result
 */
function j2storeQtyPlus(id){
	var text_qty = jQuery("#"+id).val();

	text_qty++;
	jQuery("#"+id).val(text_qty);

	}

/**
 * Method to get Increament Qty
 * @params string type id
 * return result
 */
function j2storeQtyMinus(id){
	var text_qty = jQuery("#"+id).val();
	text_qty--;
	if(text_qty > 0){
		jQuery("#"+id).val(text_qty);
		}

	}

</script>
