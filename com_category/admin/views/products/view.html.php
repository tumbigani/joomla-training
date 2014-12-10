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
 * Categories View
 *
 * @since  0.0.1
 */
class CategoryViewProducts extends JViewLegacy
{
	/**
	 * Categories view display method
	 *
	 * @param   string  $tpl  default templete
	 *
	 * @return void
	 */
	function display($tpl = null)
	{
		// Get data from the model
		$items = $this->get('Items');
		$this->productData = $this->get('Items');
		$model = $this->getModel('Products', 'CategoryModel');

		// Get the title of categories with subcategories
		for ($i = 0; $i < count($this->productData); $i++)
		{
			$string = "";
			$categoriesArray = explode(",", $this->productData[$i]->categories);

			for ($j = 0; $j < count($categoriesArray); $j++)
			{
				$array[$j] = $model->getcategoryTitle($categoriesArray[$j]);
				$string .= $array[$j]->title . ",";
			}

			//  Replace last "," in string with blank.
			$patern = "/[,]$/";
			$string = preg_replace($patern, "", $string);
			$this->productData[$i]->category_title = $string;
			$array  = array();
		}


		$pagination          = $this->get('Pagination');
		$this->state         = $this->get('State');
		$this->assoc         = $this->get('Assoc');
		$this->activeFilters = $this->get('ActiveFilters');
		$this->filterForm    = $this->get('FilterForm');
		$user                = JFactory::getUser();
		$userId              = $user->get('id');

		// Sidebar helper class.
		JLoader::register('CategorySidebar', JPATH_COMPONENT . '/helpers/category.php');
		$obj = new CategorySidebar;
		$this->side = $obj->sidebar();

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));

			return false;
		}

		// Assign data to the view
		$this->items      = $items;
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
		$canDo = JHelperContent::getActions('com_category', 'product');

		JToolBarHelper::title(JText::_('COM_CATEGORY_MANAGER_CATEGORIES')
			. ($total?' <span style="font-size: 0.5em; vertical-align: middle;">(' . $total . ')</span>':''), 'Category'
		);

		JToolBarHelper::addNew('product.add');

		if (($canDo->get('core.edit')) || ($canDo->get('core.edit.own')))
		{
			JToolbarHelper::editList('product.edit');
		}

		if ($this->state->get('filter.published') == -2 && $canDo->get('core.delete'))
		{
			JToolbarHelper::deleteList('', 'products.delete', 'JTOOLBAR_EMPTY_TRASH');
		}

		JToolbarHelper::publish('products.publish', 'JTOOLBAR_PUBLISH', true);
		JToolbarHelper::unpublish('products.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		JToolbarHelper::archiveList('products.archive');

		if (JFactory::getUser()->authorise('core.admin'))
		{
			JToolbarHelper::checkin('products.checkin');
			JToolBarHelper::preferences('com_category');
		}

		JToolbarHelper::trash('products.trash');

	}

	/**
	 * set document title
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('Categories'));
	}
}
