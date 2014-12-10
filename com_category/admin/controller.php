<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_category
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die;

/**
 * General Controller of Category component
 *
 * @since  0.0.1
 */
class CategoryController extends JControllerLegacy
{
	/**
	 * display task
	 *
	 * @param   boolean  $cachable   if true view the output.
	 * @param   boolean  $urlparams  An array of safeUrl.
	 *
	 * @return void
	 */
	function display($cachable = false, $urlparams = false)
	{
		// Set default view if not set
		$input = JFactory::getApplication()->input;
		$this->input->set('view', $input->getCmd('view', 'Categories'));
		$view   = $this->input->get('view', 'categories');
		$layout = $this->input->get('layout', 'categories');
		$id     = $this->input->getInt('id');

		if ($view == 'category' && $layout == 'edit' && !$this->checkEditId('com_category.edit.category', $id))
		{
			// Somehow the person just went to the form - we don't allow that.
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_category&view=categories', false));

			return false;
		}

		// Call parent behavior
		parent::display($cachable);
	}
}
