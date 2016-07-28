<?php
/*------------------------------------------------------------------------
 # mod_j2store_detailcart - J2Store Cart
# ------------------------------------------------------------------------
# author    Ramesh Elamathi - ThemeParrot http://www.themeparrot.com
# copyright Copyright (C) 2012 ThemeParrot.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
-------------------------------------------------------------------------*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

include_once (JPATH_ADMINISTRATOR.'/components/com_j2store/version.php');
if(version_compare(J2STORE_VERSION, '3.0.0', 'ge')) {
	if (!defined('F0F_INCLUDED'))
	{
		include_once JPATH_LIBRARIES . '/f0f/include.php';
	}
	//we are using latest version.
	require_once (JPATH_SITE.'/modules/mod_j2store_detailcart/helperv3.php');
} else {
	require_once (JPATH_SITE.'/modules/mod_j2store_detailcart/helperv2.php');
}
