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

   // Check to ensure this file is included in Joomla!
   defined('_JEXEC') or die( 'Restricted access' );
?>
<div class="row-fluid" id="layout-edit">
	         	<div class="span6">
					<h3><?php echo JText::_('J2STORE_LAYOUT_SUBGROUP_GENERAL');?></h3>
		         	<div class="control-group">
						<label class="control-label">
							<?php echo $this->form->getLabel('show_product_title');?>
						</label>
						<div class="controls">
							<?php echo $this->form->getInput('show_product_title');?>
						</div>
		         	</div>

					<div class="control-group">
						<label class="control-label">
							<?php echo $this->form->getLabel('show_product_sdesc');?>
						</label>
						<div class="controls">
							<?php echo $this->form->getInput('show_product_sdesc');?>
						</div>
		         	</div>


					<div class="control-group">
						<label class="control-label">
							<?php echo $this->form->getLabel('show_product_ldesc');?>
						</label>
						<div class="controls">
							<?php echo $this->form->getInput('show_product_ldesc');?>
						</div>
		         	</div>

		         <div class="control-group">
		         		<label class="control-label">
		         			<?php echo $this->form->getLabel('show_product_tags');?>
		         		</label>
		         		<div class="controls">
		         			<?php echo $this->form->getInput('show_product_tags');?>
		         		</div>
		         	</div>

		         	<h3><?php echo JText::_('J2STORE_LAYOUT_SUBGROUP_PRICE');?></h3>

						<div class="control-group">
						<label class="control-label">
							<?php echo $this->form->getLabel('show_product_price');?>
						</label>
						<div class="controls">
							<?php echo $this->form->getInput('show_product_price');?>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<?php echo $this->form->getLabel('show_product_special_price');?>
						</label>
						<div class="controls">
							<?php echo $this->form->getInput('show_product_special_price');?>
						</div>
					</div>

					 <div class="control-group">
					 	<label class="control-label">
                  			<?php echo $this->form->getLabel('show_product_price_discount_percentage');?>
                  		</label>
                  		<div class="controls">
							<?php echo $this->form->getInput('show_product_price_discount_percentage');?>
                  		</div>
					</div>

		         </div>
		         <div class="span6">

		             <h3><?php echo JText::_('J2STORE_LAYOUT_SUBGROUP_CART');?></h3>

		             <div class="control-group">
                     	<label class="control-label">
                     		<?php echo $this->form->getLabel('product_show_qtybox');?>
                     	</label>
                     	<div class="controls">
							<?php echo $this->form->getInput('product_show_qtybox');?>
                     	</div>
                     </div>

					<div class="control-group">
                     	<label class="control-label">
                     		<?php echo $this->form->getLabel('product_qty_alternative_text');?>
                     	</label>
                     	<div class="controls">
							<?php echo $this->form->getInput('product_qty_alternative_text');?>
                     	</div>
                     </div>
					<div class="control-group">
                     	<label class="control-label">
                     		<?php echo $this->form->getLabel('product_addtocart_alternative_text');?>
                     	</label>
                     	<div class="controls">
							<?php echo $this->form->getInput('product_addtocart_alternative_text');?>
                     	</div>
                     </div>

					<div class="control-group">
                     	<label class="control-label">
                     		<?php echo $this->form->getLabel('product_price_alternative_text');?>
                     	</label>
                     	<div class="controls">
							<?php echo $this->form->getInput('product_price_alternative_text');?>
                     	</div>
                    </div>
                </div>

		        <div class="span6">
		        	<h3><?php echo JText::_('J2STORE_LAYOUT_SUBGROUP_INVENTORY')?></h3>

				<div class="control-group">
					<label class="control-label">
						<?php echo $this->form->getLabel('show_product_sku');?>
					</label>
					<div class="controls">
						<?php echo $this->form->getInput('show_product_sku');?>
					</div>
	         	</div>
	         	<?php if(J2STORE_PRO == 1): ?>
				<div class="control-group">
					<label class="control-label">
						<?php echo $this->form->getLabel('show_product_stock');?>
					</label>
					<div class="controls">
						<?php echo $this->form->getInput('show_product_stock');?>
					</div>
	         	</div>

	         	<div class="control-group">
					<label class="control-label">
						<?php echo $this->form->getLabel('show_product_option_stock');?>
					</label>
					<div class="controls">
						<?php echo $this->form->getInput('show_product_option_stock');?>
					</div>
	         	</div>

	         	   <div class="control-group">
                     	<label class="control-label">
                     		<?php echo $this->form->getLabel('product_instock_alternative_text');?>
                     	</label>
                     	<div class="controls">
							<?php echo $this->form->getInput('product_instock_alternative_text');?>
                     	</div>
                     </div>
					<?php else: ?>
					 <div class="control-group">
                     	<label class="control-label">
                     	<?php echo $this->form->getLabel('product_list_show_stock');?>
                     	<br>
                     	<?php echo $this->form->getLabel('product_list_show_option_stock');?>
                     	</label>
                     	<div class="controls">
							<span><?php echo JText::_('J2STORE_PRO_FEATURE'); ?></span>
							<a class="link" href="<?php echo J2STORE_PRO_URL; ?>" ><?php echo JText::_('J2STORE_SUBSCRIBE');?></a>
                     	</div>
                     </div>

					<?php endif; ?>
		         	<h3>
		         		<?php echo JText::_('J2STORE_LAYOUT_SUBGROUP_IMAGES');?>
		         	</h3>


		         	<div class="control-group">
		         		<label class="control-label">
		         			<?php echo $this->form->getLabel('show_product_main_image');?>
		         		</label>
		         		<div class="controls">
		         			<?php echo $this->form->getInput('show_product_main_image');?>
		         		</div>
		         	</div>
		         	<div class="control-group">
		         		<label class="control-label">
		         			<?php echo $this->form->getLabel('show_product_additional_image');?>
		         		</label>
		         		<div class="controls">
		         			<?php echo $this->form->getInput('show_product_additional_image');?>
		         		</div>
		         	</div>
					<div class="control-group">
		         		<label class="control-label">
		         			<?php echo $this->form->getLabel('product_main_image_width');?>
		         		</label>
		         		<div class="controls">
		         			<?php echo $this->form->getInput('product_main_image_width');?>
		         		</div>
		         	</div>
					<div class="control-group">
		         		<label class="control-label">
		         			<?php echo $this->form->getLabel('product_additional_image_width');?>
		         		</label>
		         		<div class="controls">
		         			<?php echo $this->form->getInput('product_additional_image_width');?>
		         		</div>
		         	</div>
					<div class="control-group">
		         		<label class="control-label">
		         			<?php echo $this->form->getLabel('product_additional_image_height');?>
		         		</label>
		         		<div class="controls">
		         			<?php echo $this->form->getInput('product_additional_image_height');?>
		         		</div>
		         	</div>

	         	<div class="control-group">
		         		<label class="control-label">
		         			<?php echo $this->form->getLabel('show_product_zoom_effects');?>
		         		</label>

		         		<div class="controls">
		         			<?php echo $this->form->getInput('show_product_zoom_effects');?>
		         		</div>
		         </div>
	         </div>
  </div>