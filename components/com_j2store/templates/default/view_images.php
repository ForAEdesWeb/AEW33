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
$image_path = JUri::root();
?>
 <?php if($this->layout_params->get('show_product_main_image', 1)):?>
<div class="j2store-mainimage">
   <?php
      $main_image="";
      if(isset($this->item->main_image) && $this->item->main_image){
      	$main_image = $this->item->main_image;
      }
      ?>
   		<?php echo $this->item->event->J2StoreBeforeDisplayProductImages;?>

	   <?php if($main_image &&  JFile::exists(JPATH_SITE.'/'.$main_image)):?>
	  	 <img id="j2store-item-main-image-<?php echo $this->item->product_id; ?>" class="j2store-item-product-thumbimage" itemprop="image" src="<?php echo $image_path.$main_image;?>" />
	   <?php endif; ?>

   		<?php echo $this->item->event->J2StoreBeforeDisplayProductImages;?>
</div>
   <?php endif;?>


<?php if(isset($this->item->additional_image) && ($this->item->additional_image) && $this->layout_params->get('show_product_additional_image', 1)):?>
	<?php $additional_image= json_decode($this->item->additional_image);?>
	<?php if(isset($additional_image)):?>
		<div class="j2store-product-additional-details">
		   <ul  id="j2store-item-additional-image-<?php echo $this->item->product_id; ?>" class="j2store-item-additionalimages-list">
		      <?php
		         for($i =0; $i < count($additional_image); $i++): ?>
		      <?php if(isset($additional_image[$i]) && $additional_image[$i]):?>
		      <li>
		         <img onmouseover="setMainPreview('addimage-<?php echo $i;?>')" onclick="setMainPreview('addimage-<?php echo $i;?>')" id="addimage-<?php echo $i;?>" class="j2store-item-additionalimage-preview" src="<?php echo (isset($additional_image[$i])) ? $image_path.$additional_image[$i] : $no_preview; ?>"/>
		      </li>
		      <?php endif;?>
		      <?php endfor;?>
		      <?php if(isset($additional_image[0]) && $additional_image[0]):?>
		      <li>
		         <img onmouseover="removeAdditionalImage()" id="main-image-hidden" class="j2store-item-additionalimage-preview" itemprop="image" src="<?php echo $main_image;?>" />
		      </li>
		      <?php endif;?>
		   </ul>
		</div>
	<?php endif;?>
<?php endif;?>

<script type="text/javascript">
var main_image="<?php echo $image_path.$main_image ;?>";
var imageZoom =<?php  echo $this->layout_params->get('show_product_zoom_effects', 1);?>;
(function($){
	if(imageZoom){
		$('#j2store-item-main-image-<?php echo $this->item->product_id; ?>').elevateZoom({
				cursor: "crosshair", zoomWindowFadeIn: 500, zoomWindowFadeOut: 750, zoomWindowWidth:450, zoomWindowHeight:300
		 });
	}
})(j2store.jQuery);

var a;
function setMainPreview(addimagId){
	console.log(imageZoom);
	var src ="";
		a=1;
	(function($){
	src = $("#"+addimagId).attr('src');
	//$("#main-image-hidden").show();
	$("#j2store-item-main-image-<?php echo $this->item->product_id; ?>").attr('src','');
	$("#j2store-item-main-image-<?php echo $this->item->product_id; ?>").attr('src',src);
	if(imageZoom){
		$('#j2store-item-main-image-<?php echo $this->item->product_id; ?>').elevateZoom({
		cursor: "crosshair",
		zoomWindowFadeIn: 500,
		zoomWindowFadeOut: 750,
		zoomWindowWidth:450,
		zoomWindowHeight:300
		 });
	}
	})(j2store.jQuery);
}

function removeAdditionalImage(){

	(function($){
		$("#j2store-item-main-image-<?php echo $this->item->product_id; ?>").attr('src',main_image);
		setMainPreview('j2store-item-main-image-<?php echo $this->item->product_id; ?>');
	})(j2store.jQuery);
}
</script>