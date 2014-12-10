<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_Category
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die;

// Import Joomla modelform library

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.log.log');

/**
 * Category Model
 *
 * @since  0.0.1
 */
class CategoryModelProduct extends JModelAdmin
{
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
	 * save data from form
	 *
	 * @param   array  $data  form of data
	 *
	 * @return  boolean
	 */
	public function save($data)
	{
		try
		{
			$extension       = $this->getExtenstions();
			$extensionArray  = json_decode($extension->params);
			$extensionString = $extensionArray->upload_extensions;
			$extensions      = explode(",", $extensionString);
			$input           = JFactory::getApplication()->input;
			$file            = $input->files->get('jform', '', 'array')['image'];
			$id              = $input->getInt('id');
			$table           = JTable::getInstance('product', 'ProductTable');

			// Categories store in table with ",".
			if ($data['categories'])
			{
				$categories = implode(",", $data['categories']);
				$data['categories'] = $categories;
			}

			$pk = (!empty($data['id'])) ? $data['id'] : (int) $this->getState($this->getName() . '.id');
			$isNew = true;

			if ($pk > 0)
			{
				$table->load($pk);
				$data['image'] = $table->image;
				$files = explode(",", $data['image']);
				$defaultpos = in_array("default.gif", $files);

				if ($defaultpos)
				{
					$pos = array_search("default.gif", $files);
					unset($files[$pos]);
				}

				$files = array_values($files);
				$isNew = false;
			}

			for ($i = 0; $i < count($file); $i++)
			{
				if ($file[$i]['error'] == 0)
				{
					// Make the safe file name and remove all special charecter.
					$filename  = JFile::makeSafe($file[$i]['name']);
					$extension = JFile::getExt($filename);
					$filename  = JFile::stripExt($filename);
					$filename  = JFilterOutput::stringURLsafe($filename);
					$filename  = $filename . "." . $extension;
					$filename  = time() . $filename;
					$files[]   = $filename;
					$src       = $file[$i]['tmp_name'];
					$dest      = JPATH_ROOT . '/media/com_category/images/' . $filename;

					if (in_array(JFile::getExt($filename), $extensions))
					{
						if (!JFile::upload($src, $dest))
						{
							return false;
						}

						$data['image'] = $filename;
					}
					else
					{
						JLog::add(JText::_('JTEXT_ERROR_MESSAGE_EXTENCTION'), JLog::ERROR, 'jerror');

						return false;
					}

					$data['image'] = implode(",", $files);
					$data['default'] = $files[0];
				}
			}

			// Check if image not upload, set the default image .
			if (!$table->image && array_key_exists('image', $data) == false)
			{
				$data['image'] = 'default.gif';
				$data['default'] = 'default.gif';
			}

			return parent::save($data);
		}
		catch (RuntimeException $e)
		{
			throw new RuntimeException($e->getMessage(), 1);
		}
	}

	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  mixed   A JForm object on success, false on failure
	 *
	 * @since       2.5
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_category.product', 'product',
								array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	/**
	 * get the list of extensions in com_media component.
	 *
	 * @return  mixed  result of query
	 */
	public function getExtenstions()
	{
		// Initialiase variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Create the base select statement.
		$query->select('a.*')
			->from($db->quoteName('#__extensions') . ' AS a')
			->where($db->quoteName('a.element') . ' = ' . $db->quote('com_media'));

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
	 * Method to get the data that should be injected in the form.
	 *
	 * @return      mixed   The data for the form.
	 *
	 * @since       2.5
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_Category.edit.Category.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}

		return $data;
	}

	/**
	 * search the list of category
	 *
	 * @param   array  $filters  array of filter
	 *
	 * @return  array    array of result
	 */
	public static function searchParent($filters = array())
	{
		$jinput = JFactory::getApplication()->input;
		$id     = $jinput->getInt('id', 0);
		$id     = str_replace("-", ",", $id);
		$filters['like'] = str_replace("-", " ", $filters['like']);
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('a.id AS value,a.title AS text,a.level AS level,a.published')
			->where($db->qn('a.published') . ' <> -2 AND ' . $db->qn('a.published') . ' <> 2')
			->from('#__Category AS a')
			->join('LEFT', $db->quoteName('#__Category', 'b') . ' ON a.lft > b.lft AND a.rgt < b.rgt');

		// Do not return root
		$query->where($db->quoteName('a.level') . ' <> ' . $db->quote('root'));

		if ($id != 0)
		{
			$query->join('LEFT', $db->quoteName('#__Category') . ' AS p ON p.id IN ( ' . (int) $id . ')')
			->where('NOT(a.lft >= p.lft AND a.rgt <= p.rgt)');
		}

		// Search in title or path
		if (!empty($filters['like']))
		{
			$query->where(
			'(' . $db->quoteName('a.title') . ' LIKE ' . $db->quote('%' . $filters['like'] . '%') . ')'
			);
		}

		// Filter by parent_id
		if (!empty($filters['parent_id']))
		{
			JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_category/tables');
			$table = JTable::getInstance('Category', 'CategoryTable');

			if ($children = $tagTable->getTree($filters['parent_id']))
			{
				foreach ($children as $child)
				{
					$childrenIds[] = $child->id;
				}

				$query->where($db->qn('a.id') . ' IN (' . implode(',', $childrenIds) . ')');
			}
		}

		$query->group('a.id, a.title, a.level, a.lft, a.rgt, a.parent_id, a.published, a.path')
		->order('a.lft ASC');

		// Get the options.
		$db->setQuery($query);

		try
		{
			$results = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			return false;
		}

		for ($i = 0; $i < count($results); $i++)
		{
			if ($results[$i]->published != 1)
			{
				$results[$i]->text = str_repeat('- ', $results[$i]->level) . '[ ' . $results[$i]->text . ' ]';
			}
			else
			{
				$results[$i]->text = str_repeat('- ', $results[$i]->level) . $results[$i]->text;
			}
		}

		return $results;
	}
}
