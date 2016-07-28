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
if(version_compare(J2STORE_VERSION, '3.0.0', 'ge')) :
?>
<?php require( JModuleHelper::getLayoutPath('mod_j2store_detailcart','default_v3'));?>
<?php else:?>
<?php require( JModuleHelper::getLayoutPath('mod_j2store_detailcart','default_v2'));?>
<?php endif;?>
