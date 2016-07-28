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

// get params
$sitename  = $this->params->get('sitename');
$slogan    = $this->params->get('slogan', '');
$logotype  = $this->params->get('logotype', 'text');
$logoimage = $logotype == 'image' ? $this->params->get('logoimage', 'templates/' . T3_TEMPLATE . '/images/logo.png') : '';
$logoimgsm = ($logotype == 'image' && $this->params->get('enable_logoimage_sm', 0)) ? $this->params->get('logoimage_sm', '') : false;

if (!$sitename) {
	$sitename = JFactory::getConfig()->get('sitename');
}

$logosize = 'col-sm-6 col-md-3';
if ($headright = $this->countModules('head-search or languageswitcherload') || ($this->getParam('navigation_collapse_enable', 1) && $this->getParam('responsive', 1)) || $this->getParam('addon_offcanvas_enable') ) {
	$logosize = 'col-sm-6 col-md-3';
}

?>

<!-- HEADER -->
<header id="t3-header" class="wrap t3-header">
	<div class="container">
		<div class="row">
	
			<!-- LOGO -->
			<div class="col-xs-8 <?php echo $logosize ?> logo">
				<div class="logo-<?php echo $logotype, ($logoimgsm ? ' logo-control' : '') ?>">
					<a href="<?php echo JURI::base(true) ?>" title="<?php echo strip_tags($sitename) ?>">
						<?php if($logotype == 'image'): ?>
							<img class="logo-img" src="<?php echo JURI::base(true) . '/' . $logoimage ?>" alt="<?php echo strip_tags($sitename) ?>" />
						<?php endif ?>
						<?php if($logoimgsm) : ?>
							<img class="logo-img-sm" src="<?php echo JURI::base(true) . '/' . $logoimgsm ?>" alt="<?php echo strip_tags($sitename) ?>" />
						<?php endif ?>
						<span><?php echo $sitename ?></span>
					</a>
					<small class="site-slogan"><?php echo $slogan ?></small>
				</div>
			</div>
			<!-- //LOGO -->
			
			<?php if ($headright): ?>
				<div class="head-right">
					<?php if ($this->countModules('head-search')) : ?>
						<!-- HEAD SEARCH -->
						<div class="head-search <?php $this->_c('head-search') ?>">
							<div class="dropdown">
							  <button class="btn btn-primary dropdown-toggle sr-only" type="button" id="head-search" data-toggle="dropdown">
							    <i class="fa fa-search"></i>
							  </button>
							  <div class="dropdown-menu" role="menu" aria-labelledby="head-search">
							    <jdoc:include type="modules" name="<?php $this->_p('head-search') ?>" style="raw" />
							  </div>
							</div>
						</div>
						<!-- //HEAD SEARCH -->
					<?php endif ?>
	
					<?php if ($this->countModules('languageswitcherload')) : ?>
						<!-- LANGUAGE SWITCHER -->
						<div class="languageswitcherload">
							<jdoc:include type="modules" name="<?php $this->_p('languageswitcherload') ?>" style="raw" />
						</div>
						<!-- //LANGUAGE SWITCHER -->
					<?php endif ?>
					
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
					
						<?php if ($this->getParam('navigation_collapse_enable', 1) && $this->getParam('responsive', 1)) : ?>
							<?php $this->addScript(T3_URL.'/js/nav-collapse.js'); ?>
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".t3-navbar-collapse">
								<i class="fa fa-bars"></i>
							</button>
						<?php endif ?>
			
						<?php if ($this->getParam('addon_offcanvas_enable')) : ?>
							<?php $this->loadBlock ('off-canvas') ?>
						<?php endif ?>
			
					</div>
				</div>
			<?php endif ?>

			<!-- MAIN NAVIGATION -->
			<nav id="t3-mainnav" class="col-sm-6 col-md-9 pull-right navbar navbar-default t3-mainnav">
			
					<?php if ($this->getParam('navigation_collapse_enable')) : ?>
						<div class="t3-navbar-collapse navbar-collapse collapse"></div>
					<?php endif ?>
			
					<div class="t3-navbar navbar-collapse collapse">
						<jdoc:include type="<?php echo $this->getParam('navigation_type', 'megamenu') ?>" name="<?php echo $this->getParam('mm_type', 'mainmenu') ?>" />
					</div>
			
			</nav>
			<!-- //MAIN NAVIGATION -->

	
		</div>
	</div>
</header>
<!-- //HEADER -->
