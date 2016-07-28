<?php
/**
 * ------------------------------------------------------------------------
 * JA Facebook Like Box Module for J25 & J30
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites: http://www.joomlart.com - http://www.joomlancers.com
 * ------------------------------------------------------------------------
 */

// no direct access
defined('_JEXEC') or die('Restricted accessd');
$bgcolor = '';
if($aParams['colorscheme'] == 'dark'){
	$bgcolor = "background-color:#333333";
}
?>
<iframe src="http://www.facebook.com/plugins/likebox.php?<?php echo $sFacebookQuery ?>" scrolling="no" frameborder="0" style="overflow:hidden;width:<?php echo $aParams['width'].'px' ?>;height:<?php echo $aParams['height'].'px' ?>; allowTransparency: true;<?php echo $bgcolor ?>"></iframe>