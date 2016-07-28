<?php
/*------------------------------------------------------------------------
 # mod_j2store_product_advanced
# ------------------------------------------------------------------------
# author    gokila priya - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2014 - 19 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$doc =JFactory::getDocument();
if (version_compare(JVERSION, '3.0', 'ge'))
{
	JHtml::_('jquery.framework');
}
$doc->addScript(JURI::root().'modules/mod_j2store_products/js/owl.carousel.min.js');
$doc->addStylesheet(JURI::root() . 'modules/mod_j2store_products/css/owl.carousel.css');
$doc->addStylesheet(JURI::root() . 'modules/mod_j2store_products/css/owl.theme.css');
$doc->addStylesheet(JURI::root() . 'modules/mod_j2store_products/css/j2store_products.css');
$j2store_path = JPATH_ADMINISTRATOR.'/components/com_j2store/j2store.php';
if(version_compare(J2STORE_VERSION, '3.0.0', 'ge')) {

}else{
if(JFile::exists($j2store_path)) {
	require_once (JPATH_SITE.'/components/com_j2store/helpers/cart.php');
	require_once (JPATH_ADMINISTRATOR.'/components/com_j2store/library/prices.php');
}
}

//assigning module id
$slider_id = 'jowl-slider-'.$module_id;

$no_of_items  = $params->get('no_of_items',5);

$show_pagination  = $params->get('slider_pagination',0);
$show_pagination  = ($show_pagination ) ? 'true' : 'false';

$show_navigation  = $params->get('slider_navigation',1);
$show_navigation = ($show_navigation) ? 'true' : 'false';

$slider_autoplay =  $params->get('slider_autoplay',0);
$slider_autoplay  = ($slider_autoplay) ? 'true' : 'false';
//image position
$image_position = $params->get('image_position', 'top');

if($image_position == 'top') {
	$style = 'clear:both;';
}elseif($image_position == 'left') {
	$style = 'float:left;';
}elseif($image_position == 'right') {
	$style = 'float:right;';
}
$j2params = JComponentHelper::getParams('com_j2store');
?>
<script>

 jQuery(document).ready(function() {
        jQuery("#<?php echo $slider_id;?>").owlCarousel({
            items:<?php echo $no_of_items;?>,
           	autoPlay:<?php echo $slider_autoplay;?>,
			pagination:<?php echo $show_pagination;?>,
			navigation:<?php echo $show_navigation;?>,
			stopOnHover:true,
		    navigationText: [
			"<i class='icon-chevron-left icon-white'></i>",
			"<i class='icon-chevron-right icon-white'></i>"
			],
			 afterInit : function(elem){
				 var that = this;
				 that.owlControls.prependTo(elem);
				 }
          });
 });
</script>

<div class="row-fluid">
	<div class="span12">
		<!-- Enables Product Slider Effects -->
		<?php if($params->get('show_product_slider',1)):?>
			<?php require( JModuleHelper::getLayoutPath('mod_j2store_products','slider_v3'));?>
		<?php else:?>
		<!-- Normal product display -->
			<?php require( JModuleHelper::getLayoutPath('mod_j2store_products','normal_v3'));?>
		<?php endif;?>
	</div>
</div>