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

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<h3>
	<?php echo JText::_('J2STORE_DETAILCART_MYITEMS');?>
</h3>
<?php if(count($items['products'])) : ?>
<table id="detailCart"
	class="adminlist table table-striped table-bordered table-hover">
	<?php if($params->get('show_table_header', 1)) : ?>
	<thead>
		<tr>
			<th style="text-align: left;">
				<?php echo JText::_( "J2STORE_CART_ITEM" ); ?>
			</th>
			<?php if($params->get('show_product_qty', 1)):?>
			<th style="text-align: center;"><?php echo JText::_( "J2STORE_CART_QUANTITY" ); ?>
			</th>
			<?php endif;?>
			<?php if($params->get('show_product_price', 1)):?>
			<th style="text-align: center;"><?php echo JText::_( "J2STORE_CART_ITEM_TOTAL" ); ?>
			</th>
			<?php endif; ?>

		</tr>
	</thead>
	<?php endif; ?>
	<tbody>
		<?php $i=0; $k=0; $subtotal = 0;?>
		<?php foreach ($items['products'] as $item) :
		?>
		<?php
		$link = JRoute::_("index.php?option=com_content&view=article&id=".$item['product_id']);
		$image = J2StoreItem::getJ2Image($item['product_id'], $params);
		?>
		<tr class="row<?php echo $k; ?>">
			<td>
				<?php if($params->get('show_thumb_cart', 0)) : ?>
				<span 	class="j2store-cart-item-image"> <?php if(!empty($image)) {
					echo $image;
				}?>
				</span>
			<?php endif; ?>
			<?php if($params->get('show_product_name', 1)):?>
				<span class="j2store_product_name">
					<?php echo $item['product_name']; ?>
				</span>
			 <br /> <?php endif; ?>
			 <?php if($params->get('show_product_options', 1)):?>
				<span class="j2store_product_options">
				<?php if (!empty($item['product_options'])) : ?>
					<?php foreach ($item['product_options'] as $option) : ?> - <small>
						<?php echo $option['name']; ?>: <?php echo (utf8_strlen($option['value']) > 20 ? utf8_substr($option['value'], 0, 20) . '..' : $option['value']); ?>
						<?php if($params->get('show_product_sku', 1)  && isset($option['option_sku']) && JString::strlen($option['option_sku']) > 0):?>
						(<?php echo JText::_('J2STORE_SKU'); ?> : <?php echo $option['option_sku']; ?>)
						<?php endif; ?>
						</small><br />
					<?php endforeach; ?>
				<?php endif; ?>
				<?php endif; ?>
					<?php if($params->get('show_product_sku', 1) && JString::strlen($item['product_model']) > 0) : ?>
					<span class="j2store_product_sku"> <?php echo JText::_( "J2STORE_SKU" ); ?>:
						<?php echo $item['product_model']; ?>
				</span> <?php endif; ?>

			</td>
			<?php if($params->get('show_qty_update', 1)):?>
			<td style="text-align: center;">
				<ul class="detailcartmodule-qty-option-list">
					<li class="pqty-update"><i
						class="icon-arrow-up glyphicon glyphicon-chevron-up"
						onclick="getDetailCartUpdate(<?php echo $item['product_id']; ?>,'+')"></i>
					</li>
					<li><span class="j2store-qty-update-btn"> <?php if($params->get('show_product_qty', 1)):?>
							<?php echo $item['quantity']; ?> <?php endif; ?>
					</span>
					</li>
					<li class="pqty-update"><i
						class="icon-arrow-down glyphicon glyphicon-chevron-up pqty-update"
						onclick="getDetailCartUpdate(<?php echo $item['product_id']; ?>,'-')"></i>
					</li>
				</ul> <input type="hidden"
				id="detailCartQty<?php echo $item['product_id']; ?>"
				name="quantity[<?php echo $item['key']; ?>]"
				value="<?php echo $item['quantity']; ?>" size="1" />
			</td>
			<?php endif; ?>
			<?php if($params->get('show_product_price', 1)):?>
			<td style="text-align: right;"><?php $subtotal = $subtotal + $item['total']; ?>
				<?php echo J2StorePrices::number($item['total']); ?>
			</td>
			<?php endif; ?>
			<?php if($params->get('show_remove_cart', 1)):?>
			<td style="text-align: center;"><a href="javascript:void(0)"
				title="<?php echo JText::_( 'J2STORE_CART_REMOVE_ITEM' ); ?>"
				onclick="j2storeDetailCartRemove('<?php echo $item['key']; ?>', <?php echo $item['product_id']; ?>, 2)">
					<span class="removecart"> x</span>
			</a>
			</td>
			<?php endif;?>
		</tr>
		<?php ++$i; $k = (1 - $k); ?>
		<?php endforeach; ?>
	</tbody>
	<tfoot class="j2store-cart-footer">
		<!-- subtotal -->
		<tr class="cart_subtotal">
			<td style="font-weight: bold; text-align: right;"><?php echo JText::_( "J2STORE_CART_SUBTOTAL" ); ?>
			</td>
			<td colspan="3" style="text-align: right;"><?php echo J2StorePrices::number($items['subtotal']); ?>
			</td>
		</tr>
		<?php if(isset($items['shipping_total'])): ?>
		<tr class="row<?php echo $k; ?>">
			<td style="font-weight: bold; text-align: right;"><?php echo $items['shipping_name']; ?>
			</td>
			<td colspan="3" style="text-align: right;"><?php echo J2StorePrices::number($items['shipping_total']); ?>
			</td>
		</tr>
		<?php endif; ?>
		<!-- coupon -->
		<?php if(isset($items['coupon'])): ?>
		<tr>
			<td style="font-weight: bold; text-align: right;"><?php echo $items['coupon']['title']; ?>
			</td>
			<td colspan="3" style="text-align: right;"><?php echo J2StorePrices::number($items['coupon']['value']); ?>
			</td>
		</tr>
		<?php endif;?>
		<!-- tax -->
		<?php if($j2params->get('show_tax_total', 1) && $items['taxes']):?>
		<tr>
			<td style="font-weight: bold; text-align: right;"><?php
			foreach($items['taxes'] as $tax) {
				echo $tax['title'].'<br />';
			}
			?>
			</td>
			<td colspan="3" style="text-align: right;"><?php
			foreach($items['taxes'] as $tax) {
				echo J2StorePrices::number($tax['value']).'<br />';
			}
			?>
			</td>
		</tr>
		<?php endif; ?>
		<!-- total-->
		<tr>
			<td style="font-weight: bold; text-align: right;"><?php echo JText::_( "J2STORE_CART_GRANDTOTAL" ); ?>
			</td>
			<td colspan="3" style="text-align: right;"><?php if($j2params->get('show_tax_total', 1)):?>
				<?php echo J2StorePrices::number($items['total']);?> <?php else: ?>
				<?php echo J2StorePrices::number($items['total_without_tax']);?> <?php endif; ?>
			</td>
		</tr>
	</tfoot>
</table>
<div class="mod-j2storedetailcart-status"></div>
<div class="cart_link">
	<!-- <button <?php if(!$show_checkout) echo 'disabled'; ?>  onclick="window.location='<?php echo $checkout_url; ?>';" class="btn btn-primary"><?php echo JText::_('J2STORE_DETAILCART_CHECKOUT');?></button>
	         -->

	<!--
		<button id="modj2storedetailcart"
	<?php if(!$show_checkout) echo 'disabled'; ?> class="btn btn-primary">
		<?php echo JText::_('J2STORE_DETAILCART_CHECKOUT');?>
	</button>
	-->
	<a href="<?php echo $checkout_url; ?>"
	<?php if(!$show_checkout) echo 'disabled'; ?> class="btn btn-primary">
		<?php echo JText::_('J2STORE_DETAILCART_CHECKOUT');?>
	</a>

</div>

<?php else: ?>
<?php echo JText::_('J2STORE_NO_ITEMS');?>
<?php endif;?>
<script type="text/javascript">
      function j2storeDetailCartRemove(key, product_id, pop_up) {
    		(function($) {

    		var container;
    		if (pop_up == 1) {
    			container = $('#sbox-content');
    		} else {
    			container = $('#j2storeCartPopup');
    		}
    		var myurl = j2storeURL+'index.php?option=com_j2store&view=mycart&task=update&popup='+ pop_up;
    		$.ajax({
    					url : myurl,
    					type: 'post',
    					data : "remove=1&key=" + key,
    					//update : container,
    					success: function(response) {

   							doMiniCart();
    					},// onSuccess
    					error: function() {
    						window.location(j2storeURL+"index.php?option=com_j2store&view=mycart&task=update&remove=1&cid["+ key + "]=" + product_id);
    					}// onFailure
    				});

    		})(j2store.jQuery);
    	}


     function getDetailCartUpdate(product_id,operator){
    	 (function($){
    		 var new_qty;
    		 var old_qty =$("#detailCartQty"+product_id).attr('value');
    		 if(operator == '+'){
    			 j2storeQtyPlus("detailCartQty"+product_id);

    		 }else{
    			 j2storeQtyMinus("detailCartQty"+product_id);
    		 }
           	 var data = $("#detailCartQty"+product_id).serialize();
			$.ajax({
				dataType: 'json',
				url	   :'index.php?option=com_j2store&view=mycart&task=update',
				data   :data,
				complete: function(response){
					doMiniCart();
				}
	 		});
       	})(j2store.jQuery);
      }

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
