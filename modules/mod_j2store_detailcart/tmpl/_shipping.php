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
$session = JFactory::getSession();
$shipping_methods = $session->get('shipping_methods',array(), 'j2store');
$shipping_values=$session->get('shipping_values',array(), 'j2store');

if(isset($shipping_methods) && count($shipping_methods)):
?>
<div id="j2store-cart-shipping" class="detailcart-shipping-methods">
	<h4>
		<?php echo JText::_('J2STORE_DETAILCART_SHIPPING_METHODS');?>
	</h4>
	<?php $i=1 ;?>
	<?php foreach($shipping_methods as $method): ?>
	<?php
	$checked = '';
	if(isset($shipping_values['shipping_name']) && $shipping_values['shipping_name'] == $method['name']) {
		$checked = 'checked';
		}?>
	<span class="detailcart-shipping-method method-<?php echo $i; ?>"> <input
		type="radio" id="mod-shipping_<?php echo $method['element']; ?>"
		value="<?php echo $method['name']; ?>"
		rel="<?php echo addslashes($method['name'])?>" name="shipping_method"
		onClick="detailcartUpdateShipping('<?php echo addslashes($method['name']); ?>','<?php echo $method['price']; ?>',<?php echo $method['tax']; ?>,<?php echo $method['extra']; ?>, '<?php echo $method['code']; ?>', true );"
		<?php echo $checked; ?> /> <label
		for="shipping_<?php echo $method['element']; ?>"> <?php echo $method['name']; ?>
			( <?php echo J2StorePrices::number( $method['total']); ?> )
	</label>
	</span>
	<?php $i++;?>
	<?php endforeach; ?>
	<?php if($session->has('shipping_warning', 'j2store')):?>
	<span class="j2error"> <?php echo $session->get('shipping_warning', '', 'j2store');?>
	</span>
	<?php endif;?>

</div>
<?php endif;?>


<script type="text/javascript">

	function detailcartUpdateShipping(name, price, tax, extra, code, combined) {
		(function($) {
			$.ajax({
				url: 'index.php?option=com_j2store&view=mycart&task=shippingUpdate',
				type: 'post',
				cache: false,
				data: {'shipping_name':name, 'shipping_code':code, 'shipping_price':price, 'shipping_tax':tax, 'shipping_extra':extra},
				dataType: 'json',
				beforeSend: function() {
					$('#j2store-cart-shipping').after('<span class="wait">&nbsp;<img src="media/j2store/images/loader.gif" alt="" /></span>');
				},
				complete: function() {
					$('.wait').remove();
				},
				success: function(json) {
					$.ajax({
		   				url:"index.php?option=com_j2store&view=mycart&task=displayCart",
		   				type: 'post',
		   			 	cache: false,
		 				success: function(response){
		 					$('#detailJ2StoreCart').html(response);
		 				}
		   			});
				},
				error: function(xhr, ajaxOptions, thrownError) {
					//alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		})(j2store.jQuery);
	}

	</script>
