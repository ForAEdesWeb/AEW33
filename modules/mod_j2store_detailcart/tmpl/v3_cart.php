<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 */
// No direct access to this file
defined('_JEXEC') or die;
$model = F0FModel::getTmpInstance('Carts', 'J2StoreModel');
$order = modJ2StoreDetailCartHelper::$_order;
$taxes = modJ2StoreDetailCartHelper::$_taxes;
$shipping = modJ2StoreDetailCartHelper::$_shipping;
$coupons = modJ2StoreDetailCartHelper::$_coupons;
$vouchers = modJ2StoreDetailCartHelper::$_vouchers;
?>
<style>
.cart-thumb-image img {
	width:80px;
}
</style>
<?php if($items):?>
<table id="detailCart" class="j2store-cart-table table table-bordered table-striped">
	<?php if($params->get('show_table_header', 1)) : ?>
	<thead>
		<tr>
			<th><?php echo JText::_('J2STORE_CART_LINE_ITEM'); ?></th>
			<?php if(isset($taxes) && count($taxes) && $main_params->get('show_item_tax', 0)): ?>
			<th><?php echo JText::_('J2STORE_CART_LINE_ITEM_TAX'); ?>
			<?php endif; ?>
			<?php if($params->get('show_product_price', 1)):?>
			<th><?php echo JText::_('J2STORE_CART_LINE_ITEM_TOTAL'); ?></th>
			<?php endif;?>
		</tr>
	</thead>
	<?php endif;?>
	<tbody>

		<?php foreach ($items as $key => $item): ?>
		<?php

		$registry = new JRegistry;
		$registry->loadString($item->orderitem_params);
		$item->params = $registry;
		$thumb_image = $item->params->get('thumb_image', '');

		?>
		<tr>
			<td>
				<?php if($main_params->get('show_thumb_cart', 1) && !empty($thumb_image)): ?>
					<span class="cart-thumb-image">
					<img
						alt="<?php echo $item->orderitem_name; ?>"
						src="<?php echo $thumb_image; ?>" />
					</span>
					<?php endif; ?>
					<span class="cart-product-name">
					<?php if($params->get('show_product_name', 1)):?>
						<?php echo $item->orderitem_name; ?>
					<?php endif;?>
					<?php if($params->get('show_product_qty', 1)):?>
						x <?php echo $item->orderitem_quantity; ?>
					<?php endif;?>



					</span>

					<br />
					<?php if( $params->get('show_product_options', 1) && isset($item->orderitemattributes) && $item->orderitemattributes): ?>
					<span class="cart-item-options"> <?php foreach ($item->orderitemattributes as $attribute): ?>
						<small> - <?php echo JText::_($attribute->orderitemattribute_name); ?>
							: <?php echo $attribute->orderitemattribute_value; ?>
						</small> <br /> <?php endforeach;?>
					</span>
					<?php endif; ?>


				<?php if($main_params->get('show_price_field', 1)): ?>
				<span class="cart-product-unit-price">
					<span class="cart-item-title">
						<?php echo JText::_('J2STORE_CART_LINE_ITEM_UNIT_PRICE'); ?>
					</span>
				<span class="cart-item-value">
					<?php  echo $currency->format($order->get_formatted_lineitem_price($item, $main_params->get('checkout_price_display_options', 1))); ?>
				</span>
			</span> <?php endif; ?>
			<?php if( $params->get('show_product_sku', 1)): ?>
				<br />
				<span class="cart-product-sku">
					<span class="cart-item-title">
						<?php echo JText::_('J2STORE_CART_LINE_ITEM_SKU'); ?>
					</span>
					<span class="cart-item-value">
						<?php echo $item->orderitem_sku; ?>
					</span>
				</span>
			 <?php endif; ?>
			</td>

			<?php if(isset($taxes) && count($taxes) && $params->get('show_item_tax', 0)): ?>
			<td>
				<?php  echo $currency->format($item->orderitem_tax);?>
			</td>
			<?php endif; ?>
			<?php if($params->get('show_product_price', 1)):?>
			<td class="cart-line-subtotal">
				<?php echo $currency->format($order->get_formatted_lineitem_total($item, $params->get('checkout_price_display_options', 1))); ?>
			</td>
			<?php endif; ?>
			<td>
			<?php if($params->get('show_remove_cart', 1)):?>
						<a 	class="j2store-remove remove-icon" onclick="j2storeDetailCartRemove('<?php echo $key;?>',<?php echo $item->cart_id;?>,2)" >
							<i class="icon icon-trash"></i>
						</a>
					<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
		<tfooter>
			<?php require( JModuleHelper::getLayoutPath('mod_j2store_detailcart','v3_total'));?>
		</tfooter>

	</tbody>

</table>
<div class="mod-j2storedetailcart-status"></div>
<?php else: ?>
<?php echo JText::_('J2STORE_NO_ITEMS_FOUND');?>
<?php endif;?>
<script>

function j2storeDetailCartRemove(key, product_id, pop_up) {
	(function($) {

	var container;
	if (pop_up == 1) {
		container = $('#sbox-content');
	} else {
		container = $('#j2storeCartPopup');
	}
	var myurl = j2storeURL+'index.php?option=com_j2store&view=carts&task=remove&cart_id='+product_id+'&popup='+ pop_up;
	$.ajax({
				url : myurl,
				type: 'post',
				data : "remove=1&key=" + key,
				//update : container,
				success: function(response) {
					 location.reload();
				}});

	})(j2store.jQuery);
}

function getDetailCartUpdate(product_id,input){
	 (function($){
		 var new_qty;
		 var old_qty =$("#detailCartQty"+product_id).attr('value');
		 var data = $(input).serialize();
		$.ajax({
			dataType: 'json',
			url	   :'index.php?option=com_j2store&view=carts&task=update',
			data   :data,
			complete: function(response){
				doMiniCart();
			}
		});
  	})(j2store.jQuery);
 }
</script>