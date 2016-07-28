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

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');
// Load the modal behavior script.
JHtml::_('behavior.modal');
$i = 0;
$asset_id = $vars->asset_id;
$no_preview = JUri::root().'plugins/j2store/extraimages/extraimages/media/nopreview.jpg';
?>

<div class="j2product-additional_images">
	<table class="table table-bordered">
		<tr>
			<td>
				<?php echo JText::_('PLG_J2STORE_EXTRA_IMAGES_IMAGE_PREVIEW')?>
			</td>
			<td>
				<?php echo JText::_('PLG_J2STORE_EXTRAIMAGES_MAIN_IMAGE');?>
			</td>
		</tr>
		<tr>
			<td>
				<img class="j2store-media-preview add-on" width="30" height="25"  src="<?php echo ($vars->main_image) ? JUri::root().$vars->main_image :  $no_preview;?>" id="showImage-jform_main_image"/>
				<?php if($vars->main_image):?>

				<?php endif;?>
				</td>
				<td>
		<div class="input-prepend input-append">

			<div class="media-preview add-on"><span class="hasTipPreview" title=""><i class="icon-eye"></i></span></div>

			<input  onchange="previewImage(this.value,'jform_main_image')" id="jform_main_image" class="input" value="<?php echo $vars->main_image; ?>" type="text" readonly="readonly"  name="jform[attribs][main_image]" />
			<a class="modal btn" rel="{handler: 'iframe', size: {x: 800, y: 500}}" href="index.php?option=com_media&view=images&tmpl=component&asset=<?php echo $asset_id;?>&author=<?php echo JFactory::getUser()->id;?>&fieldid=jform_main_image&folder=" title="<?php echo JText::_('PLG_J2STORE_EXTRAIMAGES_SELECT');?>">
				<?php echo JText::_('PLG_J2STORE_EXTRAIMAGES_SELECT');?>
			 </a>
			 <a class="btn hasTooltip" onclick="removeImage('jform_main_image')"  href="#" title="" data-original-title="<?php echo JText::_('PLG_J2STORE_EXTRAIMAGES_CLEAR');?>">
				<i class="icon-remove"></i>
			 </a>
			 </td>
		 </tr>

		 <tr>
			<td>
				<?php echo JText::_('PLG_J2STORE_EXTRA_IMAGES_IMAGE_PREVIEW')?>
			</td>
			<td>
				<?php echo JText::_('PLG_J2STORE_EXTRAIMAGES_LISTVIEW_THUMBNAIL');?>
			</td>
		</tr>
		<tr>
			<td>
				<img class="j2store-media-preview add-on" width="30" height="25"  src="<?php echo ($vars->listview_thumb) ? JUri::root().$vars->listview_thumb:  $no_preview;?>" id="showImage-jform_listview_thumb"/>
			</td>
			<td>

			<div class="input-prepend input-append">

			<div class="media-preview add-on"><span class="hasTipPreview" title=""><i class="icon-eye"></i></span></div>

			<input  onchange="previewImage(this.value,'jform_listview_thumb')" id="jform_listview_thumb" class="input" value="<?php echo $vars->listview_thumb; ?>" type="text" readonly="readonly"  name="jform[attribs][listview_thumb]" />
			<a class="modal btn" rel="{handler: 'iframe', size: {x: 800, y: 500}}" href="index.php?option=com_media&view=images&tmpl=component&asset=<?php echo $asset_id;?>&author=<?php echo JFactory::getUser()->id;?>&fieldid=jform_listview_thumb&folder=" title="<?php echo JText::_('PLG_J2STORE_EXTRAIMAGES_SELECT');?>">
				<?php echo JText::_('PLG_J2STORE_EXTRAIMAGES_SELECT');?>
			 </a>
			 <a class="btn hasTooltip" onclick="removeImage('jform_listview_thumb')"  href="#" title="" data-original-title="<?php echo JText::_('PLG_J2STORE_EXTRAIMAGES_CLEAR');?>">
				<i class="icon-remove"></i>
			 </a>
			 </td>
		 </tr>
	</table>

	<div id="additionalImages">
		<table class="table table-striped table-bordered">
		<tr>
			<td>
				<?php echo JText::_('PLG_J2STORE_EXTRA_IMAGES_IMAGE_PREVIEW')?>
			</td>
			<td>
				<?php echo JText::_('PLG_J2STORE_ADDITIONAL_IMAGES');?>
			</td>
		</tr>

	<?php for($i =0 ; $i< $vars->no_of_additional_image; $i++ ):?>

	<?php $id = 'jform_additonal_image-'.$i;?>
	</tr>
		<td>
			<?php

			// if(isset($vars->additional_image[$i])) :?>
			<img class="j2store-media-preview" width="30" height="25"  src="<?php echo (isset($vars->additional_image[$i]) && $vars->additional_image[$i] ) ? JUri::root().$vars->additional_image[$i] : $no_preview; ?>" id="showImage-<?php echo $id;?>"/>
			<?php // endif;?>
		</td>
		<td>
		<div class="control-group">
			<div class="input-prepend input-append">
				<div class="media-preview add-on">
					<span class="hasTipPreview" title="">
						<i class="icon-eye"></i>
					</span>
				</div>
				<input onchange="previewImage(this.value,'<?php echo $id;?>')" id="<?php echo $id;?>" class="input" value="<?php echo (isset($vars->additional_image[$i])) ? $vars->additional_image[$i] : "" ;?>" type="text" readonly=""  name="jform[attribs][additional_image][<?php echo $i;?>]" />
				<a class="modal btn" rel="{handler: 'iframe', size: {x: 800, y: 500}}" href="index.php?option=com_media&view=images&tmpl=component&asset=<?php echo $asset_id;?>&author=<?php echo JFactory::getUser()->id;?>&fieldid=<?php echo $id;?>&folder=" title="<?php echo JText::_('PLG_J2STORE_EXTRAIMAGES_SELECT');?>"><?php echo JText::_('PLG_J2STORE_EXTRAIMAGES_SELECT');?></a>
				<a class="btn hasTooltip" onclick="removeImage('<?php echo $id?>')"  href="#" title="" data-original-title="<?php echo JText::_('PLG_J2STORE_EXTRAIMAGES_CLEAR');?>">
			<i class="icon-remove"></i></a>
			</div>
		</div>
	</td>
	</tr>
	<?php endfor;?>

	</table>
	</div>


</div>
<script type="text/javascript">
var no_preview = '<?php echo $no_preview;?>';
	function removeImage(id){
		console.log(("#showImage-"+id));
		jQuery("#"+id).val("");
		jQuery("#showImage-"+id).attr('src',no_preview);
		jQuery('html, body').animate({
			scrollTop: jQuery("#"+id).offset().top
	      });

	}

function previewImage(value,id) {

	value='<?php echo JUri::root();?>'+value;
	console.log(id);
	jQuery("#showImage-"+id).attr('src',value);

}



</script>
