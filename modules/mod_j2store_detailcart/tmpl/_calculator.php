<?php
/*------------------------------------------------------------------------
 # com_j2store - J2Store
# ------------------------------------------------------------------------
# author    Ramesh Elamathi - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2012 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<?php if($params->get('show_shipping_country',1)):?>
<h4>
	<?php echo JText::_('J2STORE_CHANGE_LOCATION');?>
</h4>
<div
	id="changeshipping" class="mod_j2store_shipping_content">

	<!-- Country -->
	<p>
		<?php echo JText::_('J2STORE_DETAILCART_CHANGE_COUNTRY'); ?>
		: <strong><span id="country_name" class="text text-success"><?php echo $country_name;?>
		</span> </strong>

		<?php foreach($countries  as $country):?>
		<?php	$arr[] =JHtml::_('select.option', $country->country_id, JText::_($country->country_name) );?>
		<?php endforeach;?>
		<?php
		$attr=array('id'=>'shipping_country_id','class'=>'input-small', 'style'=>'display:none' );
		echo JHtml::_('select.genericlist',$arr,'shipping_country_id',$attr, 'value', 'text',$country_id);
		?>
		<input id="show_country_params" type="hidden"
			name="show_country_params" value="hide" /> <a
			href="javascript:void(0)" id="CountryEdit"
			onclick="showEditingInput('shipping_country_id','show_country_params','country_name','CountryEdit')">
			<span class="detailcart-change"> <strong><?php echo JText::_('J2STORE_DETAILCART_CHANGE');?>
			</strong>
		</span>
		</a>
	</p>

	<?php endif;?>


	<?php if($params->get('show_shipping_zone',1)):?>
	<!-- zone -->
	<p>
		<?php echo JText::_('J2STORE_DETAILCART_CHANGE_STATE_PROVINCE'); ?>
		: <strong><span id="zone_name" class="text text-success"><?php echo $zone_name;?>
		</span> </strong>
		<?php foreach($zones  as $zone):?>
		<?php	$arr[] =JHtml::_('select.option', $zone->zone_id, JText::_($zone->zone_name) );?>
		<?php endforeach;?>
		<?php	$attr1=array('id'=>'shipping_zone_id','class'=>'input-small','style'=>'display:none');
		echo JHtml::_('select.genericlist',$arr,'shipping_zone_id',$attr1, 'value', 'text',$zone_id);
		?>
		<input id="show_zone_params" type="hidden" name="show_zone_params"
			value="hide" /> <a href="javascript:void(0)" class="exBtn"
			id="ZoneEdit"
			onclick="showEditingInput('shipping_zone_id','show_zone_params','zone_name','ZoneEdit')">
			<span class="detailcart-change"> <strong><?php echo JText::_('J2STORE_DETAILCART_CHANGE');?>
			</strong>
		</span>
		</a>
	</p>
	<?php endif;?>

	<?php if($params->get('show_shipping_postcode',1)):?>
	<!-- Postal code -->
	<p>
		<?php echo JText::_('J2STORE_POSTCODE'); ?>
		: <strong><span id="postcode" class="text text-success"><?php echo $postcode;?>
		</span> </strong>
		<input type="text" class="input-mini"
			id="shipping_postal_code" name="postcode"
			value="<?php echo $postcode; ?>" style="display: none" /> <input
			id="show_postcode_params" type="hidden" name="show_postcode_params"
			value="hide" /> <a href="javascript:void(0)" class="exBtn"
			id="PostCodeEdit"
			onclick="showEditingInput('shipping_postal_code','show_postcode_params','postcode','PostCodeEdit');">
			<span class="detailcart-change"> <strong><?php echo JText::_('J2STORE_DETAILCART_CHANGE');?>
			</strong>
		</span>
		</a>
	</p>
	<?php endif; ?>

	<input class="btn btn-primary" type="button" id="estimateShip"
		onclick="shippingRateEstimate()"
		value="<?php echo JText::_('J2STORE_CART_CALCULATE_TAX_SHIPPING'); ?>"
		id="button-quote" class="btn btn-primary" />
</div>

<script type="text/javascript">
      if(typeof(j2store) == 'undefined') {
  		var j2store = {};
  	}
  	if(typeof(j2store.jQuery) == 'undefined') {
  		j2store.jQuery = jQuery.noConflict();
  	}

  	if(typeof(j2storeURL) == 'undefined') {
  		var j2storeURL = '';
  	}

   /**
     * Method to Edit the Selected Country id ,Zone id, postcode
     * to get  Shipping Method
     * @params select input id in string,hidden input id in string ,
     * @display the selected value,
     * @option to show the edit option change or cancel
     *
     */
   showEditingInput= function (select_input,hidden_input,text,option){
   	(function($){
   		var param = $("#"+hidden_input).val();
   		if(param=="hide"){

   			//id for  list of country,zone  in select input or text input for
   			$("#"+select_input).hide();

   			$("#"+text).show();

   			$("#"+hidden_input).attr("value","show");

   			$("#"+option).html('<strong>Change</strong>');

   		}else if(param=="show"){

   			$("#"+hidden_input).attr("value","hide");

   			$("#"+text).hide();

   			$("#"+select_input).show();

   			$("#"+option).html('<strong>Cancel</strong>');

   			// when there is change in the  country
   			// need to change the state & postcode
   			// here zone select input & postcode will be enabled to edit
   			if(select_input=='shipping_country_id'){

   				$("#shipping_zone_id").show();

   				$("#zone_name").hide();

   				$("#postcode").hide();

   				$("#ZoneEdit").html('<strong>Cancel</strong>');

   				$("#PostCodeEdit").html('<strong>Cancel</strong>');

   				$("#shipping_postal_code").show();
   			}

   			if(select_input=='shipping_zone_id'){

   				$("#postcode").hide();

   				$("#shipping_postal_code").show();
   			}
   		}
   		})(j2store.jQuery);
   	}

</script>

<script type="text/javascript"><!--
   (function($) {
   $('select[id=\'shipping_country_id\']').bind('change', function() {

   	$.ajax({
   		url:'index.php?option=com_j2store&view=checkout&task=getCountry&country_id=' + this.value,
   		dataType: 'json',
   		beforeSend: function() {
   			$('select[id=\'shipping_country_id\']').after('<span class="wait">&nbsp;<img src="<?php echo JUri::root(true); ?>/media/j2store/images/loader.gif" alt="" /></span>');
   		},
   		complete: function() {
   			$('.wait').remove();
   		},
   		success: function(json) {

   			html = '<option value=""><?php echo JText::_('J2STORE_SELECT_ZONE'); ?></option>';

   			if (json['zone'] != '') {
   				for (i = 0; i < json['zone'].length; i++) {
           			html += '<option value="' + json['zone'][i]['zone_id'] + '"';

   					if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
   	      				html += ' selected="selected"';
   	    			}

   	    			html += '>' + json['zone'][i]['zone_name'] + '</option>';
   				}
   			} else {
   				html += '<option value="0" selected="selected"><?php echo JText::_('J2STORE_CHECKOUT_ZONE_NONE'); ?></option>';
   			}

   			$('select[id=\'shipping_zone_id\']').html(html);
   		},
   		error: function(xhr, ajaxOptions, thrownError) {
   			//alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
   		}
   	});
   });

   $('select[id=\'shipping_country_id\']').trigger('change');

   })(j2store.jQuery);

   shippingRateEstimate=function(){
   	(function($){
   		var country_id = $("#shipping_country_id").val();
   		var zone_id = $("#shipping_zone_id").val();
   		var postal_code = $("#shipping_postal_code").val();
   	$.ajax({
   		url:"index.php?option=com_j2store&view=mycart&task=estimate",
   		type:'post',
   		dataType: 'json',
   		data : {'country_id': country_id,'zone_id':zone_id,'postcode':postal_code},
   		beforeSend: function() {
   			$('select[id=\'shipping_country_id\']').after('<span class="wait">&nbsp;<img src="<?php echo JUri::root(true); ?>/media/j2store/images/loader.gif" alt="" /></span>');
   		},
   		complete: function() {
   			$('.wait').remove();
   			$("#estimateShip").hide();
   			$("#shipping_country_id").hide();
   			$("#shipping_zone_id").hide();
   		},
		success: function(json) {
			var estimate = 1;
			request = {
					'option' : 'com_ajax',
					'module' : 'j2store_detailcart',
					'method' : 'getEstimatedshipping',
					'format' : 'json',
					}
			$.ajax({
				type : 'POST',
				data : request,
				dataType:'json',
				success: function (json) {
				if(json['error']){
						$('.mod-j2storedetailcart-status').html('<p class="j2store-mdc-error text text-warning">'+json['error']['msg']+'</p>');
						$("#estimateShip").show();

					}else if(json['success']){

						$.ajax({
			   				url:"index.php?option=com_j2store&view=mycart&task=shippingUpdate"
			   			});
						$.ajax({
			   				url:"index.php?option=com_j2store&view=mycart&task=displayCart",
			   				type: 'post',
			   			 	cache: false,
			 				success: function(response){
			 					$('#detailJ2StoreCart').html(response);
			 				}
			   			});
						$("#estimateShip").show();
					}
				  }
				});
		},
		error: function(xhr, ajaxOptions, thrownError) {
			//alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}

   	});

   	})(j2store.jQuery);
   }
   //--></script>
