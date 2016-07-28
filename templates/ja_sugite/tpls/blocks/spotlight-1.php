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

<?php if ($this->checkSpotlight('spotlight-1', 'position-1, position-2')) : ?>
	<!-- SPOTLIGHT 1 -->
	<div class="t3-sl t3-sl-1 row-feature">
		<div class="container ">
			<?php $this->spotlight('spotlight-1', 'position-1, position-2') ?>
		</div>
	</div>
	<!-- //SPOTLIGHT 1 -->
<?php endif ?>