<?php
/*------------------------------------------------------------------------
 # com_j2store - J2Store
# ------------------------------------------------------------------------
# author    Ramesh Elamathi - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2014 - 19 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/


//no direct access
defined('_JEXEC') or die('Restricted access');

$row = @$this->row;
$order = @$this->order;
$items = @$order->getItems();
require_once (JPATH_ADMINISTRATOR.'/components/com_j2store/library/popup.php');
require_once (JPATH_ADMINISTRATOR.'/components/com_j2store/library/j2item.php');
require_once (JPATH_SITE.'/components/com_j2store/helpers/orders.php');
require_once (JPATH_ADMINISTRATOR.'/components/com_j2store/library/base.php');
$selectableBase = J2StoreFactory::getSelectableBase();
JHtml::_('behavior.modal');
$order_state_save_link = JRoute::_('index.php?option=com_j2store&view=orders&task=orderstatesave');

$showShipping = true;
if(isset($row->is_shippable) && !empty($row->is_shippable)) {
	if($row->is_shippable == '0') {
		$showShipping = false;
	}
}else {
	if(!$this->params->get('show_shipping_address')) {
		$showShipping = false;
	}
}

?>
<script type="text/javascript">
function j2storeOpenModal(url) {
	<?php if(JBrowser::getInstance()->getBrowser() =='msie') :?>
	var options = {size:{x:document.documentElement.­clientWidth-80, y: document.documentElement.­clientHeight-80}};
	<?php else: ?>
	var options = {size:{x: window.innerWidth-80, y: window.innerHeight-80}};
	<?php endif; ?>
	SqueezeBox.initialize();
	SqueezeBox.setOptions(options);
	SqueezeBox.setContent('iframe',url);
}
</script>
<div class="container-fluid j2store">

<div class='row-fluid'>
<?php if(!isset($this->guest)): ?>
	<div class="span6 pull-left">
		<a class="btn" href="<?php echo JRoute::_("index.php?option=com_j2store&view=orders"); ?>"><?php echo JText::_( 'J2STORE_ORDER_RETURN_TO_LIST' ); ?></a>
	</div>

<?php endif; ?>

<div class="span6 pull-right">
	<?php
	$url = JRoute::_( "index.php?option=com_j2store&view=orders&task=printOrder&tmpl=component&id=".@$row->id);
	?>
	<?php if(JBrowser::getInstance()->getBrowser() =='msie') :?>
		<a class="btn btn-primary" href="<?php echo $url; ?>" target="_blank"><?php echo JText::_( "J2STORE_PRINT_INVOICE" ); ?></a>
	<?php else: ?>
		<input type="button" class="btn btn-primary" onclick="j2storeOpenModal('<?php echo $url; ?>')" value="<?php echo JText::_( "J2STORE_PRINT_INVOICE" ); ?>" />
	<?php endif; ?>
	</div>

</div>

<div class='row-fluid'>
	<div class="span12">
		<h3><?php echo JText::_( "J2STORE_ORDER_DETAIL" ); ?></h3>
	</div>
</div>

<div class='row-fluid'>
	<div class="span6">
		<h3><?php echo JText::_("J2STORE_ORDER_INFORMATION"); ?></h3>
		<dl class="dl-horizontal">

			<?php if($this->params->get('show_unique_orderid', 0)): ?>
			<dt><?php echo JText::_("J2STORE_ORDER_ID"); ?> </dt>
			<dd><?php echo @$row->order_id; ?></dd>
			<?php endif; ?>

			 <?php
			 if(isset($row->invoice_number) && $row->invoice_number > 0) {
					$invoice_number = $row->invoice_prefix.$row->invoice_number;
				}else {
					$invoice_number = $row->id;
				}
			?>
			<dt><?php echo JText::_("J2STORE_INVOICE_NO"); ?></dt>
			<dd><?php echo $invoice_number; ?></dd>

			<dt><?php echo JText::_("J2STORE_ORDER_PAYMENT_AMOUNT"); ?></dt>
			<dd><?php echo J2StorePrices::number( $row->order_total, $row->currency_code, $row->currency_value ); ?></dd>

			<dt><?php echo JText::_("J2STORE_ORDER_DATE"); ?></dt>
			<dd><?php echo JHTML::_('date', $row->created_date, $this->params->get('date_format', JText::_('DATE_FORMAT_LC1'))); ?></dd>

			<dt><?php echo JText::_("J2STORE_ORDER_STATUS"); ?></dt>
			<dd>
			<span class="label <?php echo $this->label_class;?> order-state-label">
				<?php
				if(JString::strlen($row->order_state) > 0) {
					echo JText::_($row->order_state);
				} else {
					echo JText::_('J2STORE_PAYSTATUS_INCOMPLETE');
				}
				?>
			</span>
			</dd>
		</dl>
		<div class="well">
		<dl class="dl-horizontal">
			<dt>
					<?php echo JText::_("J2STORE_CHANGE_ORDER_STATUS"); ?>
				</dt>
				<dd>
					<?php // echo JText::_((@$row->order_state=='')?'':@$row->order_state); ?>
					<form action="<?php echo $order_state_save_link; ?>" method="post"
						name="adminForm">
						<?php echo @$this->order_state; ?>
						<br />
						<label>
						<input type="checkbox" name="notify_customer" value="1" />
						<?php echo JText::_('J2STORE_NOTIFY_CUSTOMER');?>
						</label>
						<br />
						<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
						<input class="btn btn-primary" type="submit"
							value="<?php echo JText::_('J2STORE_ORDER_STATUS_SAVE'); ?>" />
					</form>
				</dd>
		</dl>
		</div>

		<h3><?php echo JText::_("J2STORE_ORDER_PAYMENT_INFORMATION"); ?></h3>
		<dl class="dl-horizontal">
			<dt><?php echo JText::_('J2STORE_ORDER_PAYMENT_TYPE'); ?></dt>
			<dd><?php echo JText::_($row->orderpayment_type); ?></dd>

			<?php if(!empty($row->transaction_id)): ?>
							<dt><?php echo JText::_('J2STORE_ORDER_TRANSACTION_ID'); ?></dt>
							<dd><?php echo $row->transaction_id; ?></dd>
			<?php endif; ?>

				<dt>
					<?php echo JText::_('J2STORE_ORDER_TRANSACTION_LOG'); ?>
				</dt>
				<dd>
					<?php
					$log_url = "index.php?option=com_j2store&view=orders&task=viewtxnlog&tmpl=component&id=".@$row->id;
					$text = JText::_( "J2STORE_VIEW" );
					echo '<span class="btn">';
					echo J2StorePopup::popup( $log_url, $text );
					echo '</span>';
					?>
				</dd>
			<?php echo $selectableBase->getFormatedCustomFields($row, 'customfields', 'payment'); ?>

		</dl>
		<?php if(isset($order->event->J2StoreBeforeShippingDisplay)): ?>
					<?php echo $order->event->J2StoreBeforeShippingDisplay; ?>
				<?php endif; ?>
		<?php if(isset($this->shipping_info->ordershipping_type)): ?>
					<h3><?php echo JText::_('J2STORE_ORDER_SHIPPING_INFORMATION') ?></h3>
					<dl class="dl-horizontal">
						<dt><?php echo JText::_('J2STORE_ORDER_SHIPPING_NAME') ?></dt>
						<dd><?php echo JText::_($this->shipping_info->ordershipping_name); ?></dd>
					</dl>
		<?php endif; ?>
		<?php if(isset($order->event->J2StoreAfterShippingDisplay)): ?>
					<?php echo $order->event->J2StoreAfterShippingDisplay; ?>
		<?php endif; ?>


	</div>

	<div class="span6">
		<h3><?php echo JText::_("J2STORE_ORDER_CUSTOMER_INFORMATION"); ?></h3>
		<dl class="dl-horizontal">

				<dt><?php echo JText::_("J2STORE_BILLING_ADDRESS"); ?></dt>
				<dd>
				<address>

							<?php //TODO: legacy mode compatability. Those who do not have the order info will see this
							if(empty($row->user_email)) {
								$billAddr =  J2StoreOrdersHelper::getAddress($row->user_id);
								if(!empty($billAddr)) {
								echo '<strong>'.$billAddr->first_name." ".$billAddr->last_name."</strong><br/>";
								echo $billAddr->address_1.", ";
								echo $billAddr->address_2 ? $billAddr->address_2.", " : "<br/>";
								echo $billAddr->city.", ";
								echo $billAddr->state ? $billAddr->state." - " : "";
								echo $billAddr->zip." <br/>";
								echo $billAddr->country." <br/> ".JText::_('J2STORE_TELEPHONE').":";
								echo $billAddr->phone_1." , ";
								echo $billAddr->phone_2 ? $billAddr->phone_2.", " : "<br/> ";
								echo '<br/> ';
								echo $row->email;
								}
							} else {
								echo '<strong>'.$row->billing_first_name." ".$row->billing_last_name."</strong><br/>";
								echo $row->billing_address_1.", ";
								echo $row->billing_address_2 ? $row->billing_address_2.", " : "<br/>";
								echo $row->billing_city.", ";
								echo $row->billing_zone_name ? $row->billing_zone_name." - " : "";
								echo $row->billing_zip." <br/>";
								echo $row->billing_country_name." <br/> ".JText::_('J2STORE_TELEPHONE').":";
								echo $row->billing_phone_1." , ";
								echo $row->billing_phone_2 ? $row->billing_phone_2.", " : "<br/> ";
								echo '<br/> ';
								echo $row->user_email;
								echo '<br/> ';
								echo $row->billing_company ? JText::_('J2STORE_COMPANY_NAME').':&nbsp;'.$row->billing_company."</br>" : "";
								echo $row->billing_tax_number ? JText::_('J2STORE_TAX_ID').':&nbsp;'.$row->billing_tax_number."</br>" : "";
							}
							?>
					</address>
					</dd>
					<?php echo $selectableBase->getFormatedCustomFields($row, 'customfields', 'billing'); ?>

		 <?php if($showShipping): ?>
						<dt><?php echo JText::_("J2STORE_SHIPPING_ADDRESS"); ?></dt>
							<dd>
							<address>
							<?php //TODO: legacy mode compatability. Those who do not have the order info will see this
							if(empty($row->user_email)) {
								$shipAddr =  J2StoreOrdersHelper::getAddress($row->user_id);
								if(!empty($shipAddr)) {
								echo '<strong>'.$shipAddr->first_name." ".$shipAddr->last_name."</strong><br/>";
								echo $shipAddr->address_1.", ";
								echo $shipAddr->address_2 ? $shipAddr->address_2.", " : "<br/>";
								echo $shipAddr->city.", ";
								echo $shipAddr->state ? $shipAddr->state." - " : "";
								echo $shipAddr->zip." <br/>";
								echo $shipAddr->country." <br/> ".JText::_('J2STORE_TELEPHONE').":";
								echo $shipAddr->phone_1." , ";
								echo $shipAddr->phone_2 ? $shipAddr->phone_2.", " : "<br/> ";
								}

							} else {
								echo '<strong>'.$row->shipping_first_name." ".$row->shipping_last_name."</strong><br/>";
								echo $row->shipping_address_1.", ";
								echo $row->shipping_address_2 ? $row->shipping_address_2.", " : "<br/>";
								echo $row->shipping_city.", ";
								echo $row->shipping_zone_name ? $row->shipping_zone_name." - " : "";
								echo $row->shipping_zip." <br/>";
								echo $row->shipping_country_name;

								echo $row->shipping_phone_1." , ";
								echo $row->shipping_phone_2 ? $row->shipping_phone_2.", " : "<br/> ";
								echo '<br/> ';
								echo $row->shipping_company ? JText::_('J2STORE_COMPANY_NAME').':&nbsp;'.$row->shipping_company."</br>" : "";
								echo $row->shipping_tax_number ? JText::_('J2STORE_TAX_ID').':&nbsp;'.$row->shipping_tax_number."</br>" : "";
							}
							?>
							</address>
							</dd>

							<?php echo $selectableBase->getFormatedCustomFields($row, 'customfields', 'shipping'); ?>
					<?php endif; ?>

			 <?php if(!empty($row->customer_note)): ?>
			 <dt><?php echo JText::_("J2STORE_ORDER_CUSTOMER_NOTE"); ?></dt>
			 <dd><?php echo $row->customer_note; ?></dd>
			 <?php endif; ?>
		</dl>
	</div>
</div>
<div class="row-fluid">
<div class="span12">
	<h3>
		<?php echo JText::_("J2STORE_ITEMS_IN_ORDER"); ?>
	</h3>

	<table class="cart_order table table-striped table-bordered" style="clear: both;">
		<thead>
			<tr>
				<th style="text-align: left;"><?php echo JText::_("J2STORE_CART_ITEM"); ?></th>
				<th style="width: 150px; text-align: center;"><?php echo JText::_("J2STORE_CART_ITEM_QUANTITY"); ?>
				</th>
				<th style="width: 150px; text-align: right;"><?php echo JText::_("J2STORE_ITEM_PRICE"); ?>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php $i=0; $k=0; $colspan = 2;?>
			<?php foreach (@$items as $item) : ?>

			<tr class='row<?php echo $k; ?>'>
				<td>
				<strong>
						<?php echo JText::_( $item->orderitem_name ); ?>
					</strong>
						 <br />

					 	<!-- start of orderitem attributes -->

						<!-- backward compatibility -->
						<?php if(!J2StoreOrdersHelper::isJSON(stripslashes($item->orderitem_attribute_names))): ?>

							<?php if (!empty($item->orderitem_attribute_names)) : ?>
								<span><?php echo $item->orderitem_attribute_names; ?></span>
							<?php endif; ?>
						<br />
						<?php else: ?>
						<!-- since 3.1.0. Parse attributes that are saved in JSON format -->
						<?php if (!empty($item->orderitem_attribute_names)) : ?>
                            <?php
                            	//first convert from JSON to array
                            	$registry = new JRegistry;
                            	$registry->loadString(stripslashes($item->orderitem_attribute_names), 'JSON');
                            	$product_options = $registry->toObject();
                            ?>
                            	<?php foreach ($product_options as $option) : ?>
             				   - <small>
             				   <?php echo JText::_($option->name); ?>: <?php echo JText::_($option->value); ?>
             				   	<?php if(isset($option->option_sku) && JString::strlen($option->option_sku) > 0):?>
             				   			(<?php echo JText::_('J2STORE_SKU'); ?> : <?php echo $option->option_sku; ?>)
             				   	<?php endif; ?>
             				   </small><br />
            				   <?php endforeach; ?>
                            <br/>
                        <?php endif; ?>
					<?php endif; ?>
					<!-- end of orderitem attributes -->


					<?php if (!empty($item->orderitem_sku)) : ?> <b><?php echo JText::_( "J2STORE_SKU" ); ?>:</b>
					<?php echo $item->orderitem_sku; ?> <br /> <?php endif; ?> <b><?php echo JText::_( "J2STORE_CART_ITEM_UNIT_PRICE" ); ?>:</b>
					<?php echo J2StorePrices::number( $item->orderitem_price, $row->currency_code, $row->currency_value); ?>
				</td>
				<td style="text-align: center;"><?php echo $item->orderitem_quantity; ?>
				</td>
				<td style="text-align: right;"><?php echo J2StorePrices::number( $item->orderitem_final_price, $row->currency_code, $row->currency_value ); ?>
				</td>
			</tr>
			<?php $i=$i+1; $k = (1 - $k); ?>
			<?php endforeach; ?>

			<?php if (empty($items)) : ?>
			<tr>
				<td colspan="10" align="center"><?php echo JText::_('J2STORE_NO_ITEMS'); ?>
				</td>
			</tr>
			<?php endif; ?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="<?php echo $colspan; ?>" style="text-align: right;"><?php echo JText::_( "J2STORE_CART_SUBTOTAL" ); ?>
				</th>
				<th style="text-align: right;"><?php echo J2StorePrices::number($order->order_subtotal, $row->currency_code, $row->currency_value); ?>
				</th>
			</tr>

			<?php if($row->order_shipping > 0):?>
			<tr>
				<th colspan="<?php echo $colspan; ?>" style="text-align: right;">
				<?php echo "(+)";?>
				<?php echo JText::_( "J2STORE_SHIPPING" ); ?>
				</th>
				<th style="text-align: right;"><?php echo J2StorePrices::number($row->order_shipping, $row->currency_code, $row->currency_value); ?>
				</th>
			</tr>
			<?php endif; ?>

			<?php if($row->order_shipping_tax > 0):?>
			<tr>
				<th colspan="2" style="text-align: right;">
				<?php echo "(+)";?>
				<?php echo JText::_( "J2STORE_CART_SHIPPING_TAX" ); ?>
				</th>
				<th style="text-align: right;"><?php echo J2StorePrices::number($row->order_shipping_tax, $row->currency_code, $row->currency_value); ?>
				</th>
			</tr>
			<?php endif; ?>

			<?php if($row->order_surcharge > 0):?>
				<tr>
				<th colspan="2" style="text-align: right;">
				<?php echo "(+)";?>
				<?php echo JText::_("J2STORE_CART_SURCHARGE"); ?>
				</th>
				<th style="text-align: right;"><?php echo J2StorePrices::number($row->order_surcharge, $row->currency_code, $row->currency_value); ?>
				</th>

			</tr>
			<?php endif; ?>


			<?php if($order->order_discount > 0): 	?>
			<tr>
				<th colspan="<?php echo $colspan; ?>" style="text-align: right;">
				<?php
				if (!empty($order->order_discount ))
                    	{
                            echo "(-)";
                            echo JText::_("J2STORE_CART_DISCOUNT");
                    	}
                   ?>
                  <?php if(isset($row->coupon_code) && !empty($row->coupon_code)): ?>
					<br />
					<small class="muted">
						<?php echo JText::_('J2STORE_COUPON_CODE')?> <?php echo $row->coupon_code; ?>
					</small>
				<?php endif; ?>
				</th>

				<th style="text-align: right;">
				<?php
				if (!empty($order->order_discount )) {
					echo J2StorePrices::number($order->order_discount, $row->currency_code, $row->currency_value);
				}
				?>

				</th>
			</tr>
			<?php endif; ?>


			<?php if($row->order_tax > 0):?>
				<tr>
				<th colspan="<?php echo $colspan; ?>" style="text-align: right;">
				<?php
				if (!empty($this->show_tax)) {
					echo JText::_("J2STORE_CART_PRODUCT_TAX_INCLUDED");
				}
				else { echo JText::_("J2STORE_CART_PRODUCT_TAX");
				}
				?>
				<br />
				<?php
        		if( isset($this->ordertaxes) && is_array($this->ordertaxes)) {
					$last = count($this->ordertaxes); $i= 1;
					foreach ($this->ordertaxes as $ordertax) {
						echo JText::_($ordertax->ordertax_title);
						echo ' ( '.floatval($ordertax->ordertax_percent).' % )';
						if($i != $last) echo '<br />';
						$i++;
					}
				}
				?>
				</th>
				<th style="text-align: right;">
				<?php
        			if( isset($this->ordertaxes) && is_array($this->ordertaxes)) {
						echo '<br />';
						$i = 1;
						foreach ($this->ordertaxes as $ordertax) {
							echo J2StorePrices::number($ordertax->ordertax_amount);
							if($i != $last) echo '<br />';
							$i++;
						}
					} else {
						echo J2StorePrices::number($row->order_tax, $row->currency_code, $row->currency_value);
					}
				?>
				</th>
			</tr>
			<?php endif; ?>

			<tr>
				<th colspan="<?php echo $colspan; ?>" style="font-size: 120%; text-align: right;"><?php echo JText::_( "J2STORE_CART_GRANDTOTAL" ); ?>
				</th>
				<th style="font-size: 120%; text-align: right;"><?php echo J2StorePrices::number($row->order_total, $row->currency_code, $row->currency_value); ?>
				</th>

			</tr>
		</tfoot>
	</table>
</div>
</div>
</div>