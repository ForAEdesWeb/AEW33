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
<script>
jQuery(document).ready(function($) {
	 jQuery('.radio.btn-group label').addClass('btn')
			    jQuery(".btn-group label:not(.active)").click(function(){
			        var label = jQuery(this);
			        var input = jQuery('#' + label.attr('for'));

			        if (!input.prop('checked')){
		            	label.closest('.btn-group').find("label").removeClass('active btn-primary');
		            	label.addClass('active btn-primary');
			            input.prop('checked', true);
			        }
			    });
			    jQuery(".btn-group input[checked=checked]").each(function(){
					jQuery("label[for=" + jQuery(this).attr('id') + "]").addClass('active btn-primary');

			    });
	});

</script>
<style>


</style>

<div class="row-fluid" id="layout-common">

		         	  <div class="control-group">
                    	<label class="control-label">
							<?php echo $this->form->getLabel('add_to_cartbtn_background_color');?>
                    	</label>
                    	<div class="controls">
							<?php echo $this->form->getInput('add_to_cartbtn_background_color');?>
                    	</div>
                    </div>

               	   <div class="control-group">
                    	<label class="control-label">
							<?php echo $this->form->getLabel('add_to_cartbtn_text_color');?>
                    	</label>
                    	<div class="controls">
							<?php echo $this->form->getInput('add_to_cartbtn_text_color');?>
                    	</div>
                   </div>
                   <div class="control-group">
                   		<label class="control-label">
                   			<?php echo $this->form->getLabel('add_to_cartbtn_class');?>
                   		</label>
                   		<div class="controls">
                   			<?php echo $this->form->getInput('add_to_cartbtn_class');?>
                   		</div>
                   	</div>
                   	  	<div class="control-group">
		         		<label class="control-label">
		         			<?php echo $this->form->getLabel('show_product_price_option_prefix');?>
		         		</label>
		         		<div class="controls">
			     			<?php echo $this->form->getInput('show_product_price_option_prefix');?>
		         		</div>
		         	</div>
		         	<div class="control-group">
		         		<label class="control-label">
		         			<?php echo $this->form->getLabel('show_qtybox_width');?>
		         		</label>
		         		<div class="controls">
			     			<?php echo $this->form->getInput('show_qtybox_width');?>
		         		</div>
		         	</div>
		         	<div class="control-group">
		        	 	<label class="control-label">
		         			<?php echo $this->form->getLabel('qty_plus_icon');?>
		         		</label>
						<div class="controls">
		         			<?php echo $this->form->getInput('qty_plus_icon');?>
		         		</div>
		         	</div>

		         	<div class="control-group">
		        	 	<label class="control-label">
		         			<?php echo $this->form->getLabel('qty_minus_icon');?>
		         		</label>
						<div class="controls">
		         			<?php echo $this->form->getInput('qty_minus_icon');?>
		         		</div>
		         	</div>
	</div>
