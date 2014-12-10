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
class CategoryModelCategories extends JModelList
{
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return  string  An SQL query
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
				'a.id,a.lft,a.title,a.parent_id,a.published,a.checked_out,a.checked_out_time,a.level,a.alias,a.created_by'
			)
		);

		$ordering = $this->getState('list.fullordering');

		if ($ordering)
		{
			$query->order($ordering);
		}

		$query->where('a.parent_id != 0 ');
		$query->order('a.lft ASC');
		$query->from('#__Category AS a');
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
				$query->where('(' . $db->qn('a.title') . ' LIKE ' . $search . ')');
			}
		}

		return $query;
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
