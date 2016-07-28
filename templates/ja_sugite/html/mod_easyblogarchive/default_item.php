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
defined('_JEXEC') or die('Restricted access');
?>
<?php
$curDate    	= EasyBlogHelper::getDate( $i . '-' . $m . '-01' );

// Do not show future months or empty months
if( $i < $currentYear || ($i == $currentYear && $m <= $currentMonth && !$params->get( 'showfuture') ) || $params->get( 'showfuture' )  )
{
    if( ( $showEmptyPost ) || (!$showEmptyPost && !empty( $postCounts->$i->$m ) ) )
    {
		$monthSEF	= ( strlen($m) < 2) ? '0' . $m : $m;
?>
<?php
		if ( ! isset( $postCounts->$i->$m ) )
		{
?>
		<div class="mod-month empty-month">
			<i class="fa fa-calendar"></i>
			<?php echo $curDate->toFormat('%B'); ?>
		</div>
<?php
		}
		else
		{
?>
		<div class="mod-month">
			<a href="<?php echo EasyBlogRouter::_('index.php?option=com_easyblog&view=archive&layout=calendar&archiveyear='.$i.'&archivemonth='.$monthSEF.$menuitemid ); ?>" <?php if($defaultYear == $i && $defaultMonth == $m) echo 'style="font-weight:700;"'; ?>>
				<i class="fa fa-calendar"></i>
				<?php echo $curDate->toFormat('%B'); ?>
				<span class="mod-post-count">(<?php echo $postCounts->$i->$m; ?>)</span>
			</a>
		</div>
<?php
		}
	}
}
?>