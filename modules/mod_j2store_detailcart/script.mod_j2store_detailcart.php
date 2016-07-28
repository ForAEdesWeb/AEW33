<?php
/*------------------------------------------------------------------------
 # mod_j2store_detailcart - J2Store Cart
# ------------------------------------------------------------------------
# author    ThemeParrot - ThemeParrot http://www.ThemeParrot.com
# copyright Copyright (C) 2014 ThemeParrot.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://ThemeParrot.com
# Based on Latest Articles module of Joomla
-------------------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.filesystem.file' );
include_once(JPATH_ADMINISTRATOR.'/components/com_j2store/version.php');
class mod_j2store_detailcartInstallerScript {
	function preflight( $type, $parent ) {
		if(!JComponentHelper::isEnabled('com_j2store')) {
			Jerror::raiseWarning(null, 'J2Store not found. Please install J2Store before installing this plugin');
			return false;
		}
		jimport('joomla.filesystem.file');
		$version_file = JPATH_ADMINISTRATOR.'/components/com_j2store/version.php';
		if (JFile::exists ( $version_file )) {
			require_once($version_file);
			// abort if the current J2Store release is older
			if (version_compare ( J2STORE_VERSION, '2.7.3', 'lt' )) {
				Jerror::raiseWarning ( null, 'You are using an old version of J2Store. Please upgrade to the latest version' );
				return false;
			}
		} else {
			Jerror::raiseWarning ( null, 'J2Store not found or the version file is not found. Make sure that you have installed J2Store before installing this plugin' );
			return false;
		}
	}
}
