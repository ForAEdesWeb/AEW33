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

	// override itemid.
	// reset the itemid incase previously the itemid was assigned from other posts.
	$itemId = modLatestBlogsHelper::_getMenuItemId($post, $params);
	$url 	= EasyBlogRouter::_('index.php?option=com_easyblog&view=entry&id=' . $post->id . $itemId );

	$posterURL	= EasyBlogRouter::_( 'index.php?option=com_easyblog&view=blogger&layout=listings&id=' . $post->author->id . $itemId );
	$posterName	= $post->author->getName();

	$disabled = true;
	if( $params->get( 'enableratings' ) )
	{
	$disabled = false;
	}
?>
<div class="mod-item">

	<?php if( $params->get( 'photo_show') ){ ?>
		<?php if( !empty( $post->source ) ){ ?>
			<?php require( JModuleHelper::getLayoutPath('mod_latestblogs', $post->source . '_item' ) ); ?>
		<?php } else { ?>

			<?php if( $post->getImage() ){ ?>
				<div class="mod-post-image align-<?php echo $params->get( 'alignment' , 'default' );?>">
					<a href="<?php echo $url; ?>"><img src="<?php echo $post->getImage()->getSource('module');?>" /></a>
				</div>
			<?php } else { ?>
				<!-- Legacy for older style -->
				<?php if( $post->media ){ ?>
				<div class="mod-post-image align-<?php echo $params->get( 'alignment' , 'default' );?>">
					<a href="<?php echo $url; ?>"><?php echo $post->media;?></a>
				</div>
				<?php }  ?>
			<?php } ?>
		<?php } ?>
	<?php } ?>
	
	<div class="mod-post-title">
		<a href="<?php echo $url; ?>"><?php echo $post->title;?></a>
	</div>
	
	<!-- Author metadata -->
	<?php require( JModuleHelper::getLayoutPath('mod_latestblogs', 'default_meta' ) ); ?>

	

	

	<?php if( $params->get( 'showintro' , '-1' ) != '-1' ){ ?>
	<div class="mod-post-content clearfix">

		<?php if( $post->protect ){ ?>
			<?php echo  $post->content; ?>
		<?php } else { ?>
			<?php echo $post->summary;?>
		<?php } ?>

		<?php if( $params->get( 'showreadmore' , true ) ){ ?>
		<div class="mod-post-more">
			<a href="<?php echo $url; ?>"><?php echo JText::_('MOD_LATESTBLOGS_READMORE'); ?></a>
		</div>
		<?php } ?>

	</div>
	<?php } ?>

	

</div>
