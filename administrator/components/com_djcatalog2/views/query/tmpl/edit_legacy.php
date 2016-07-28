<?php
/**
 * @version $Id: edit_legacy.php 281 2014-05-28 11:47:26Z michal $
 * @package DJ-Catalog2
 * @copyright Copyright (C) 2012 DJ-Extensions.com LTD, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Michal Olczyk - michal.olczyk@design-joomla.eu
 *
 * DJ-Catalog2 is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DJ-Catalog2 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DJ-Catalog2. If not, see <http://www.gnu.org/licenses/>.
 *
 */

// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

$params = JComponentHelper::getParams('com_djcatalog2');

$net_prices = (bool)((int)$params->get('price_including_tax', 1) == 0);

?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'query.cancel' || document.formvalidator.isValid(document.id('query-form'))) {
			Joomla.submitform(task, document.getElementById('query-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_djcatalog2&view=query&layout=edit&id='.(int) $this->item->id); ?>"
	method="post" name="adminForm" id="query-form" class="form-validate"
	enctype="multipart/form-data">
	
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_DJCATALOG2_QUERY_FIELDSET_CUSTOMER'); ?></legend>
			<ul class="adminformlist">
				<?php 
				$fields = $this->form->getFieldset('customer');
				foreach ($fields as $field) { ?>
				<?php 
					if ($field->fieldname == 'user_id') { ?>
					<?php 
					$value = '('.$field->value.')';
					$customer = JFactory::getUser($field->value);
					if (!empty($customer) && $customer->id > 0) {
						$value .= ' '.$customer->name.' / '.$customer->username;
					} else if ($field->value == 0 ){
						$value = '-';
					}
					?>
					<li><?php echo $field->title; ?>: <strong><?php echo $value; ?></strong></li>
				<?php } else { ?>
					<li><?php echo $field->title; ?>: <strong><?php echo $field->value; ?></strong></li>
				<?php } ?>
				<?php } ?>

			</ul>

		</fieldset>

	</div>
	
	<div class="width-40 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_DJCATALOG2_QUERY_FIELDSET_HEADER'); ?></legend>

			<ul class="adminformlist">
				<?php 
				$fields = $this->form->getFieldset('header');
				foreach ($fields as $field) { ?>
				<li><?php echo $field->title; ?>: <strong><?php echo $field->value; ?></strong></li>
				<?php } ?>

			</ul>

		</fieldset>
	</div>
	
	<div class="clr"></div>
	
	<div class="width-100">
	    <fieldset class="adminform">
	        <legend><?php echo JText::_( 'COM_DJCATALOG2_QUERY_ITEMS_FIELDSET' ); ?></legend>
	
	        <table class="admintable ordertable">
	            <thead>
	                <tr>
	                    <th width="5%">
	                        <?php echo JText::_('COM_DJCATALOG2_ITEM_ID') ?>
	                    </th>
	                    <th>
	                        <?php echo JText::_('COM_DJCATALOG2_NAME') ?>
	                    </th>
	                    <th width="10%">
	                        <?php echo JText::_('COM_DJCATALOG2_QUANTITY') ?>
	                    </th>
	                </tr>
	            </thead>
	            <tbody id="order_items">
	            <?php 
	            foreach ($this->item->items as $row) { ?>
	                <tr>
	                    <td>
	                        <input name="jform[order_items][item_id][<?php echo $row->id; ?>]" type="text" value="<?php echo $row->item_id ?>" size="5" disabled="disabled" readonly="readonly" />
	                    </td>
	                    <td>
	                        <input name="jform[order_items][item_name][<?php echo $row->id; ?>]" type="text" value="<?php echo $row->item_name ?>" size="30" disabled="disabled" readonly="readonly"/>
	                        <input name="jform[order_items][id][<?php echo $row->id; ?>]" type="hidden" value="<?php echo $row->id ?>" disabled="disabled" readonly="readonly"/>
	                    </td>
	                    <td>
	                        <input name="jform[order_items][quantity][<?php echo $row->id; ?>]" type="text" value="<?php echo $row->quantity ?>" size="5" class="calc quantity" disabled="disabled" readonly="readonly"/>
	                    </td>
	                </tr>
	            <?php } ?>
	            </tbody>
	        </table>
	    </fieldset>
	</div>
	
	
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
