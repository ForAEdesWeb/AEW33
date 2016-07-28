<?php
/*------------------------------------------------------------------------
 # mod_j2store_cart - J2Store Cart
# ------------------------------------------------------------------------
# author    Ramesh Elamathi - ThemeParrot http://www.themeparrot.com
# copyright Copyright (C) 2012 ThemeParrot.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
-------------------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die('Restricted access');
require_once(JPATH_ADMINISTRATOR.'/components/com_j2store/library/prices.php');
require_once(JPATH_ADMINISTRATOR.'/components/com_j2store/library/j2item.php');
$cart_link = JRoute::_('index.php?option=com_j2store&view=mycart');
$j2params = JComponentHelper::getParams('com_j2store');
$checkout_url = JRoute::_('index.php?option=com_j2store&view=checkout');
$app = JFactory::getApplication();
$ajax = $app->getUserState('mod_j2storecart.isAjax');
?>
<?php if(!$ajax): ?>
<div
	class="detailJ2StoreCartBlock<?php if($params->get('moduleclass_sfx')) echo ' '.$params->get('moduleclass_sfx'); ?>">
	<div id="detailJ2StoreCart">
		<?php endif; ?>

		<div class="mod_j2store_cart_shipping_cart">
			<?php require( JModuleHelper::getLayoutPath('mod_j2store_detailcart','_cart'));?>
		</div>
		<?php if($params->get('show_estimator',1) &&  count($items['products'])) :?>
		<div class="mod_j2store_cart_shipping">
			<?php require( JModuleHelper::getLayoutPath('mod_j2store_detailcart','_shipping'));?>
		</div>
		<div class="mod_j2store_cart_shipping_calculator">
			<?php require( JModuleHelper::getLayoutPath('mod_j2store_detailcart','_calculator'));?>
		</div>
		<?php endif;?>


		<?php if(!$ajax):?>
	</div>
</div>
<?php else: ?>
<?php $app->setUserState('mod_j2storecart.isAjax', 0); ?>
<?php endif; ?>