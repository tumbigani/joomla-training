<?php
/**
 * @version     1.0.0
 * @package     com_map
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      gani tumbi <gani@tasolglobal.com> - http://
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Map controller class.
 */
class MapControllerMap extends JControllerForm
{

    function __construct() {
        $this->view_list = 'maps';
        parent::__construct();
    }

}