<?php
/*------------------------------------------------------------------------
 # mod_j2store_cart - J2Store Cart
# ------------------------------------------------------------------------
# author    Ramesh Elamathi - ThemeParrot http://www.themeparrot.com
# copyright Copyright (C) 2012 ThemeParrot.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
-------------------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
			<tr>
				<td>
					<?php echo JText::_('J2STORE_CART_SUBTOTAL'); ?>
				</td>
				<td colspan="2">
					<?php echo $currency->format($order->get_formatted_subtotal($main_params->get('checkout_price_display_options', 1))); ?>
				</td>
			</tr>
				<!-- shipping -->
			<?php if(isset($order->order_shipping)): ?>
               <tr>
                  <td>
                        <?php echo JText::_(stripslashes($shipping->ordershipping_name)); ?>
                   </td>
                    <td colspan="2">
                        <?php echo $currency->format($order->order_shipping); ?>
                     </td>
                </tr>
				<?php endif; ?>
				<!-- shipping tax -->
				<?php if(isset($order->order_shipping_tax) && $order->order_shipping_tax > 0): ?>
                <tr>
                   <td>
                        <?php echo JText::_('J2STORE_ORDER_SHIPPING_TAX'); ?>
                    </td>
                     <td colspan="2">
                        <?php echo $currency->format($order->order_shipping_tax); ?>
                     </td>
                </tr>
				<?php endif; ?>

				 <!-- coupon -->

               <?php if(isset($coupons)): ?>
               <?php foreach($coupons as $coupon): ?>
               	<tr>
               		<td>
 							<?php echo JText::sprintf('J2STORE_COUPON_TITLE', $coupon->coupon_code); ?>
 							<a class="j2store-remove remove-icon" href="javascript:void(0)" onClick="jQuery('#j2store-cart-form #j2store-cart-task').val('removeCoupon'); jQuery('#j2store-cart-form').submit();" >X</a>
 					</td>
 					<td colspan="2">
 						 <?php echo $currency->format($coupon->amount); ?>

 					 </td>
 				</tr>
 				<?php endforeach; ?>
 				<?php endif;?>

 				<!-- voucher -->

               <?php if(isset($vouchers)): ?>
               <?php foreach($vouchers as $voucher): ?>
               	<tr>
               		<td>
 							<?php echo JText::sprintf('J2STORE_VOUCHER_TITLE', $voucher->voucher_code); ?>
 							<a class="j2store-remove remove-icon" href="javascript:void(0)" onClick="jQuery('#j2store-cart-form #j2store-cart-task').val('removeVoucher'); jQuery('#j2store-cart-form').submit();" >X</a>
 					</td>
 					 <td colspan="2">
 						 <?php echo $currency->format($voucher->amount); ?>

 					 </td>
 				</tr>
 				<?php endforeach; ?>
 				<?php endif;?>

				<!-- taxes -->
				<?php if(isset($taxes) && count($taxes) ): ?>
				<tr>
					<td>
							<?php if($main_params->get('checkout_price_display_options', 0) == 1): ?>
								<?php echo JText::_('J2STORE_CART_INCLUDING_TAX'); ?>
							<?php else: ?>
								<?php echo JText::_('J2STORE_CART_TAX'); ?>
							<?php endif; ?>
							<br />
							<?php foreach ($taxes as $tax): ?>
								<?php echo JText::_($tax->ordertax_title); ?> (<?php echo (float) $tax->ordertax_percent; ?> %)
								<br />
							<?php endforeach; ?>
					</td>
					<td colspan="2">
					<br />
					<?php foreach ($taxes as $tax): ?>
							<?php echo $currency->format($tax->ordertax_amount); ?>
							<br />
					<?php endforeach; ?>
					</td>
				</tr>
				<?php endif; ?>

				<tr>
					<td>
						<?php echo JText::_('J2STORE_CART_GRANDTOTAL'); ?>
					</td>
					<td colspan="2">
						<?php echo $currency->format($order->order_total); ?>
					</td>
				</tr>

