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
?>

<?php if ($this->countModules('features-intro')) : ?>
<!-- Features Intro -->
<div class="features-intro <?php $this->_c('features-intro') ?>">
	<jdoc:include type="modules" name="<?php $this->_p('features-intro') ?>" style="FeatureRow" />
</div>
<!-- //Features Intro -->
<?php endif ?>

