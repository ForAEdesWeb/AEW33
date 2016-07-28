<?php
/**
 * ------------------------------------------------------------------------
 * JA Sugite Template
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - Copyrighted Commercial Software
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites:  http://www.joomlart.com -  http://www.joomlancers.com
 * This file may not be redistributed in whole or significant part.
 * ------------------------------------------------------------------------
 */

defined('JPATH_BASE') or die;

$date_format = isset($displayData['date_format']) ? $displayData['date_format'] : JText::_('DATE_FORMAT_LC3');
?>
	<dd class="published" title="<?php echo JText::sprintf('COM_CONTENT_PUBLISHED_DATE_ON', JHtml::_('date', $displayData['item']->publish_up, $date_format)); ?>">
		<i class="fa fa-calendar"></i>
    <?php echo JHtml::_('date', $displayData['item']->publish_up, $date_format) ?>
	</dd>