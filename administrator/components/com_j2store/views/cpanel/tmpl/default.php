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
defined('_JEXEC') or die('Restricted access');
?>
<?php if(version_compare(phpversion(), '5.3.0', 'lt')):?>
<div class="alert alert-block alert-danger">
<?php echo JText::_('J2STORE_PHP_OUTDATED_VERSION'); ?>
</div>
<?php endif; ?>

<?php if($this->params->get('show_addtocart', 0)): ?>
<div class="alert alert-block alert-info">
<strong><?php echo JText::_('J2STORE_CATALOG_MODE_ENABLED_ALERT');?></strong>
</div>
<?php endif;?>
 <div class="j2store span9">
<div id="cpanel" class="j2storeAdminCpanel row-fluid">
		<div class="row-fluid">
			<div class="span12">
			<?php  echo J2StoreHelperModules::loadposition('j2store-module-position-1');?>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<div id="j2storeQuickIcons">
					<?php //echo J2StoreHelperModules::loadposition('j2store-module-position-2');?>
				 </div>
				 <div class="row-fluid">
				 	<div class="span12">
				 		<div class="row-fluid">
				 			<!-- Chart-->
							<div class="span12 chart">
								<?php echo J2StoreHelperModules::loadposition('j2store-module-position-3');?>
							</div>
						</div>
						<div class="row-fluid">
				 		   <!-- Statistics-->
							<div class="span6 statistics">
								<?php echo J2StoreHelperModules::loadposition('j2store-module-position-5');?>
							</div>
							<!-- Latest orders -->
							<div class="span6 latest_orders">
							<?php echo J2StoreHelperModules::loadposition('j2store-module-position-4');?>
							</div>

						</div>
				</div>
			</div>
			</div>
			<div class="span4"><?php  //echo $this->loadTemplate('update'); ?> </div>
		</div>
</div>



</div>
<?php if(version_compare(JVERSION, '3.0', 'lt')):?>
</div>
</div>
<?php endif; ?>

<div class="clr"></div>