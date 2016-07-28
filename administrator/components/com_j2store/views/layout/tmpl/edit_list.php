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
	<div class="span6 layout-general">
		<h3><?php echo JText::_('J2STORE_LAYOUT_SUBGROUP_GENERAL');?></h3>

		<div class="control-group">
          	<label class="control-label"><?php echo $this->form->getLabel('list_no_of_columns'); ?></label>
        	<div class="controls">
            	 <?php  echo $this->form->getInput('list_no_of_columns'); ?>
            </div>
          </div>

	     <div class="control-group">
          	<label class="control-label"><?php echo $this->form->getLabel('show_product_list_title'); ?></label>
        	<div class="controls">
            	 <?php  echo $this->form->getInput('show_product_list_title'); ?>
            </div>
          </div>

           <div class="control-group">
          	<label class="control-label"><?php echo $this->form->getLabel('list_title_linkable'); ?></label>
        	<div class="controls">
            	 <?php  echo $this->form->getInput('list_title_linkable'); ?>
            </div>
          </div>



                   <div class="control-group">
                     <label class="control-label"><?php echo $this->form->getLabel('show_product_list_sdesc'); ?></label>
                     <div class="controls">
                        <?php  echo $this->form->getInput('show_product_list_sdesc'); ?>
                     </div>
                  </div>

                   <div class="control-group">
                     <label class="control-label"><?php echo $this->form->getLabel('show_product_list_ldesc'); ?></label>
                     <div class="controls">
                        <?php  echo $this->form->getInput('show_product_list_ldesc'); ?>
                     </div>
                  </div>

				<div class="control-group">
                     <label class="control-label"><?php echo $this->form->getLabel('show_product_list_filter_selection'); ?></label>
                     <div class="controls">
                        <?php  echo $this->form->getInput('show_product_list_filter_selection'); ?>
                     </div>
                  </div>

                <div class="control-group">
                     <label class="control-label"><?php echo $this->form->getLabel('show_product_list_of_items_count'); ?></label>
                     <div class="controls">
                        <?php  echo $this->form->getInput('show_product_list_of_items_count'); ?>
                     </div>
                  </div>


                  <h3><?php echo JText::_('J2STORE_LAYOUT_SUBGROUP_IMAGES')?></h3>

                     <div class="control-group">
                        <label class="control-label">
                        	<?php echo $this->form->getLabel('show_product_list_thumb_image'); ?>
                        </label>
                        <div class="controls">
                        	<?php  echo $this->form->getInput('show_product_list_thumb_image'); ?>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">
                        	<?php echo $this->form->getLabel('product_list_thumb_image_width'); ?>
                        </label>
                        <div class="controls">
                        <?php  echo $this->form->getInput('product_list_thumb_image_width'); ?>
                        </div>
                     </div>
                       <div class="control-group">
                        <label class="control-label">
                        	<?php echo $this->form->getLabel('product_list_link_thumb_to_product'); ?>
                        </label>
                        <div class="controls">
                        <?php  echo $this->form->getInput('product_list_link_thumb_to_product'); ?>
                        </div>
                     </div>

				</div>
				<div class="span6 layout-filters">
					  <h3><?php echo JText::_('J2STORE_LAYOUT_SUBGROUP_PRICE');?></h3>
                  <div class="control-group">
                     <label class="control-label">
                     	<?php echo $this->form->getLabel('show_product_list_price'); ?>
                     </label>
                     <div class="controls">
                     	<?php  echo $this->form->getInput('show_product_list_price'); ?>
                     </div>
                  </div>
                  <div class="control-group">
                  	<label class="control-label">
                  		<?php echo $this->form->getLabel('show_product_list_special_price');?>
                  	</label>
                  	<div class="controls">
						<?php echo $this->form->getInput('show_product_list_special_price');?>
                  	</div>
                  </div>


				 <div class="control-group">
					 	<label class="control-label">
                  			<?php echo $this->form->getLabel('show_product_list_price_discount_percentage');?>
                  		</label>
                  		<div class="controls">
							<?php echo $this->form->getInput('show_product_list_price_discount_percentage');?>
                  		</div>
					</div>

					<div class="control-group">
						<label class="control-label">
                  			<?php echo $this->form->getLabel('show_product_list_featured');?>
                  		</label>
                  		<div class="controls">
							<?php echo $this->form->getInput('show_product_list_featured');?>
                  		</div>
					</div>

		         <div class="control-group">
                     	<label class="control-label">
                     		<?php echo $this->form->getLabel('product_list_price_alternative_text');?>
                     	</label>
                     	<div class="controls">
							<?php echo $this->form->getInput('product_list_price_alternative_text');?>
                     	</div>
                    </div>

			<h3><?php echo JText::_('J2STORE_LAYOUT_SUBGROUP_CART');?></h3>


                  <div class="control-group">
                     <label class="control-label">
                     	<?php echo $this->form->getLabel('show_product_list_options'); ?>
                     </label>
                     <div class="controls">
                     	<?php  echo $this->form->getInput('show_product_list_options'); ?>
                     </div>
                  </div>

                    <div class="control-group">
                     	<label class="control-label">
                     		<?php echo $this->form->getLabel('product_list_show_add_to_cart');?>
                     	</label>
                     	<div class="controls">
							<?php echo $this->form->getInput('product_list_show_add_to_cart');?>
                     	</div>
                     </div>

					<div class="control-group">
                     	<label class="control-label">
                     		<?php echo $this->form->getLabel('product_list_show_qtybox');?>
                     	</label>
                     	<div class="controls">
							<?php echo $this->form->getInput('product_list_show_qtybox');?>
                     	</div>
                     </div>


              </div>
               <div class="span6">

                    <h3><?php echo JText::_('J2STORE_LAYOUT_SUBGROUP_INVENTORY');?></h3>
                     <div class="control-group">
                     	<label class="control-label">
                     		<?php echo $this->form->getLabel('product_list_show_sku');?>
                     	</label>
                     	<div class="controls">
							<?php echo $this->form->getInput('product_list_show_sku');?>
                     	</div>
                     </div>
					<?php if(J2STORE_PRO == 1): ?>
                     <div class="control-group">
                     	<label class="control-label">
                     		<?php echo $this->form->getLabel('product_list_show_stock');?>
                     	</label>
                     	<div class="controls">
							<?php echo $this->form->getInput('product_list_show_stock');?>
                     	</div>
                     </div>

                     <div class="control-group">
                     	<label class="control-label">
                     		<?php echo $this->form->getLabel('product_list_show_option_stock');?>
                     	</label>
                     	<div class="controls">
							<?php echo $this->form->getInput('product_list_show_option_stock');?>
                     	</div>
                     </div>

                     <div class="control-group">
                     	<label class="control-label">
                     		<?php echo $this->form->getLabel('product_list_instock_alternative_text');?>
                     	</label>
                     	<div class="controls">
							<?php echo $this->form->getInput('product_list_instock_alternative_text');?>
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
                     <h3><?php echo JText::_('J2STORE_LAYOUT_SUBGROUP_FILTERS');?></h3>

                     <div class="control-group">
                     	<label class="control-label">
                     		<?php echo $this->form->getLabel('show_product_list_filter_sort');?>
                     	</label>
                     	<div class="controls">
							<?php echo $this->form->getInput('show_product_list_filter_sort');?>
                     	</div>
                     </div>

                     <div class="control-group">
                     	<label class="control-label">
                     		<?php echo $this->form->getLabel('show_product_list_filter_search');?>
                     	</label>
                     	<div class="controls">
							<?php echo $this->form->getInput('show_product_list_filter_search');?>
                     	</div>
                     </div>

                     <div class="control-group">
                     	<label class="control-label">
                     		<?php echo $this->form->getLabel('product_list_filter_search_width');?>
                     	</label>
                     	<div class="controls">
							<?php echo $this->form->getInput('product_list_filter_search_width');?>
                     	</div>
                     </div>

                      <div class="control-group">
                     	<label class="control-label">
                     		<?php echo $this->form->getLabel('show_product_list_filter_category');?>
                     	</label>
                     	<div class="controls">
							<?php echo $this->form->getInput('show_product_list_filter_category');?>
                     	</div>
                     </div>

                     <div class="control-group">
                     	<label class="control-label">
                     		<?php echo $this->form->getLabel('product_list_filter_selected_categories');?>
                     	</label>
                     	<div class="controls">
							<?php echo $this->form->getInput('product_list_filter_selected_categories');?>
                     	</div>
                     </div>

                      <div class="control-group">
                     	<label class="control-label">
                     		<?php echo $this->form->getLabel('show_product_list_filter_price');?>
                     	</label>
                     	<div class="controls">
							<?php echo $this->form->getInput('show_product_list_filter_price');?>
                     	</div>
                     </div>

                      <div class="control-group">
                     	<label class="control-label">
                     		<?php echo $this->form->getLabel('filter_upper_limit');?>
                     	</label>
                     	<div class="controls">
							<?php echo $this->form->getInput('filter_upper_limit');?>
                     	</div>
                     </div>

                      <div class="control-group">
                     	<label class="control-label">
                     		<?php echo $this->form->getLabel('round_digit');?>
                     	</label>
                     	<div class="controls">
							<?php echo $this->form->getInput('round_digit');?>
                     	</div>
                     </div>

                      <div class="control-group">
                     	<label class="control-label">
                     		<?php echo $this->form->getLabel('show_product_list_filter_tag');?>
                     	</label>
                     	<div class="controls">
							<?php echo $this->form->getInput('show_product_list_filter_tag');?>
                     	</div>
                     </div>



                     <h3><?php echo JText::_('J2STORE_LAYOUT_SUBGROUP_EXTRA');?></h3>

					<div class="control-group">
                     	<label class="control-label">
                     		<?php echo $this->form->getLabel('product_list_qty_alternative_text');?>
                     	</label>
                     	<div class="controls">
							<?php echo $this->form->getInput('product_list_qty_alternative_text');?>
                     	</div>
                     </div>
					<div class="control-group">
                     	<label class="control-label">
                     		<?php echo $this->form->getLabel('product_list_addtocart_alternative_text');?>
                     	</label>
                     	<div class="controls">
							<?php echo $this->form->getInput('product_list_addtocart_alternative_text');?>
                     	</div>
                     </div>

               </div>
</div>