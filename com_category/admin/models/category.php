<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_Category
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die;
jimport('joomla.filesystem.file');
jimport('joomla.log.log');

/**
 * Category Model
 *
 * @since  0.0.1
 */
class CategoryModelCategory extends JModelAdmin
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
	public function getTable($type = 'Category', $prefix = 'CategoryTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * update default image in table
	 *
	 * @param   string  $imageName  name of default image
	 *
	 * @return  void
	 */
	public function changeImage($imageName)
	{
		$input = JFactory::getApplication()->input;
		$id = $input->getInt('id');
		$table  = JTable::getInstance('Product', 'ProductTable');
		$table->load($id);
		$table->default = $imageName;
		$table->store();
	}

	/**
	 * delete image in table
	 *
	 * @param   string   $image        name of image
	 * @param   integer  $id           id of record
	 * @param   string   $thumbsimage  name of thumbimage
	 *
	 * @return  void
	 */
	public function deleteimage($image, $id, $thumbsimage)
	{
		$table      = JTable::getInstance('Product', 'ProductTable');
		$table->load($id);
		$result     = false;
		$imageArray = explode(",", $table->image);
		$pos        = array_search($image, $imageArray);

		unset($imageArray[$pos]);
		$dest = JPATH_ROOT . '/media/com_category/images/thumbs/' . $thumbsimage;
		$result = unlink($dest);
		var_dump($result);
		$imageArray = array_values($imageArray);

		if ($image == $table->default)
		{
			$table->default = $imageArray[0];
			$result         = true;
		}

		$newimage = implode(",", $imageArray);

		if (!$newimage)
		{
			$newimage       = 'default.gif';
			$table->default = 'default.gif';
		}

		$table->image = $newimage;
		$table->store();
		$array = array(
					"result" => $result,
					"defaultimage" => $table->default
		);

		return $array;
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
			if ($data['parent_id'] == 0)
			{
				$data['parent_id'] = 1;
			}

			JTable::addIncludePath(JPATH_COMPONENT . '/tables/');
			$table     = JTable::getInstance('category', 'CategoryTable');
			$rootId    = $table->getRootId();
			$pk        = (!empty($data['id'])) ? $data['id'] : (int) $this->getState($this->getName() . '.id');
			$input     = JFactory::getApplication()->input;
			$file      = $input->files->get('jform', '', 'array')['image'];

			// Make safe file name and remove all the special charecter.
			$filename  = JFile::makeSafe($file['name']);
			$extension = JFile::getExt($filename);
			$filename  = JFile::stripExt($filename);
			$filename  = JFilterOutput::stringURLsafe($filename);
			$filename  = $filename . "." . $extension;
			$filename  = time() . $filename;
			$src       = $file['tmp_name'];
			$dest      = JPATH_ROOT . '/media/com_category/images/' . $filename;
			$isNew     = true;

			if ($pk > 0)
			{
				$table->load($pk);
				$isNew = false;
			}

			if ($data['alias'] == "")
			{
				$data['alias'] = JFilterOutput::stringURLSafe($data['title']);
			}

			if ($rootId === false)
			{
				$rootId = $table->addRoot();
			}

			if ($file['error'] == 0)
			{
				if (JFile::getExt($filename) == 'jpg'
					|| JFile::getExt($filename) == 'png'
					|| JFile::getExt($filename) == 'gif'
					|| JFile::getExt($filename) == 'jpeg')
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
			}


			// Check if image not upload, set the default image .
			if (!$table->image && array_key_exists('image', $data) == false)
			{
				$data['image'] = 'default.gif';
			}


			$table->setLocation($data['parent_id'], 'last-child');

			// Check the duplicate entry in table with alias.
			if (!$this->checkAlias($data['alias'], $isNew))
			{
				if (!$table->bind($data))
				{
					return fasle;
				}

				if (!$table->check())
				{
					return false;
				}

				if (!$table->store())
				{
					return false;
				}

				if (!$table->rebuildPath($table->id))
				{
					$this->setError($table->getError());

					return false;
				}

				if (!$table->rebuild($table->id, $table->lft, $table->level, $table->path))
				{
					$this->setError($table->getError());

					return false;
				}

				$this->setState($this->getName() . '.id', $table->id);

				return true;
			}
			else
			{
				$this->setState($this->getName() . '.id', $table->id);
				$this->setError(JText::_('JLIB_DATABASE_ERROR_CATEGORY_UNIQUE_ALIAS'));

				return false;
			}
		}
		catch (RuntimeException $e)
		{
			throw new RuntimeException($e->getMessage(), 1);
		}
	}

	/**
	 * check duplicate alias
	 *
	 * @param   string  $alias  alias value
	 * @param   string  $isNew  check is new or not
	 *
	 * @return  boolean
	 */
	public function checkAlias($alias,$isNew)
	{
		// Initialiase variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Create the base select statement.
		$query->select('*')
			->from($db->qn('#__Category'))
			->where($db->qn('alias') . ' = ' . $db->q($alias));

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

		if ($result &&  $isNew)
		{
			return true;
		}
		else
		{
			return false;
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
		$form = $this->loadForm('com_category.category', 'category',
								array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}

		return $form;
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
	 * rebuild the tree structure
	 *
	 * @return  void
	 */
	public function rebuild()
	{
		// Get an instance of the table object.
		$table = $this->getTable();

		if (!$table->rebuild())
		{
			$this->setError($table->getError());

			return false;
		}

		// Clear the cache
		$this->cleanCache();

		return true;
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
		$id = $jinput->getInt('id', 0);
		$filters['like'] = base64_decode($filters['like']);

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
			$query->join('LEFT', $db->quoteName('#__Category') . ' AS p ON ' . $db->qn('p.id') . ' = ' . (int) $id)
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
