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

$title = $this->escape($displayData['item']->category_title);
if(!isset($displayData['item']->catslug)){
	$ditem = $displayData['item'];
	$displayData['item']->catslug = ($ditem->category_alias) ? ($ditem->catid . ':' . $ditem->category_alias) : $ditem->catid;
}

$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($displayData['item']->catslug)).'">'.$title.'</a>';
?>
			<dd class="category-name" title="<?php echo JText::sprintf('COM_CONTENT_CATEGORY', $title) ?>">
				<i class="fa fa-folder"></i>
				<?php if ($displayData['params']->get('link_category') && $displayData['item']->catslug) : ?>
					<?php echo $url ?>
				<?php else : ?>
					<?php echo $title ?>
				<?php endif; ?>
			</dd>