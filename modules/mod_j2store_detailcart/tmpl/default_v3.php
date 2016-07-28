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

$cart_link = JRoute::_('index.php?option=com_j2store&view=mycart');
$j2params = JComponentHelper::getParams('com_j2store');
$checkout_url = JRoute::_('index.php?option=com_j2store&view=checkout');
$app = JFactory::getApplication();
$ajax = $app->getUserState('mod_j2store_mini_cart.isAjax');

$model = F0FModel::getTmpInstance('Carts','J2StoreModel');
$checkout_url = $model->getCheckoutUrl();
$continue_shopping_url = $model->getContinueShoppingUrl();
?>
<?php if(!$ajax): ?>
<div
	class="detailJ2StoreCartBlock<?php if($params->get('moduleclass_sfx')) echo ' '.$params->get('moduleclass_sfx'); ?>">
	<div id="detailJ2StoreCart">
		<?php endif; ?>

		<div class="mod_j2store_cart_shipping_cart">
			<?php require( JModuleHelper::getLayoutPath('mod_j2store_detailcart','v3_cart'));?>
		</div>
		<?php if($params->get('show_estimator',1) &&  count($items)) :?>
		<div class="mod_j2store_cart_shipping_calculator">
			<?php require( JModuleHelper::getLayoutPath('mod_j2store_detailcart','v3_calculator'));?>
		</div>
		<div class="mod_j2store_cart_shipping">
			<?php require( JModuleHelper::getLayoutPath('mod_j2store_detailcart','v3_shipping'));?>
		</div>

		<div class="buttons-right">
				<span class="cart-checkout-button">
					<a class="btn btn-success" href="<?php echo $checkout_url; ?>" ><?php echo JText::_('J2STORE_PROCEED_TO_CHECKOUT'); ?> </a>
				</span>
		</div>
		<?php endif;?>
		<?php if(!$ajax):?>
	</div>
</div>
<?php else: ?>
<?php $app->setUserState('mod_j2store_mini_cart.isAjax', 0); ?>
<?php endif; ?>