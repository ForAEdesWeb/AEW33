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

// no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<div class="mod-item">
	<div<?php echo ( $params->get( 'layouttype' ) == 'tree' ) ? ' style="padding-left: ' . $padding . 'px;"' : '';?>>
 	<?php if ($params->get('showcavatar', true)) : ?>
		<a href="<?php echo EasyBlogRouter::_('index.php?option=com_easyblog&view=categories&layout=listings&id='.$category->id . $menuItemId );?>" class="mod-avatar">
			<img class="avatar" src="<?php echo modEasyBlogCategoriesHelper::getAvatar($category); ?>" width="40" alt="<?php echo $category->title; ?>" />
		</a>
	<?php endif; ?>
 		<div class="mod-category-detail">
			<div class="mod-category-name">
				<i class="fa fa-file-o"></i> 
				<a href="<?php echo EasyBlogRouter::_('index.php?option=com_easyblog&view=categories&layout=listings&id='.$category->id . $menuItemId );?>"><?php echo JText::_( $category->title ); ?></a>
				<?php if( $params->get( 'showcount' , true ) ){ ?>
				<?php echo JText::sprintf('(' . $category->cnt) . ')';?>
				<?php } ?>
			</div>
		 </div>
	</div>
</div>