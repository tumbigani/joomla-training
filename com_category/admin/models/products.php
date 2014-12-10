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
 * CategoryList Model
 *
 * @since  0.0.1
 */
class CategoryModelProducts extends JModelList
{
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);
		$user  = JFactory::getUser();
		$app   = JFactory::getApplication();

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.id,a.name,a.categories,a.published,a.checked_out,a.checked_out_time'
			)
		);

		$query->select('c.title AS category_title')
			->join('LEFT', '#__Category AS c ON c.id = a.categories');

		$ordering = $this->getState('list.fullordering');

		if ($ordering)
		{
			$query->order($ordering);
		}

		$query->from('#__Product AS a');
		$query->select('uc.name AS editor')
			->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');

		// Filter by published state
		$published = $this->getState('filter.published');

		if (is_numeric($published))
		{
			$query->where($db->qn('a.published') . ' = ' . (int) $published);
		}
		elseif ($published == '')
		{
			$query->where('(' . $db->qn('a.published') . ' = 0 OR ' . $db->qn('a.published') . ' = 1)');
		}

		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where($db->qn('a.id') . ' = ' . (int) substr($search, 3));
			}

			else
			{
				$search = $db->quote('%' . $db->escape($search, true) . '%');
				$query->where('(a.name LIKE ' . $search . ')');
			}
		}

		return $query;
	}

	/**
	 * cat the title of category from the id of array
	 *
	 * @param   integer  $categoryId  id of the category
	 *
	 * @return  object  return the array of object
	 */
	public function getcategoryTitle($categoryId)
	{
		// Initialiase variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Create the base select statement.
		$query->select('title')
			->from($db->quoteName('#__Category'))
			->where($db->quoteName('id') . ' = ' . (int) $categoryId);

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
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param   string  $id  A prefix for the store id.
	 *
	 * @return  string  A store id.
	 *
	 * @since   1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . $this->getState('filter.published');

		return parent::getStoreId($id);
	}
}
