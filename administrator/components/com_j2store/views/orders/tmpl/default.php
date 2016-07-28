<?php
/*------------------------------------------------------------------------
 # com_j2store - J2Store
# ------------------------------------------------------------------------
# author    Sasi varna kumar - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2014 - 19 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.modal');
require_once (JPATH_ADMINISTRATOR.'/components/com_j2store/library/browser.php');
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
<div class="j2store span9">
<form action="index.php?option=com_j2store&view=orders" method="post"
	name="adminForm" id="adminForm">
	<table class="adminlist table table-striped">
		<tr>
			<td align="left" width="100%"><?php echo JText::_( 'J2STORE_FILTER_SEARCH' ); ?>:
				<input type="text" name="search" id="search"
				value="<?php echo htmlspecialchars($this->lists['search']);?>"
				class="text_area" onchange="document.adminForm.submit();" />
				<button class="btn btn-success" onclick="this.form.submit();">
					<?php echo JText::_( 'J2STORE_FILTER_GO' ); ?>
				</button>
				<button class="btn btn-inverse"
					onclick="document.getElementById('search').value='';this.form.submit();">
					<?php echo JText::_( 'J2STORE_FILTER_RESET' ); ?>
				</button>
			</td>
			<td nowrap="nowrap"><?php
			echo $this->lists['orderstate'];
			?>
			</td>
		</tr>
	</table>

	<table class="adminlist table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th width="1%"><?php echo JText::_( 'J2STORE_NUM' ); ?>
				</th>
				<th width="2%"><input type="checkbox" name="checkall-toggle"
					value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>"
					onclick="Joomla.checkAll(this)" />
				</th>
				<th width="5%" class="title"><?php echo JHTML::_('grid.sort',  'J2STORE_INVOICE_NO', 'a.order_id',$this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
				<?php if($this->params->get('show_unique_orderid', 0)): ?>
				<th width="5%" class="title"><?php echo JHTML::_('grid.sort',  'J2STORE_ORDER_ORDER_ID', 'a.order_id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
				<?php endif; ?>
				<th width="7%"><?php echo JHTML::_('grid.sort',  'J2STORE_ORDER_DATE', 'a.created_date', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
				<th width="20%" class="title"><?php echo JHTML::_('grid.sort',  'J2STORE_CUSTOMER', 'a.user_id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>

				<th width="7%"><?php echo JHTML::_('grid.sort',  'J2STORE_ORDER_AMOUNT', 'a.orderpayment_amount', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
				<th width="15%"><?php echo JHTML::_('grid.sort',  'J2STORE_ORDER_PAYMENT_TYPE', 'a.orderpayment_type', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
				<!--
			<th width="15%">
				<?php echo JHTML::_('grid.sort',  'J2STORE_ORDER_TRANSACTION_STATUS', 'a.transaction_status', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			 -->
				<th width="10%"><?php echo JHTML::_('grid.sort',  'J2STORE_ORDER_ORDER_STATUS', 'a.order_state_id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
				<th></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="9"><?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php
			$k = 0;
			for ($i=0, $n=count( $this->items ); $i < $n; $i++)
			{
				$row = &$this->items[$i];
				$link 	= JRoute::_( 'index.php?option=com_j2store&view=orders&task=view&id='. $row->id );

				//$checked 	= JHTML::_('grid.checkedout',   $row, $i );
				$checked = JHTML::_('grid.id', $i, $row->id );

				?>

			<tr class="<?php echo "row$k"; ?>">
				<td><?php echo $this->pagination->getRowOffset( $i ); ?>
				</td>
				<td><?php echo $checked; ?>
				</td>
				<td>
					<span class="editlinktip hasTip"
						title="<?php echo JText::_( 'J2STORE_ORDER_VIEW' );?>::<?php echo $this->escape($row->order_id); ?>">
						<a href="<?php echo $link ?>"><?php echo $this->escape($row->invoice); ?></a>
					</span>
				</td>
				<?php if($this->params->get('show_unique_orderid', 0)): ?>
				<td><span class="editlinktip hasTip"
					title="<?php echo JText::_( 'J2STORE_ORDER_VIEW' );?>::<?php echo $this->escape($row->order_id); ?>">
						<a href="<?php echo $link ?>"> <?php echo $this->escape($row->order_id); ?>
					</a>
				</span>
				</td>
 				<?php endif; ?>
 				<td><?php echo JHTML::_('date', $row->created_date, $this->params->get('date_format', JText::_('DATE_FORMAT_LC1'))); ?></td>
				<td align="center">
				<?php echo $row->billing_first_name .' '.$row->billing_last_name; ?>
				<br />
				<small>
				<?php if($row->bemail) {
					echo $row->bemail;
				}else {
					echo $row->user_email;
				}
				?>
				</small>
				<br />
				<?php if(!empty($row->coupon_code) && $row->coupon_amount):?>
					<small><?php echo JText::_('J2STORE_COUPON_CODE')?></small>  <label class="label label-success"><?php echo $row->coupon_code;?></label>
				<?php endif; ?>
				</td>

				<td align="center"><?php echo J2StorePrices::number( $row->orderpayment_amount, $row->currency_code, $row->currency_value ); ?>
				</td>
				<td align="center"><?php echo JText::_($row->orderpayment_type); ?>
				</td>
				<td align="center">
					<p align="center">
						<span class="label <?php echo $row->orderstatus_cssclass;?> order-state-label">
						<?php
							if(JString::strlen($row->order_state) > 0) {
								echo JText::_($row->order_state);
							} else {
								echo JText::_('J2STORE_PAYSTATUS_INCOMPLETE');
							}
						?>
						</span>
					</p>
						<?php echo JText::_("J2STORE_CHANGE_ORDER_STATUS"); ?>
						<?php $attr = array("class"=>"inputbox" , "id"=>"order_state_id_".$row->id);?>
						<?php echo JHTML::_('select.genericlist', $this->orderstate_options, 'order_state_id', $attr, 'value', 'text', $row->order_state_id,"order_state_id_".$row->id);?>
						<label>
						<input type="checkbox" name="notify_customer" id="notify_customer_<?php echo $row->id;?>" value="1" />
							<?php echo JText::_('J2STORE_NOTIFY_CUSTOMER');?>
						</label>
						<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
						<input type="hidden" name="return" value="orders" />
						<input class="btn btn-primary" id="order-list-save_<?php echo $row->id;?>" type="button" onclick="submitOrderState(<?php echo $row->id; ?>)"
							value="<?php echo JText::_('J2STORE_ORDER_STATUS_SAVE'); ?>" />
				</td>
				<td>
					<div class="order-list-print">
				<?php
					$url = JRoute::_( "index.php?option=com_j2store&view=orders&task=printOrder&tmpl=component&id=".@$row->id);
					?>
					<?php if(JBrowser::getInstance()->getBrowser() =='msie') :?>
						<a class="btn btn-primary btn-small" href="<?php echo $url; ?>" target="_blank"><?php echo JText::_( "J2STORE_PRINT_INVOICE" ); ?></a>
					<?php else: ?>
						<input type="button" class="btn btn-success" onclick="j2storeOpenModal('<?php echo $url; ?>')" value="<?php echo JText::_( "J2STORE_PRINT_INVOICE" ); ?>" />
					<?php endif; ?>
				</div>

				</td>



			</tr>
			<?php
			$k = 1 - $k;
			}
			?>
		</tbody>
	</table>

	<input type="hidden" name="option" value="com_j2store" /> <input
		type="hidden" name="view" value="orders" /> <input type="hidden"
		name="task" value="" /> <input type="hidden" name="boxchecked"
		value="0" /> <input type="hidden" name="filter_order"
		value="<?php echo $this->lists['order']; ?>" /> <input type="hidden"
		name="filter_order_Dir"
		value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>
<script type="text/javascript">
function submitOrderState(id){
	(function($) {
	var order_state = $("#order_state_id_"+id).attr('value');
	var notify_customer = 0;
	if($("#notify_customer_"+id).is(':checked')) {
		notify_customer = 1;
	}
	$.ajax({
		url: 'index.php?option=com_j2store&view=orders&task=orderstatesave',
		type: 'post',
		data: {'id':id,'return':'orders','notify_customer':notify_customer,'order_state_id':order_state},
		dataType: 'json',
		beforeSend: function() {
			$('#order-list-save_'+id).attr('disabled', true);
			$('#order-list-save_'+id).val('<?php echo JText::_('J2STORE_SAVING_CHANGES');?>...');
		},
		success: function(json) {
			if(json['success']){
				if(json['success']['link']){
					window.location =json['success']['link'];
				}
			}
		}
	});
	})(j2store.jQuery);
}
</script>