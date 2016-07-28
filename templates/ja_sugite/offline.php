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
$app = JFactory::getApplication();
$theme = JFactory::getApplication()->getTemplate(true)->params->get('theme', '');
//check if t3 plugin is existed
if(!defined('T3')){
	if (JError::$legacy) {
		JError::setErrorHandling(E_ERROR, 'die');
		JError::raiseError(500, JText::_('T3_MISSING_T3_PLUGIN'));
		exit;
	} else {
		throw new Exception(JText::_('T3_MISSING_T3_PLUGIN'), 500);
	}
}

$t3app = T3::getApp($this);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<jdoc:include type="head" />
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/offline.css" type="text/css" />
	<link href='http://fonts.googleapis.com/css?family=Raleway:300,400,800,700,500,900' rel='stylesheet' type='text/css'>
	<?php if($theme && is_file(T3_TEMPLATE_PATH . '/css/themes/' . $theme . '/offline.css')):?>
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/themes/<?php echo $theme ?>/offline.css" type="text/css" />
	<?php endif; ?>
	<?php 
// T3 BASE HEAD
$t3app->addHead();?>
</head>
<body>
	
	<div id="frame" class="outline">
		<div class="offline-page">
			<?php if ($app->getCfg('offline_image') && file_exists($app->getCfg('offline_image'))) : ?>

  		<img src="<?php echo $app->getCfg('offline_image'); ?>" alt="<?php echo htmlspecialchars($app->getCfg('sitename')); ?>" />
  		<?php endif; ?>
			
			<div class="brand">
				<a href="index.php" title="<?php echo htmlspecialchars($app->getCfg('sitename')); ?>"><?php echo htmlspecialchars($app->getCfg('sitename')); ?></a>
			</div>
			
			<jdoc:include type="message" />

			<div class="offline-message">
				<?php if ($app->getCfg('display_offline_message', 1) == 1 && str_replace(' ', '', $app->getCfg('offline_message')) != ''): ?>
					<p>
						<?php echo $app->getCfg('offline_message'); ?>
					</p>
					<?php elseif ($app->getCfg('display_offline_message', 1) == 2 && str_replace(' ', '', JText::_('JOFFLINE_MESSAGE')) != ''): ?>
					<p>
						<?php echo JText::_('JOFFLINE_MESSAGE'); ?>
					</p>
				<?php  endif; ?>
			</div>

			<div class="login-form">
				<form action="<?php echo JRoute::_('index.php', true); ?>" method="post" id="form-login">

				<fieldset class="input">
					<div class="wrap-input">
						<p id="form-login-username">
							<label for="username"><?php echo JText::_('JGLOBAL_USERNAME') ?></label>
							<input name="username" id="username" type="text" class="inputbox" alt="<?php echo JText::_('JGLOBAL_USERNAME') ?>" size="18" placeholder="<?php echo JText::_('JGLOBAL_USERNAME') ?>" />
						</p>
						
						<p id="form-login-password">
							<label for="passwd"><?php echo JText::_('JGLOBAL_PASSWORD') ?></label>
							<input type="password" name="password" class="inputbox" size="18" alt="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" id="passwd" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" />
						</p>

					</div>
					
          
					<p id="form-login-remember">
						<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
						<input type="checkbox" name="remember" class="inputbox" value="yes" alt="<?php echo JText::_('JGLOBAL_REMEMBER_ME') ?>" id="remember" />
						<label for="remember"><?php echo JText::_('JGLOBAL_REMEMBER_ME') ?></label>
						<?php endif; ?>
						<input type="submit" name="Submit" class="button" value="<?php echo JText::_('JLOGIN') ?>" />
					</p>
          
					
					
					<input type="hidden" name="option" value="com_users" />
					<input type="hidden" name="task" value="user.login" />
					<input type="hidden" name="return" value="<?php echo base64_encode(JURI::base()) ?>" />
					<?php echo JHtml::_('form.token'); ?>
				</fieldset>
				</form>
			</div>
			
		</div>
	</div>
</body>
</html>
