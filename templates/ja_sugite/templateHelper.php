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
defined('_JEXEC') or die('Restricted access');

define('JA_GRID_SIZE', '1x1');

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.image.image');

class SugiteHelper {

    public static function loadParamsContents($item, $pdata = 'attribs'){
        $data = $item->$pdata;
        if(is_string($pdata)){
            $data = new JRegistry;
            $data->loadString($item->$pdata);
        }

        if($data instanceof JRegistry){
            return array(
                'size' => $data->get('jcontent_size', JA_GRID_SIZE)
            );
        }

        return array(
            'size' => JA_GRID_SIZE
        );
    }
    public static function loadGridItems(){
        $tplparams = JFactory::getApplication()->getTemplate(true)->params;
        $doc = jFactory::getDocument();
        $doc->addScriptDeclaration('
            var T3JSVars = {
               baseUrl: "'.JUri::base(true).'",
               tplUrl: "'.T3_TEMPLATE_URL.'",
               finishedMsg: "'.addslashes(JText::_('TPL_JSLANG_FINISHEDMSG')).'",
               itemlg : "'.$tplparams->get('itemlg',4).'",
               itemmd : "'.$tplparams->get('itemmd',3).'",
               itemsm : "'.$tplparams->get('itemsm',2).'",
               itemsmx : "'.$tplparams->get('itemsmx',2).'",
               itemxs : "'.$tplparams->get('itemxs',1).'",
               gutter : "'.$tplparams->get('gutter',5).'"
            };
        ');
        return;
    }

    public static function loadModule($name, $style = 'raw')
	{
		jimport('joomla.application.module.helper');
		$module = JModuleHelper::getModule($name);
		$params = array('style' => $style);
		echo JModuleHelper::renderModule($module, $params);
	}

	public static function loadModules($position, $style = 'raw')
	{
		jimport('joomla.application.module.helper');
		$modules = JModuleHelper::getModules($position);
		$params = array('style' => $style);
		foreach ($modules as $module) {
			echo JModuleHelper::renderModule($module, $params);
		}
	}
}