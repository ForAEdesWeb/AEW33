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

$showEmptyYear = $params->get( 'showemptyyear', false);

?>
<script type="text/javascript">
EasyBlog.ready(function($) {

	// @task: Add active item on the first / latest year.
	$( '.blog-module-archive > div:first' ).addClass( 'active-year' );

	$( '.blog-module-archive .mod-year a' ).bind( 'click' , function(){

		$( this ).parent().toggleClass( 'toggle' );

		$( this ).parents( '.archive-year-wrapper' ).find( '.mod-months' ).toggle();

		return false;
	});

});
</script>
<div class="ezb-mod blog-module-archive mod_easyblogarchive<?php echo $params->get( 'moduleclass_sfx' ) ?>">
	<?php if( !empty( $year) ){ ?>
		<?php for($i = $year['maxyear']; $i >= $year['minyear']; $i--){ ?>
			<?php if( !$showEmptyYear && empty( $postCounts->$i ) ){ ?>
				<?php continue; ?>
			<?php } ?>
		<div class="archive-year-wrapper">
			<div class="mod-year<?php echo ( $params->get('collapse', false) ) ? ' toggle' : '' ?>" >
				<a href="javascript:void(0);" class="archive-title" id="<?php echo $i; ?>">
					<i></i><?php echo $i; ?>
				</a>
			</div>
			<div class="mod-months"<?php echo ( $params->get('collapse', false) ) ? ' style="display:none;"' : '' ?> >
			<?php
				if( $params->get('order') == 'asc' )
				{
					for($m = 1; $m < 13; $m++)
					{
						require( JModuleHelper::getLayoutPath('mod_easyblogarchive', 'default_item') );
					}
				}
				else
				{
					for($m = 12; $m > 0; $m--)
					{
						require( JModuleHelper::getLayoutPath('mod_easyblogarchive', 'default_item') );
					}
				}
			?>
			</div>
		</div>
		<?php } ?>
	<?php } else { ?>
		<div class="mod-item-nothing">
			<?php echo JText::_('MOD_EASYBLOGARCHIVE_NO_POST'); ?>
		</div>
	<?php } ?>
</div>

