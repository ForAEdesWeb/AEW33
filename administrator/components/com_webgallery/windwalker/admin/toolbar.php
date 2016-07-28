<?php
/**
 * @package     Windwalker.Framework
 * @subpackage  Admin
 *
 * @copyright   Copyright (C) 2012 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Generated by AKHelper - http://asikart.com
 */

// no direct access
defined('_JEXEC') or die;

include_once JPATH_ADMINISTRATOR.'/includes/toolbar.php' ;

/**
 * A Toolbar helper extends from JToolbarHelper.
 *
 * @package     Windwalker.Framework
 * @subpackage  Admin 
 */
class AKToolBarHelper
{
	/**
	 * Set admin toolbar title and auto add page title to HTML head document.
	 */
    static function title ($title, $icon = 'generic.png')
    {
        $doc = JFactory::getDocument();
        $app = JFactory::getApplication();
        
        $doc->setTitle($title) ;
        
        $view     	= JRequest::getVar('view') ;
        $layout 	= JRequest::getVar('layout', 'default') ;
        $option 	= JRequest::getVar('option') ;
        
        // Strip the extension.
        $icons = explode(' ', $icon);
        foreach($icons as &$icon) {
            $icon = 'icon-48-'.preg_replace('#\.[^.]*$#', '', $icon);
        }
        
        $class	= "header-{$view}-{$layout}" ;
        $img    = "components/{$option}/images/admin-icons/{$class}.png" ;
        
        if(JFile::exists(JPATH_ADMINISTRATOR.'/'.$img)) {
            $icon = $class ;
        }
        
        if(JVERSION >= 3) $icon = null ;
        
        $admin	= $app->isSite() ? JURI::root().'administrator/' : '' ;
        $img    = $admin."components/{$option}/images/admin-icons/{$class}.png" ;
        
        $doc->addStyleDeclaration("
.{$class} {
    background: url({$img}) no-repeat;
}
        ");
        
        $html = '<div class="pagetitle '.htmlspecialchars($icon).'"><h2>'.$title.'</h2></div>';        
        //$html = $title ;
        
        $app->JComponentTitle = $html ;
        
    }
    
    /**
	 * Set a link button.
	 */
    public static function link($alt , $href = '#', $icon = 'asterisk')
    {
        $bar = JToolbar::getInstance('toolbar');
 
        // Add a back button.
        $bar->appendButton('Link', $icon, $alt, $href);
    }
    
    /**
	 * Set a back link button, contain right arrow icon.
	 */
    public static function back($alt = 'JTOOLBAR_BACK', $href = 'javascript:history.back();')
    {
        $bar 	= JToolbar::getInstance('toolbar');
		$icon 	= JVERSION >= 3 ? 'chevron-left' : 'back' ;
		
        // Add a back button.
        $bar->appendButton('Link', $icon, $alt, $href);
    }
    
    /**
	 * Set a modal button.
	 */
    public static function modal($title  = 'JTOOLBAR_BATCH' , $selector = 'myModal' , $icon = 'checkbox-partial')
    {
        AKHelper::_('ui.modal', $selector) ;
        $bar	= JToolbar::getInstance('toolbar');
        $title  = JText::_($title);
        
        $option = array(
            'class' => 'btn btn-small '.$selector.'-link' ,
            'icon'	=> JVERSION >= 3 ? 'icon-'.$icon : $icon
        );
        
        $dhtml	= AKHelper::_('ui.modalLink', $title, $selector, $option) ;
        $bar->appendButton('Custom', $dhtml, 'batch');    
    }
    
    
    /**
     * Writes a configuration button and invokes a cancel operation (eg a checkin).
     *
     * @param   string  $component  The name of the component, eg, com_content.
     * @param   int     $height     The height of the popup. [UNUSED]
     * @param   int     $width      The width of the popup. [UNUSED]
     * @param   string  $alt        The name of the button.
     * @param   string  $path       An alternative path for the configuation xml relative to JPATH_SITE.
     *
     * @return  void
     */
    public static function preferences($component, $height = '550', $width = '875', $alt = 'JToolbar_Options', $path = '')
    {
        $app 	= JFactory::getApplication() ;
        $args 	= func_get_args();
        
        $app->triggerEvent('onAKToolbarAppendButton', array('preferences', &$args) ) ;
        call_user_func_array( array('JToolBarHelper', 'preferences'), $args );
    }
    
    
    /**
	 * If alled method not exists in this class, will auto call JToolbarHelper instead.
	 */
    public static function __callStatic($name, $args)
    {
        $app = JFactory::getApplication() ;
        
        $app->triggerEvent('onAKToolbarAppendButton', array($name, &$args) ) ;
        call_user_func_array( array('JToolBarHelper', $name), $args );
    }
}