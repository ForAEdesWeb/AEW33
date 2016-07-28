<?php
/**
 * @package		EasyBlog
 * @copyright	Copyright (C) 2010 Stack Ideas Private Limited. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 *  
 * EasyBlog is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */
 
defined('_JEXEC') or die('Restricted access');
?>
<?php if( $params->get( 'showauthor' ) || $params->get( 'showdate' , true ) || $params->get( 'showcategory' ) || $params->get( 'showcommentcount', 0 ) ||  $params->get('showdate' , true  )) { ?>
<div class="post-author small">
	<?php if( $params->get( 'showauthor' ) ) { ?>
		<?php echo JText::_( 'TPL_MOD_LATESTBLOGS_WRITTEN_BY' ); ?> 
		<a class="mod-post-author" href="<?php echo $post->author->getProfileLink( $itemId ); ?>"><?php echo $post->author->getName();?></a>
	<?php } ?>

	<?php if( $params->get( 'showdate' , true ) ) { ?>
		<span class="mod-post-date">
		<i class="fa fa-clock-o"></i>
		<?php echo JText::_( 'MOD_LATESTBLOGS_WRITTEN_ON' );?> <?php echo $post->date;?>
		</span>
	<?php } ?>
	
	<?php if( $params->get( 'showcategory') ){ ?>
	<span class="mod-post-type">
		<i class="fa fa-folder"></i>
		<a href="<?php echo EasyBlogRouter::_( 'index.php?option=com_easyblog&view=categories&layout=listings&id=' . $post->category_id . $itemId );?>"><?php echo $post->getCategoryName();?></a>
	</span>
	<?php } ?>
	
	<?php if($params->get('showcommentcount', 0)) : ?>
	<span class="post-comments">
		<i class="fa fa-comments"></i>
		<a href="<?php echo $url;?>"> <?php echo JText::_( 'MOD_LATESTBLOGS_COMMENTS' ); ?> <?php echo $post->commentCount;?></a>
	</span>
	<?php endif; ?>

</div>
<?php } ?>