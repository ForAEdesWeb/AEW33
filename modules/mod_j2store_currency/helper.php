<?php
/*------------------------------------------------------------------------
# mod_j2store_cart - J2 Store Cart
# ------------------------------------------------------------------------
# author    Sasi varna kumar - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2014 - 19 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/



// no direct access
defined('_JEXEC') or die('Restricted access');

abstract class ModJ2StoreCurrencyHelper
{
	public static function getCurrencies(&$params)
	{

		JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_j2store/models');
		$model = JModelLegacy::getInstance('Currencies', 'J2StoreModel');
		return $model->getCurrencies();
	}

}

