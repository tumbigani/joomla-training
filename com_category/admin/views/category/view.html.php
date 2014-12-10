<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_Category
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die;

/**
 * Category View
 *
 * @since  0.0.1
 */
class CategoryViewCategory extends JViewLegacy
{
	/**
	 * View form
	 *
	 * @var         form
	 */
	protected $form = null;

	/**
	 * display method of Hello view
	 *
	 * @param   string  $tpl  default templete
	 *
	 * @return void
	 */
	public function display($tpl = null)
	{
		// Get the Data
		$form = $this->get('Form');
		$item = $this->get('Item');
		$this->state = $this->get('State');
		$this->canDo = JHelperContent::getActions('com_category', 'category', $item->id);

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));

			return false;
		}
		// Assign the Data
		$this->form = $form;
		$this->item = $item;

		// Set the toolbar
		$this->addToolBar();

		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();


	}

	/**
	 * Setting the toolbar
	 *
	 * @return void
	 */
	protected function addToolBar()
	{
		$user		= JFactory::getUser();
		$userId		= $user->get('id');
		$isNew		= ($this->item->id == 0);
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $userId);

		// Built the actions for new and existing records.
		$canDo		= $this->canDo;JToolBarHelper::title($isNew ? JText::_('COM_Category_MANAGER_Category_NEW')
									 : JText::_('COM_Category_MANAGER_Category_EDIT'), 'Category');

		if ($isNew > 0)
		{
			JToolbarHelper::apply('category.apply');
			JToolbarHelper::save2new('category.save2new');
			JToolBarHelper::save('category.save');
			JToolBarHelper::cancel('category.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
		}
		else
		{
			if (!$checkedOut)
			{
				// Since it's an existing record, check the edit permission, or fall back to edit own if the owner.
				if ($canDo->get('core.edit') || ($canDo->get('core.edit.own') && $this->item->created_by == $userId))
				{
					JToolbarHelper::apply('category.apply');
					JToolbarHelper::save('category.save');

					// We can save this record, but check the create permission to see if we can return to make a new one.
					if ($canDo->get('core.create'))
					{
						JToolbarHelper::save2new('category.save2new');
					}
				}
			}

			if ($canDo->get('core.create'))
			{
				JToolbarHelper::save2copy('category.save2copy');
			}

			if ($this->state->params->get('save_history', 0) && $user->authorise('core.edit'))
			{
				JToolbarHelper::versions('com_category.category', $this->item->id);
			}

			JToolbarHelper::cancel('category.cancel', 'JTOOLBAR_CLOSE');
		}
	}

	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		$isNew = ($this->item->id < 1);
		$document = JFactory::getDocument();
		$document->setTitle($isNew ? JText::_('COM_Category_Category_CREATING')
									   : JText::_('COM_Category_Category_EDITING'));
	}
}
