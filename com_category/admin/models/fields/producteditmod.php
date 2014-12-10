<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_category
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

JFormHelper::loadFieldClass('list');

/**
 * Form Field class for the Joomla Framework.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_category
 *
 * @since       1.6
 */
class JFormFieldProductEditMod extends JFormFieldList
{
	protected static $loaded = array();

	/**
	 * A flexible category list that respects access controls
	 *
	 * @var string
	 * @since 1.6
	 */
	public $type = 'ProductEditMod';

	/**
	 * This is just a proxy for the formbehavior.ajaxchosen method
	 *
	 * @return  void
	 *
	 * @since   3.1
	 */
	public function ajaxfield()
	{
		$id = JFactory::getApplication()->input->get('id');
		$id = str_replace(",", "-", $id);

		// Tags field ajax
		$chosenAjaxSettings = new JRegistry(
			array(
				'selector'    => '#' . $this->getId($this->element['name'], $id),
				'type'        => 'GET',
				'url'         => JUri::root() . 'administrator/index.php?option=com_category&task=products.searchAjax&tmpl=component',
				'dataType'    => 'json',
				'jsonTermKey' => 'like'
			)
		);
		JHTml::_('formbehavior.ajaxchosen', $chosenAjaxSettings);
	}

	/**
	 * Get Input function.
	 *
	 * @return  void
	 */
	public function getInput()
	{
		// Load the ajax-chosen customised field
		$this->ajaxfield();

		// Make options selected by setting value to an array
		if (!is_array($this->value))
		{
			$this->value = explode(',', $this->value);
		}

		return parent::getInput();
	}

	/**
	 * Method to get a list of category that respects access controls and can be used for
	 * either category assignment or parent category assignment in edit screens.
	 * Use the parent element to indicate that the field will be used for assigning parent category.
	 *
	 * @return array The field option objects.
	 *
	 * @since 1.6
	 */
	protected function getOptions()
	{
		return array_merge(
			$this->_getProductCategories(),
			array(JText::_('COM_CATEGOORIES_PRODUCT_UNCATEGORY')),
			parent::getOptions()
		);
	}

	/**
	 * Get Selected Categories of current product
	 *
	 * @return  mixed  An Associative array Object of category ids
	 */
	private function _getProductCategories()
	{
		// Make category ids safe
		JArrayHelper::toInteger($this->value);

		$categoryIds = implode(',', $this->value);

		if (null == $categoryIds)
		{
			return array();
		}

		// Initialiase variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Create the base select statement.
		$query->select($db->qn('title') . ' as text, ' . $db->qn('id') . ' as value')
			->from($db->qn('#__Category'))
			->where($db->qn('id') . ' IN (' . $categoryIds . ')');

		// Set the query and load the result.
		$db->setQuery($query);

		try
		{
			$categories = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			throw new RuntimeException($e->getMessage(), $e->getCode());
		}

		return $categories;
	}
}
