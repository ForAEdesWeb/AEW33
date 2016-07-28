<?php
/*------------------------------------------------------------------------
 # mod_j2store_products - J2Store
# ------------------------------------------------------------------------
# author    ThemeParrot - ThemeParrot http://www.ThemeParrot.com
# copyright Copyright (C) 2014 ThemeParrot.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://ThemeParrot.com
# Based on Latest Articles module of Joomla
-------------------------------------------------------------------------*/
defined('_JEXEC') or die;
	if(version_compare(J2STORE_VERSION, '3.0.0', 'ge')) :
?>
  <?php require( JModuleHelper::getLayoutPath('mod_j2store_products','default_v3'));?>
<?php else:?>
  <?php require( JModuleHelper::getLayoutPath('mod_j2store_products','default_v2'));?>
  <?php endif;?>