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
defined('_JEXEC') or die;

if ($grouped) {
	// flat the group list
	foreach ($list as $group_name => $group) {
		foreach ($group as $item) {
			$_list[] = $item;
		}
	}
} else {
	$_list = $list;
}

$catids = $params->get('catid');
if(isset($catids) && $catids['0'] != ''){
	$catid = $catids[0];	
	$jacategoriesModel = JCategories::getInstance('content');
	$jacategory = $jacategoriesModel->get($catid);
}

if(isset($item_heading) || $item_heading=='') $item_heading = 3;
?>

<div class="category-module col-xs-12 <?php echo $moduleclass_sfx; ?>">
	<div class="project-item project-item-more">
		<h3><?php echo JText::_('TPL_RECENT_PROJECTS'); ?></h3>
		<a class="btn btn-border btn-lg" href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($jacategory->id));?>"><span><?php echo JText::_('TPL_VIEW_ALL'); ?></span></a>
	</div>
	<?php foreach ($_list as $item) : ?>
	<div class="project-item">
		<div class="article-img">
			<?php  
			//Get images 
			$images = "";
			if (isset($item->images)) {
				$images = json_decode($item->images);
			}
			$imgexists = (isset($images->image_intro) and !empty($images->image_intro)) || (isset($images->image_fulltext) and !empty($images->image_fulltext));
			
			if ($imgexists) {			
			$images->image_intro = $images->image_intro?$images->image_intro:$images->image_fulltext;
			$images->image_intro_caption = $images->image_intro_caption?$images->image_intro_caption:$images->image_fulltext_caption;
			$images->image_intro_alt = $images->image_intro_alt?$images->image_intro_alt:$images->image_fulltext_alt;
			?>
				<div class="img-intro">
					<img
						<?php if ($images->image_intro_caption):
							echo 'class="caption"'.' title="' .htmlspecialchars($images->image_intro_caption) .'"';
						endif; ?>
						src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>"/>
				</div>
			<?php }else{ ?>
				<img src="<?php echo JURI::root(true);?>/images/joomlart/demo/default.jpg" alt="Default Image"/>
			<?php } ?>
		</div>
		
		<div class="article-content">
		  <h<?php echo $item_heading+1; ?>>
						   	<?php if ($params->get('link_titles') == 1) : ?>
							<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
							<?php echo $item->title; ?>
					        <?php if ($item->displayHits) :?>
								<span class="mod-articles-category-hits">
					            (<?php echo $item->displayHits; ?>)  </span>
					        <?php endif; ?></a>
					        <?php else :?>
					        <?php echo $item->title; ?>
					        	<?php if ($item->displayHits) :?>
								<span class="mod-articles-category-hits">
					            (<?php echo $item->displayHits; ?>)  </span>
					        <?php endif; ?></a>
					            <?php endif; ?>
				        </h<?php echo $item_heading+1; ?>>
	
	
					<?php if ($params->get('show_author')) :?>
						<span class="mod-articles-category-writtenby">
						<?php echo $item->displayAuthorName; ?>
						</span>
					<?php endif;?>
	
					<?php if ($item->displayCategoryTitle) :?>
						<span class="mod-articles-category-category">
						(<?php echo $item->displayCategoryTitle; ?>)
						</span>
					<?php endif; ?>
					<?php if ($item->displayDate) : ?>
						<span class="mod-articles-category-date"><?php echo $item->displayDate; ?></span>
					<?php endif; ?>
					<?php if ($params->get('show_introtext')) :?>
				<p class="mod-articles-category-introtext">
				<?php echo $item->displayIntrotext; ?>
				</p>
			<?php endif; ?>
			
			<?php if ($params->get('show_readmore')) :?>
				<a class="mod-articles-readmore <?php echo $item->active; ?>" href="<?php echo $item->link; ?>"><?php echo JText::_('TPL_VIEW_MORE_INFO'); ?></a>
			<?php endif; ?>

		</div>
	</div>
	<?php endforeach; ?>
</div>