<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 */
/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');
require_once (JPATH_ADMINISTRATOR.'/components/com_j2store/version.php');

if(version_compare(J2STORE_VERSION, '3.0.0', 'ge')) {
	//we are using latest version.
	require_once (JPATH_SITE.'/plugins/j2store/shipping_usps/uspsv3.php');	
	
} else {
	require_once (JPATH_SITE.'/plugins/j2store/shipping_usps/uspsv2.php');	
}