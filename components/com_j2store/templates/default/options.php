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

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
if(isset($this->layout_data->params)){
	$registry = new JRegistry();
	$registry->loadString($this->layout_data->params);
	$this->layoutparams = $registry;
}
$options = (array) $this->attributes;
?>
<?php if ($options) { ?>
<div class="j2store-product-options">
	<?php foreach ($options as $option) { ?>
    <?php if ($option['type'] == 'select'): ?>
     <!-- select -->
     <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
	 	<?php if ($option['required']) : ?>
        <span class="required">*</span>
        <?php endif; ?>
        <span class="j2store-product-item-<?php echo $option['type'];?>-label"><?php echo $option['option_name']; ?>:</span>
        	<select class="j2store-product-select-option input-small" name="product_option[<?php echo $option['product_option_id']; ?>]">
            	<option value=""><?php echo JText::_('J2STORE_ADDTOCART_SELECT'); ?></option>
            		<?php foreach ($option['optionvalue'] as $option_value): ?>
            		<?php $checked = ''; if($option_value['product_optionvalue_default']) $checked = 'selected="selected"'; ?>
	            <option <?php echo $checked; ?> value="<?php echo $option_value['product_optionvalue_id']; ?>"><?php echo $option_value['optionvalue_name']; ?>
	    	        <?php if ($option_value['product_optionvalue_price'] > 0) :?>
	        	    <?php
			            //get the tax
						$tax = $this->taxClass->getProductTax($option_value['product_optionvalue_price'], $this->product->product_id);
			            ?>
						(
							<?php  if($this->layoutparams->get('show_product_price_option_prefix', 1)):?>
			            		<?php echo $option_value['product_optionvalue_prefix']; ?>
			            	<?php endif;?>
				         	<?php  echo J2StoreHelperCart::dispayPriceWithTax($option_value['product_optionvalue_price'], $tax, $this->params->get('price_display_options', 1)); ?>
				        )
	            	<?php endif; ?>
            	</option>
            	<?php endforeach; ?>
          	</select>
        </div>
      <?php endif; ?>
      <?php if ($option['type'] == 'radio') { ?>
	  	<!-- radio -->
    	<div id="option-<?php echo $option['product_option_id']; ?>" class="j2store-product-option-radio option radio control-label">          <?php if ($option['required']) { ?>
          <span class="required">*</span>
	        <?php } ?>
	        <span class="j2store-product-item-<?php echo $option['type'];?>-label"><?php echo $option['option_name']; ?>:</span><br/>
	        <?php foreach ($option['optionvalue'] as $option_value) { ?>
	       	<?php $checked = ''; if($option_value['product_optionvalue_default']) $checked = 'checked="checked"'; ?>
	         <input <?php echo $checked; ?> type="radio" name="product_option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_optionvalue_id']; ?>" id="option-value-<?php echo $option_value['product_optionvalue_id']; ?>" />
		         <label for="option-value-<?php echo $option_value['product_optionvalue_id']; ?>"><?php echo $option_value['optionvalue_name']; ?>
			         <?php if ($option_value['product_optionvalue_price'] > 0) { ?>
			         <?php  //get the tax
							$tax = $this->taxClass->getProductTax($option_value['product_optionvalue_price'], $this->product->product_id);
				        ?>
			         		(
			            	<?php  if($this->layoutparams->get('show_product_price_option_prefix', 1)):?>
			            	<?php echo $option_value['product_optionvalue_prefix']; ?>
			            	<?php endif;?>
				           	<?php  echo J2StoreHelperCart::dispayPriceWithTax($option_value['product_optionvalue_price'], $tax, $this->params->get('price_display_options', 1)); ?>
			            	)
			       <?php } ?>
	      	 	</label>
	      	 	<br />
	          <?php } ?>
        </div>
        <?php } ?>
        <?php if ($option['type'] == 'checkbox') { ?>
        <!-- checkbox-->
	    	<div id="option-<?php echo $option['product_option_id']; ?>" class="j2store-product-checkbox-option  checkbox control-label">
	          <?php if ($option['required']) { ?>
	          <span class="required">*</span>
	          <?php } ?>
	          <span class="j2store-product-item-<?php echo $option['type'];?>-label"><?php echo $option['option_name']; ?>:</span><br/>
	          <?php foreach ($option['optionvalue'] as $option_value) { ?>
	          <input type="checkbox" name="product_option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_optionvalue_id']; ?>" id="option-value-<?php echo $option_value['product_optionvalue_id']; ?>" />
	          <label for="option-value-<?php echo $option_value['product_optionvalue_id']; ?>"><?php echo $option_value['optionvalue_name']; ?>
	            <?php if ($option_value['product_optionvalue_price'] > 0) { ?>
	                <?php
		            //get the tax
					$tax = $this->taxClass->getProductTax($option_value['product_optionvalue_price'], $this->product->product_id);
		            ?>
	            	(	<?php  if($this->layoutparams->get('show_product_price_option_prefix', 1)):?>
	            	<?php echo $option_value['product_optionvalue_prefix']; ?>
	            	<?php endif;?>
	            	<?php  echo J2StoreHelperCart::dispayPriceWithTax($option_value['product_optionvalue_price'], $tax, $this->params->get('price_display_options', 1)); ?>
	            	)
	            	<?php } ?>
	          </label>
	          <br/>
	        <?php } ?>
        	</div>
        <?php } ?>
        <?php if ($option['type'] == 'text') { ?>
	         <!-- text -->
	        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
	          <?php if ($option['required']) { ?>
	          <span class="required">*</span>
	          <?php } ?>
	          <span class="j2store-product-item-<?php echo $option['type'];?>-label"><?php echo $option['option_name']; ?>:</span>
	          <input type="text" name="product_option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['optionvalue']; ?>" />
	        </div>
        <?php } ?>
       <?php if ($option['type'] == 'textarea') { ?>
         <!-- textarea -->
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <span class="j2store-product-item-<?php echo $option['type'];?>label"><?php echo $option['option_name']; ?>:</span>
          <textarea name="product_option[<?php echo $option['product_option_id']; ?>]" cols="40" rows="5"><?php echo $option['optionvalue']; ?></textarea>
        </div>
        <?php } ?>
        <?php if ($option['type'] == 'date') { ?>
          <!-- date -->
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <span class="j2store-product-item-<?php echo $option['type'];?>-label"><?php echo $option['option_name']; ?>:</span>
          <input type="text" name="product_option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['optionvalue']; ?>" class="j2store_date" />
        </div>
        <?php } ?>

        <?php if ($option['type'] == 'datetime') { ?>
         <!-- datetime -->
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <span class="j2store-product-item-<?php echo $option['type'];?>-label"><?php echo $option['option_name']; ?>:</span>
          <input type="text" name="product_option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['optionvalue']; ?>" class="j2store_datetime" />
        </div>
        <?php } ?>

        <?php if ($option['type'] == 'time') { ?>
        <!-- time -->
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <span class="j2store-product-item-<?php echo $option['type'];?>-label"><?php echo $option['option_name']; ?>:</span>
          <input type="text" name="product_option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['optionvalue']; ?>" class="j2store_time" />
        </div>
        <?php } ?>
        <?php } ?>
      </div>
      <?php } ?>