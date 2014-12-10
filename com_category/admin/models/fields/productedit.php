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
class JFormFieldProductEdit extends JFormFieldList
{
	protected static $loaded = array();

	/**
	 * A flexible category list that respects access controls
	 *
	 * @var string
	 * @since 1.6
	 */
	public $type = 'ProductEdit';

	/**
	 * get input from select list
	 *
	 * @return  void
	 */
	public function getInput()
	{
		$id    = isset($this->element['id']) ? $this->element['id'] : null;
		$cssId = '#' . $this->getId($id, $this->element['name']);

		// Load the ajax-chosen customised field
		$this->ajaxfield($cssId);

		// For selected element in options
		if (is_string($this->value))
		{
			$this->value = explode(",", $this->value);
		}

		$input = parent::getInput();

		return $input;
	}

	/**
	 * This is just a proxy for the formbehavior.ajaxchosen method
	 *
	 * @param   string  $selector  DOM id of the tag field
	 *
	 * @return  void
	 *
	 * @since   3.1
	 */
	public function ajaxfield($selector='#jform_parent_id')
	{
		$id = $this->value;
		$id = str_replace(",", "-", $id);

		// Tags field ajax
		$chosenAjaxSettings = new JRegistry(
			array(
				'selector'    => $selector,
				'type'        => 'GET',
				'url'         => JUri::root() . 'administrator/index.php?option=com_category&task=Products.searchAjax&tmpl=component&id=' . $id,
				'dataType'    => 'json',
				'jsonTermKey' => 'like'
			)
		);
		JHtml::_('formbehavior.ajaxchosen', $chosenAjaxSettings);
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
		$options = array();
		$jinput  = JFactory::getApplication()->input;
		$id      = $jinput->getInt('id', 0);

		if ($id)
		{
			$categoryId = implode(",", $this->value);
			$db = JFactory::getDbo();
			$query = $db->getQuery(true)
				->select('a.id AS value,a.parent_id as parentId, a.title AS text, a.level, a.published')
				->from('#__Category AS a')
				->where('a.id IN (' . $categoryId . ') AND a.level <> 0');
			$db->setQuery($query);
			$options = $db->loadObjectList();
		}

		$options[] = JText::_('COM_CATEGOORIES_PRODUCT_UNCATEGORY');
		$options   = array_merge(parent::getOptions(), $options);

		return $options;
	}
}
