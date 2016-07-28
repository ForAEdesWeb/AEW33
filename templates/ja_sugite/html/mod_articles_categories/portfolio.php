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
?>
<ul class="categories-list<?php echo $moduleclass_sfx; ?>">

<li <?php if ($_SERVER['PHP_SELF'] == JRoute::_(ContentHelperRoute::getCategoryRoute($params->get('parent', 'root')))) echo ' class="active"';?>>
    <a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($params->get('parent', 'root'))); ?>">
      <?php echo JText::_('TPL_ARTICLES_CATEGORIES_ALL');?>
    </a>
 </li>
 
<?php
require JModuleHelper::getLayoutPath('mod_articles_categories', $params->get('layout', 'portfolio').'_items');
?></ul>
