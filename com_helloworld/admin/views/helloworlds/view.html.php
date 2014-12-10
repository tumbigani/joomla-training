<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Import Joomla view library
jimport('joomla.application.component.view');

/**
 * HelloWorlds View
 *
 * @since  0.0.1
 */
class HelloWorldViewHelloWorlds extends JViewLegacy
{
	/**
	 * HelloWorlds view display method
	 *
	 * @param   string  $tpl  default templete
	 *
	 * @return void
	 */
	function display($tpl = null)
	{
		// Get data from the model
		$items               = $this->get('Items');
		$pagination          = $this->get('Pagination');

		$this->state         = $this->get('State');
		$this->assoc         = $this->get('Assoc');
		$this->activeFilters = $this->get('ActiveFilters');
		$this->filterForm    = $this->get('FilterForm');
		$user		= JFactory::getUser();
		$userId		= $user->get('id');


		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));

			return false;
		}

		// Assign data to the view
		$this->items = $items;
		$this->pagination = $pagination;

		// Set the toolbar and number of found items
		$this->addToolBar($this->pagination->total);

		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	/**
	 * add toolbar function
	 *
	 * @param   total  $total  string
	 *
	 * @return void
	 */
	protected function addToolBar($total=null)
	{
		$canDo = JHelperContent::getActions('com_helloworld', 'helloworld', $this->state->get('filter.category_id'));
		JToolBarHelper::title(JText::_('COM_HELLOWORLD_MANAGER_HELLOWORLDS').
				//Reflect number of items in title!
				($total?' <span style="font-size: 0.5em; vertical-align: middle;">('.$total.')</span>':'')
				, 'helloworld');
		JToolBarHelper::addNew('helloworld.add');

		if (($canDo->get('core.edit')) || ($canDo->get('core.edit.own')))
		{
			JToolbarHelper::editList('helloworld.edit');
		}

		if ($this->state->get('filter.published') == -2 && $canDo->get('core.delete'))
		{
			JToolbarHelper::deleteList('', 'helloworlds.delete', 'JTOOLBAR_EMPTY_TRASH');
		}
		JToolbarHelper::publish('helloworlds.publish', 'JTOOLBAR_PUBLISH', true);
		JToolbarHelper::unpublish('helloworlds.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		JToolbarHelper::archiveList('helloworlds.archive');

		if (JFactory::getUser()->authorise('core.admin'))
		{
			JToolbarHelper::checkin('helloworlds.checkin');
		}

		JToolbarHelper::trash('helloworlds.trash');
		JToolbarHelper::help('JHELP_COMPONENTS_HELLOWORLDS_HELLOWORLDS');
		JToolBarHelper::preferences('com_helloworld');
	}

	/**
	 * set document title
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('helloworlds'));
	}
}
