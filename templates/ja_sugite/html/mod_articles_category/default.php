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

$moduleIntro = $params->get ('module-intro');
?>

<?php if($moduleIntro) : ?>
	<p class="module-intro"><?php echo $moduleIntro; ?></p>
<?php endif; ?>

<ul class="category-module<?php echo $moduleclass_sfx; ?>">
<?php if ($grouped) : ?>
	<?php foreach ($list as $group_name => $group) : ?>
	<li>
		<h<?php echo $item_heading; ?>><?php echo $group_name; ?></h<?php echo $item_heading; ?>>
		<ul>
			<?php foreach ($group as $item) : ?>
				<li>
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
			<p class="mod-articles-category-readmore">
				<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
				<?php if ($item->params->get('access-view')== FALSE) :
						echo JText::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE');
					elseif ($readmore = $item->alternative_readmore) :
						echo $readmore;
						echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit'));
						if ($params->get('show_readmore_title', 0) != 0) :
							echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
						endif;
					elseif ($params->get('show_readmore_title', 0) == 0) :
						echo JText::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE');
					else :

						echo JText::_('MOD_ARTICLES_CATEGORY_READ_MORE');
						echo JHtml::_('string.truncate', ($item->title), $params->get('readmore_limit'));
					endif; ?>
	        </a>
			</p>
			<?php endif; ?>
		</li>
			<?php endforeach; ?>
		</ul>
	</li>
	<?php endforeach; ?>
<?php else : ?>
	<?php foreach ($list as $item) : ?>
	    <li>
	   	<h<?php echo $item_heading; ?>>
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
        </h<?php echo $item_heading; ?>>

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
			<p class="mod-articles-category-readmore">
				<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
		        <?php if ($item->params->get('access-view')== FALSE) :
						echo JText::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE');
					elseif ($readmore = $item->alternative_readmore) :
						echo $readmore;
						echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit'));
					elseif ($params->get('show_readmore_title', 0) == 0) :
						echo JText::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE');
					else :
						echo JText::_('MOD_ARTICLES_CATEGORY_READ_MORE');
						echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit'));
					endif; ?>
	        </a>
			</p>
		<?php endif; ?>
	</li>
	<?php endforeach; ?>
<?php endif; ?>
</ul>
