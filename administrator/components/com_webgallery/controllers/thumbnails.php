<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_webgallery
 *
 * @copyright   Copyright (C) 2012 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Generated by AKHelper - http://asikart.com
 */

// no direct access
defined('_JEXEC') or die;


include_once AKPATH_COMPONENT.'/controlleradmin.php' ;

/**
 * Thumbnails list controller class.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_webgallery 
 */
class WebgalleryControllerThumbnails extends AKControllerAdmin
{
    /**
     * The URL view list variable.
     *
     * @var    string 
     */
    protected $view_list = 'thumbnails' ;
    
    /**
     * The URL view item variable.
     *
     * @var    string 
     */
    protected $view_item = 'thumbnail' ;
    
    /**
     * The Component name.
     *
     * @var    string 
     */
    protected $component = 'webgallery';
    
    /**
     * Constructor.
     *
     * @param   array  $config  An optional associative array of configuration settings.
     *
     * @see     JController
     * @since   11.1
     */
    function __construct() {
        
        $this->redirect_tasks = array(
            'save', 'cancel', 'publish', 'unpublish', 'delete'
        );
        
        parent::__construct();
    }
}