<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * General Controller of HelloWorld component
 *
 * @since  0.0.1
 */
class HelloWorldController extends JControllerLegacy
{
	/**
	 * display task
	 *
	 * @return void
	 */
	function display($cachable = false, $urlparams = false)
	{
		// Set default view if not set
		$input = JFactory::getApplication()->input;
		$input->set('view', $input->getCmd('view', 'HelloWorlds'));
		$view   = $this->input->get('view', 'helloworlds');
		$layout = $this->input->get('layout', 'helloworlds');
		$id     = $this->input->getInt('id');

		// Check for edit form.
		if ($view == 'helloworld' && $layout == 'edit' && !$this->checkEditId('com_helloworld.edit.helloworld', $id))
		{
			// Somehow the person just went to the form - we don't allow that.
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_helloworld&view=helloworlds', false));

			return false;
		}

		// Call parent behavior
		parent::display($cachable);
	}
}
