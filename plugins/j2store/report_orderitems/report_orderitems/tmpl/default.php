<?php
/*------------------------------------------------------------------------
# com_j2store - J2Store
# ------------------------------------------------------------------------
# author    Gokila Priya - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2012 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
require_once(JPATH_SITE.'/components/com_j2store/helpers/orders.php');
$check_order_id=array();

?>
<?php
unset($listOrder);
$listOrder = $vars->state->get('filter_order', 'tbl.order_id');
$listDirn = $vars->state->get('filter_order_Dir');
$order_status =  $vars->state->get('filter_orderstatus');

$vars->state->get('filter_order_from_date');
$vars->state->get('filter_order_to_date');
$vars->state->get('filter_order_customer');
$vars->state->get('filter_order_customer_email');
?>
<?php $form = $vars->form;?>
<?php $items = $vars->list;?>

<div class="j2store">
	<form class="form-horizontal" method="post" action="<?php echo $form['action'];?>" name="adminForm" id="adminForm">
		<table class="adminlist table table-striped " >
			<tr>
				<td colspan="3">
			  		<?php echo JText::_('J2STORE_FILTER_SEARCH');?>
					<input type="text" name="filter_search" value="<?php echo htmlspecialchars($vars->state->get('filter_search')); ?>" id="search"/>
					<button class="btn btn-success" onclick="document.getElementById('reportTask').value='';this.form.submit();"><?php echo JText::_( 'J2STORE_FILTER_GO' ); ?></button>
					<button class="btn btn-inverse" onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'J2STORE_FILTER_RESET' ); ?></button>
				</td>

				<td>
					<?php
						$attribs = array('class'=>'input','onchange'=>'Joomla.submitform();');
						echo JHtml::_('select.genericlist',$vars->orderStatus,'filter_orderstatus',$attribs,'value', 'text', $vars->state->get('filter_orderstatus'));
					?>
				</td>
				<td><?php   echo $vars->pagination->getLimitBox();?></td>
			</tr>
			<tr>
				<td colspan="2">
					<label>
						<?php echo JText::_('J2STORE_ORDERS_EXPORT_FROM_DATE');?>
					</label>
					 	<?php echo JHtml::calendar($vars->state->get('filter_order_from_date'), 'filter_order_from_date','filter_order_from_date','%Y-%m-%d %H:%M:%S',array('class'=>'input-mini')); ?>

					<label>
						<?php echo JText::_('J2STORE_ORDERS_EXPORT_TO_DATE');?>
					</label>
						<?php echo JHtml::calendar($vars->state->get('filter_order_to_date'), 'filter_order_to_date','filter_order_to_date','%Y-%m-%d %H:%M:%S' ,array('class'=>'input-mini')); ?>
						<button class="btn btn-inverse" onclick="document.getElementById('filter_order_from_date').value='',document.getElementById('filter_order_to_date').value='';this.form.submit();">
						<i class="icon icon-remove"></i>
						</button>
				</td>
				<td>
					<label><?php echo JText::_('J2STORE_CUSTOMER');?></label>
					<input type="text" class="input-small" id="filter_order_customer" name="filter_order_customer" value="<?php echo htmlspecialchars($vars->state->get('filter_order_customer'));?>" />
					<button class="btn btn-inverse" onclick="document.getElementById('reportTask').value='';document.getElementById('filter_order_customer').value='';this.form.submit();">
						<i class="icon icon-remove"></i>
					</button>
					<label><?php echo JText::_('J2STORE_EMAILTEMPLATE_TAG_BILLING_EMAIL');?></label>
						<input type="text" class="input-small" id="filter_order_customer_email" name="filter_order_customer_email"
							   value="<?php echo htmlspecialchars($vars->state->get('filter_order_customer_email'));?>"  />
						<button class="btn btn-inverse" onclick="document.getElementById('filter_order_customer_email').value='';this.form.submit();">
							<i class="icon icon-remove"></i>
						</button>
					</td>
					<td>
						<label><?php echo JText::_('J2STORE_LAYOUT_PARAMS_SHOW_PRODUCT_TITLE');?></label>
						<input type="text" id="filter_order_product" name="filter_order_product" value="<?php echo htmlspecialchars($vars->state->get('filter_order_product'));?>" />
					    <button class="btn btn-inverse" onclick="document.getElementById('reportTask').value='';document.getElementById('filter_order_product').value='';this.form.submit();">
							<i class="icon icon-remove"></i>
						</button>
					</td>
					<td>
						<button class="btn btn-success btn-large" onclick="document.getElementById('reportTask').value='';this.form.submit();"><?php echo JText::_( 'J2STORE_FILTER' ); ?></button>
					</td>
				</tr>
		</table>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>
						<?php echo JHtml::_('grid.sort',  'J2STORE_ORDER_DATE', 'tbl.created_date', $listDirn, $listOrder); ?>
					</th>
					<th>
						<?php echo JHtml::_('grid.sort',  'J2STORE_ORDER_ID', 'tbl.order_id', $listDirn, $listOrder); ?>
					</th>
					<th>
						<?php echo JHtml::_('grid.sort',  'J2STORE_INVOICE_NO', 'invoice', $listDirn, $listOrder); ?>
					</th>
					<th>
						<?php echo JHtml::_('grid.sort',  'J2STORE_CUSTOMER_NAME', 'orderinfo.billing_first_name', $listDirn, $listOrder); ?>
					</th>
					<th>
						<?php echo JHtml::_('grid.sort',  'J2STORE_ORDER_STATUS', 'tbl.order_state', $listDirn, $listOrder); ?>
					</th>
					<th style="text-align:center;">
						<?php  echo JText::_('J2STORE_PRODUCT_DETAILS'); ?>
					</th>

					<th style="text-align:center;">
						<?php echo JHtml::_('grid.sort',  'J2STORE_TOTAL', 'tbl.order_total', $listDirn, $listOrder); ?>
					</th>

				</tr>
			</thead>
			<tfoot>
			<tr>
				<td colspan="9"><?php echo $vars->pagination->getListFooter(); ?>
				</td>
			</tr>

			</tfoot>
			<tbody>

			<?php if($items): ?>
				<?php
					$a=0;
					$order_id = 0;
				?>

				<?php foreach($items as $i => $item):
				?>
				<tr class="row-<?php echo $i%2;?>">
					<td>
						<?php echo JHtml::date($item->created_date, 'DATE_FORMAT_LC2', false);?>
					</td>
					<td>
						<a href="<?php echo JRoute::_("index.php?option=com_j2store&view=orders&task=view&id=".$item->id);?>">
							<?php echo $item->order_id;	?>
						</a>
					</td>
					<td style="text-align:center;" >
						<?php echo $item->invoice; ?>
					</td>
					<td >
						<?php echo $item->billing_first_name .' '. $item->billing_last_name;?>
						<?php echo $item->user_email;?>
					</td>
					<td>
						<label class="label <?php echo $item->orderstatus_cssclass; ?>" >
						<?php echo JText::_($item->orderstatus_name);?>
						</label>
					</td>
					<td>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>
										<small><?php echo JText::_('J2STORE_PRODUCT_NAME'); ?></small>
									</th>
									<th>
										<small><?php echo JText::_('J2STORE_QUANTITY');?></small>
									</th>
									<th>
										<small><?php echo JText::_('J2STORE_TOTAL');?></small>
									</th>
									<th>
										<small><?php echo JText::_('J2STORE_PRODUCT_OPTION');?></small>
									</th>
								</tr>
							</thead>
							<?php foreach($item->orderitems as $product):?>
							<tr>
								<td>
									<a target="_blank" href="<?php echo JRoute::_("index.php?option=com_content&task=article.edit&id=".$product->product_id);?>">
									<?php echo $product->orderitem_name; ?>
									</a>
								</td>
								<td>
									<?php echo $product->orderitem_quantity;?>
								</td>
								<td>
									<?php // echo $product->orderitem; ?>
									<strong><?php   echo J2StorePrices::number($product->orderitem_final_price , $item->currency_code, $item->currency_value, $format = true); ?></strong>
								</td>
								<td>
									<?php
										if(isset($product->orderitem_attribute_names) && $product->orderitem_attribute_names):
										$attributes =json_decode(stripcslashes($product->orderitem_attribute_names));
										foreach($attributes as $attr):?>
											<small><strong><?php echo $attr->name;?> :</strong> <?php echo $attr->value?></small><br/>
										<?php endforeach;?>
										<?php endif;?>
								</td>
							</tr>
							<?php endforeach;?>
							<tfoot>
								<tr>
								<td colspan="4">
									<div class="pull-right">
										<?php echo JText::_('J2STORE_CART_SUBTOTAL');?>
										<strong><?php echo J2StorePrices::number($item->order_subtotal, $item->currency_code, $item->currency_value, $format = true); ?></strong>
									</div>
									</td>
								</tr>
								<?php if($item->order_shipping > 0):?>
								<tr>
									<td colspan="4">
										<div class="pull-right">
										<?php echo JText::_('+');?>
										<?php echo JText::_('J2STORE_CART_SHIPPING_AND_HANDLING');?>
										<strong><?php echo J2StorePrices::number($item->order_shipping, $item->currency_code, $item->currency_value); ?></strong>
									</div>
								</td>
								</tr>
								<?php endif;?>

								<?php if($item->order_shipping_tax > 0):?>
								<tr>
									<td colspan="4">
									<div class="pull-right">
									<?php echo "(+)";?>
									<?php echo JText::_( "J2STORE_TAX_ON_SHIPPING" ); ?>

									<?php echo J2StorePrices::number($item->order_shipping_tax, $item->currency_code, $item->currency_value); ?>
									</div>
									</td>
								</tr>
							<?php endif; ?>

							<?php if($item->order_surcharge > 0):?>
								<tr>
								<td colspan="4">
								<div class="pull-right">
								<?php echo "(+)";?>
								<?php echo JText::_("J2STORE_CART_SURCHARGE"); ?>
								<?php echo J2StorePrices::number($item->order_surcharge, $item->currency_code, $item->currency_value); ?>
								</div>
								</td>

							</tr>
							<?php endif; ?>


					<?php if($item->order_discount > 0): 	?>
					<tr>
						<td colspan="4">
						<div class="pull-right">
						<?php
						if (!empty($item->order_discount ))
		                    	{
		                            echo "(-)";
		                            echo JText::_("J2STORE_CART_DISCOUNT");
		                    	}
		                   ?>
						<?php
						if (!empty($item->order_discount )) {
							echo J2StorePrices::number($item->order_discount, $item->currency_code, $item->currency_value);
						}
						?>
						</div>
						</td>
					</tr>
					<?php endif; ?>
					<?php if($item->order_tax > 0):?>
					<tr>
						<td colspan="4">
							<div class="pull-right">
								<?php if($vars->params->get('show_tax_total')):?>
									<?php echo JText::_("J2STORE_CART_PRODUCT_TAX_INCLUDED"); ?>
								<?php else: ?>
									<?php echo JText::_('J2STORE_CART_PRODUCT_TAX');?>
								<?php endif; ?>

								<?php echo J2StorePrices::number($item->order_tax, $item->currency_code, $item->currency_value); ?>
							</div>
							</td>
					</tr>
					<?php endif;?>
							</tfoot>
						</table>
					</td>
					<td style="text-align:center;">
						<strong><?php echo J2StorePrices::number($item->order_total , $item->currency_code, $item->currency_value, $format = true); ?></strong>
					</td>
				</tr>
				<?php endforeach; ?>
				<?php else: ?>
				<td colspan="9">
					<?php echo JText::_('J2STORE_NO_ITEMS_FOUND');?>
				</td>
				<?php endif;?>
			</tbody>
		</table>

		 <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<input type="hidden" id="reportTask" name="reportTask" value="" />
		<input type="hidden" name="task" value="view" />
		<input type="hidden" name="id" value=" <?php echo $vars->id; ?>" />
		<input type="hidden" name="boxchecked" value="" />
		<input type="hidden" name="order_change" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
<script type="text/javascript">
Joomla.submitform =function(){
	jQuery('#reportTask').val('');
	jQuery("#adminForm").submit();
}
</script>