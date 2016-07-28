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

// No direct access to this file
defined('_JEXEC') or die;
$form_prefix = "jform[attribs][j2product]";
?>

	<?php if(isset($vars->product_id)): ?>
	<div class="j2store">
		<div class="control-group ">
				<div class="control-label">
					<label title="" class="hasTooltip">
						<?php echo JText::_('J2STORE_PRODUCT_ID'); ?>
					</label>
				</div>
				<div class="controls">
					<?php echo $vars->product_id; ?>
				</div>
			</div>
			<div class="control-group ">
				<div class="control-label">
					<label title="" class="hasTooltip">
						<?php echo JText::_('PLG_J2STORE_PRODUCT_SHORT_TAG');?>
					</label>
				</div>
				<div class="controls">
					<strong>
						<pre>{j2storecart <?php echo $vars->product_id; ?>}</pre>
					</strong>
					<br />
					<div class="alert alert-block alert-info">
						<?php echo JText::_('PLG_J2STORE_PRODUCT_SHORT_TAG_HELP'); ?>
					</div>
				</div>
			</div>

			<div class="control-group ">
				<div class="control-label">
					<label title="" class="">
					</label>
				</div>
				<div class="controls">
					<strong>
						<pre>{j2store}<?php echo $vars->product_id; ?>|price{/j2store}</pre>
					</strong>
					<br />
					<div class="alert alert-block alert-info">
						<?php echo JText::_('PLG_J2STORE_PRODUCT_SHORT_TAG_ADVANCED_HELP'); ?>
					</div>
				</div>
			</div>
	</div>
			<?php else: ?>
			<div class="j2store">
	 			<div class="alert alert-info">
	 				<?php echo JText::_('PLG_J2STORE_PRODUCT_ID_DESC'); ?>
	 			</div>
	 		</div>
	 	<?php endif; ?>

	 	<div class="control-group ">
			<div class="control-label">
				<label title="" class="hasTooltip" for="jform_attribs_j2store_enable_cart" id="jform_attribs_j2store_enable_cart-lbl">
					<?php echo JText::_('PLG_J2STORE_ENABLE_CART_LABEL'); ?>
				</label>
			</div>

			<div class="controls">
				<fieldset class="radio btn-group" id="jform_attribs_j2store_enable_cart">
					<input type="radio" <?php if($vars->product->product_enabled ==1) echo $checked = 'checked="checked"'; ?> value="1" name="<?php echo $form_prefix; ?>[product_enabled]" id="jform_attribs_j2store_enable_cart0">
					<label for="jform_attribs_j2store_enable_cart0" class="btn <?php if($vars->product->product_enabled ==1) echo 'active btn-success'; ?>"><?php echo JText::_('JYES');?></label>
					<input type="radio" <?php if($vars->product->product_enabled ==0) echo $checked = 'checked="checked"'; ?> value="0" name="<?php echo $form_prefix; ?>[product_enabled]" id="jform_attribs_j2store_enable_cart1">
					<label for="jform_attribs_j2store_enable_cart1" class="btn <?php if($vars->product->product_enabled ==0) echo 'active btn-danger'; ?>"><?php echo JText::_('JNO')?></label>
				</fieldset>
			</div>
		</div>

			<div class="control-group ">
				<div class="control-label">
					<label title="" class="hasTooltip" for="jform_attribs_item_sku" id="jform_attribs_item_sku-lbl">
						<?php echo JText::_('PLG_J2STORE_ITEM_SKU_LABEL')?>
					</label>
				</div>
				<div class="controls">
					<input type="text" size="30" value="<?php echo $vars->product->item_sku; ?>" id="jform_attribs_item_sku" name="<?php echo $form_prefix; ?>[item_sku]">
				</div>
			</div>

			<div class="control-group ">
				<div class="control-label">
					<label title="" class="hasTooltip" for="jform_attribs_item_price" id="jform_attribs_item_price-lbl">
						<?php echo JText::_('PLG_J2STORE_ITEM_PRICE_LABEL')?>
					</label>
				</div>
				<div class="controls">
					<input type="text" size="30" value="<?php echo $vars->product->item_price; ?>" id="jform_attribs_item_price" name="<?php echo $form_prefix; ?>[item_price]">
				</div>
			</div>


			<div class="control-group ">
				<div class="control-label">
					<label title="" class="hasTooltip" for="jform_attribs_special_price" id="jform_attribs_special_price-lbl">
						<?php echo JText::_('PLG_J2STORE_SPECIAL_PRICE_LABEL')?>
					</label>
				</div>
				<div class="controls">
					<input type="text" size="30" value="<?php echo $vars->product->special_price; ?>" id="jform_attribs_special_price" name="<?php echo $form_prefix; ?>[special_price]">
				</div>
			</div>

	 	<div class="control-group ">
			<div class="control-label">
				<label title="" class="hasTooltip" for="jform_attribs_item_shipping" id="jform_attribs_item_shipping-lbl">
					<?php echo JText::_('PLG_J2STORE_ITEM_ENABLE_SHIPPING_LABEL'); ?>
				</label>
			</div>

			<div class="controls">
				<fieldset class="radio btn-group" id="jform_attribs_item_shipping">
					<input type="radio" <?php if($vars->product->item_shipping ==1) echo 'checked="checked"'; ?> value="1" name="<?php echo $form_prefix; ?>[item_shipping]" id="jform_attribs_j2store_item_shipping0">
					<label for="jform_attribs_j2store_item_shipping0" class="btn <?php if($vars->product->item_shipping ==1) echo 'active btn-success'; ?>"><?php echo JText::_('JYES');?></label>
					<input type="radio" <?php if($vars->product->item_shipping ==0) echo 'checked="checked"'; ?> value="0" name="<?php echo $form_prefix; ?>[item_shipping]" id="jform_attribs_j2store_item_shipping1">
					<label for="jform_attribs_j2store_item_shipping1" class="btn <?php if($vars->product->item_shipping ==0) echo 'active btn-danger'; ?>"><?php echo JText::_('JNO')?></label>
				</fieldset>
			</div>
		</div>

