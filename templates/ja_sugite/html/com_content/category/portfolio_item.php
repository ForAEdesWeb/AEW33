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

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
if(version_compare(JVERSION, '3.0', 'lt')){
	JHtml::_('behavior.tooltip');
}
JHtml::_('behavior.framework');

// Create a shortcut for params.
$params  = & $this->item->params;
$images  = json_decode($this->item->images);
$canEdit = $this->item->params->get('access-edit');
$info    = $this->item->params->get('info_block_position', 0);
$hasInfo = (($params->get('show_author') && !empty($this->item->author)) or
			($params->get('show_category')) or
			($params->get('show_create_date')) or
			$params->get('show_publish_date') or
			($params->get('show_parent_category')));
$hasCtrl = ($params->get('show_print_icon') ||
			$params->get('show_email_icon') ||
			$canEdit);
$loadParamsContents = SugiteHelper::loadParamsContents($this->item);
$grid_info = explode('x',$loadParamsContents['size']);
$grid = '';
$grid .= $grid_info[0] > 1?' item-w'.$grid_info[0]:'';
$grid .= $grid_info[1] > 1?' item-h'.$grid_info[1]:'';
?>
<div class="item isotope-item <?php echo $grid;?>">

<?php if ($this->item->state == 0) : ?>
<div class="system-unpublished">
	<?php endif; ?>

	<!-- Article -->
	<article>
	<div class="item-image front">
		<?php if (isset($images->image_intro) and !empty($images->image_intro)) : ?>
				<?php $imgfloat = (empty($images->float_intro)) ? $params->get('float_intro') : $images->float_intro; ?>
				<div class="pull-<?php echo htmlspecialchars($imgfloat); ?>">
					<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid)); ?>">
					<img
						<?php if ($images->image_intro_caption):
							echo 'class="caption"' . ' title="' . htmlspecialchars($images->image_intro_caption) . '"';
						endif; ?>
						src="<?php echo htmlspecialchars($images->image_intro); ?>"
						alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>"/>
						</a>
				</div>
			<?php else:  ?> 
		    <div> 
		        <img src="<?php echo JURI::root(true);?>/images/joomlart/demo/default.jpg" alt="Default Image"/> 
				</div>
    	<?php endif; ?> 
	</div>
	
	<div class="item-desc back">
		<?php if ($params->get('show_title')) : ?>
			<header class="article-header clearfix">
				<h2 class="article-title">
					<?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
						<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid)); ?>"> <?php echo $this->escape($this->item->title); ?></a>
					<?php else : ?>
						<?php echo $this->escape($this->item->title); ?>
					<?php endif; ?>
				</h2>
			</header>
		<?php endif; ?>

	
	</div>
		
	</article>
	<!-- //Article -->

	<?php if ($this->item->state == 0) : ?>
</div>
<?php endif; ?>

<?php echo $this->item->event->afterDisplayContent; ?>

</div>