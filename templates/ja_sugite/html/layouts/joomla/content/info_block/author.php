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

$author = ($displayData['item']->created_by_alias ? $displayData['item']->created_by_alias : $displayData['item']->author);
$author = '<span itemprop="name">' . $author . '</span>';
?>
			<dd class="createdby" itemprop="author" itemscope itemtype="http://schema.org/Person">
				<i class="fa fa-user"></i>
				<?php if (!empty($displayData['item']->contact_link ) && $displayData['params']->get('link_author') == true) : ?>
					<?php echo JHtml::_('link', $displayData['item']->contact_link, $author, array('itemprop' => 'url')); ?>
				<?php else :?>
					<?php echo $author; ?>
				<?php endif; ?>
			</dd>