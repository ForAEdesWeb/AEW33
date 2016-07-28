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
?>
<!-- Before desc short desc -->
<div class="j2store-before-product-description">
	<?php echo $this->item->event->J2StoreBeforeDisplayProductDescription;?>
</div>

<?php if($this->layout_params->get('show_product_sdesc', 1) && !empty($this->item->short_description)): ?>
<!-- short desc -->
<div itemprop="description" class="j2store-item-short-description">
			<?php echo $this->item->short_description;?>
</div>
<?php endif;?>
<!-- long desc -->
<?php if($this->layout_params->get('show_product_ldesc', 1) && !empty($this->item->long_description)):?>
<div class="j2store-item-long-description" itemprop="description">
			<span class="j2store-product-ldesc"><?php echo $this->item->long_description;?></span>
</div>
<?php endif;?>

<div class="j2store-after-product-description">
	<?php echo $this->item->event->J2StoreAfterDisplayProductDescription;?>
</div>