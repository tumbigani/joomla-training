<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_category
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Import Joomla modelitem library
jimport('joomla.application.component.modelitem');

/**
 * Category Model
 *
 * @since  0.0.1
 */
class CategoryModelCategories extends JModelList
{
	/**
	 * @var array messages
	 */
	protected $messages;

	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param   type    $type    The table type to instantiate
	 * @param   string  $prefix  A prefix for the table class name. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JTable  A database object
	 *
	 * @since       2.5
	 */
	public function getTable($type = 'Product', $prefix = 'ProductTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * GetExtensions Method to get category extension.
	 *
	 * @return  object object of extensions
	 */
	public function getExtensions()
	{
		// Initialiase variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Create the base select statement.
		$query->select('a.*')
			->from($db->quoteName('#__extensions') . ' AS a')
			->where($db->quoteName('a.element') . ' = ' . $db->quote('com_category'));


		// Set the query and load the result.
		$db->setQuery($query);

		try
		{
			$result = $db->loadObject();
		}
		catch (RuntimeException $e)
		{
			throw new RuntimeException($e->getMessage(), $e->getCode());
		}

		return $result;

	}

	/**
	 * Get list of Category
	 *
	 * @return   Object  collection of categories
	 */
	public function getCategory()
	{
		$input = JFactory::getApplication()->input;
		$id = $input->getInt('id');

		// Initialiase variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Create the base select statement.
		$query->select('a.*')
			->from($db->quoteName('#__Category') . ' AS a');

		// Display the child category of selected parent category
		if (isset($id))
		{
			$query->select('c.title as category_title')
				->join('LEFT', '#__Category AS c ON (c.lft < a.lft AND c.rgt > a.rgt)')
				->where('c.id = ' . (int) $id);
		}
		else
		{
			$query->where('a.level = 1');
		}

		$query->order('a.lft ASC')
			->where('a.published=1');

		// Set the query and load the result.
		$db->setQuery($query);

		try
		{
			$result = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			throw new RuntimeException($e->getMessage(), $e->getCode());
		}

		return $result;
	}

	/**
	 * get the title of category from the id
	 *
	 * @param   int  $categoryId  category id
	 *
	 * @return  object  return the array and object of title
	 */
	public function getcategoryTitle($categoryId)
	{
		// Initialiase variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Create the base select statement.
		$query->select('title')
			->from($db->quoteName('#__Category'))
			->where($db->quoteName('id') . ' = ' . $categoryId);

		// Set the query and load the result.
		$db->setQuery($query);

		try
		{
			$result = $db->loadObject();
		}
		catch (RuntimeException $e)
		{
			throw new RuntimeException($e->getMessage(), $e->getCode());
		}

		return $result;
	}

	/**
	 * Get list of Category
	 *
	 * @return   Object  collection of categories
	 */
	public function getListQuery()
	{
		$input = JFactory::getApplication()->input;
		$id = $input->get('id');

		// Initialiase variables.
		$input = JFactory::getApplication()->input;
		$id = $input->get('id');

		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Create the base select statement.
		$query->select('a.*')
			->from($db->quoteName('#__Product') . ' AS a')
			->where('a.categories like ' . $db->quote('%' . $id . '%'))
			->where('a.published=1');

		// Join over the categories.
		$query->select('c.title AS category_title')
			->join('LEFT', '#__Category AS c ON c.id = a.categories');

		// Set the query and load the result.
		$db->setQuery($query);

		return $query;
	}

	/**
	 * get the heading of category in view site
	 *
	 * @param   integet  $id  pass the id of category
	 *
	 * @return  object
	 */
	public function CategoryHeading($id)
	{
		// Initialiase variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Create the base select statement.
		$query->select('a.*')
			->from($db->quoteName('#__Category') . ' AS a')
			->where($db->quoteName('a.id') . ' = ' . $db->quote($id));


		// Set the query and load the result.
		$db->setQuery($query);

		try
		{
			$result = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			throw new RuntimeException($e->getMessage(), $e->getCode());
		}

		return $result;

	}

	/**
	 * This method should only be called once per instantiation and is designed
	 * to be called on the first call to the getState() method unless the model
	 * configuration flag to ignore the request is set.
	 *
	 * @param   string  $ordering   ordering
	 * @param   string  $direction  direction
	 *
	 * @return  void
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		$jsonarray  = json_decode($this->getExtensions()->params, true);
		$pagination = $jsonarray['pagination'];
		$input      = JFactory::getApplication()->input;
		$limitstart = $input->getInt('limitstart');
		$this->setState('list.limit', $pagination);
		$this->setState('list.start', $limitstart);
	}
}
