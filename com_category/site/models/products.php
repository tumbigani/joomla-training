<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Import Joomla modelitem library
jimport('joomla.application.component.modelitem');

/**
 * HelloWorld Model
 *
 * @since  0.0.1
 */
class CategoryModelProducts extends JModelList
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
	 * Get list of Category
	 *
	 * @return   Object  collection of categories
	 */
	public function getListQuery()
	{
		// Initialiase variables.
		$input = JFactory::getApplication()->input;
		$pid   = $input->get('pid');
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Create the base select statement.
		$query->select('a.*,a.categories as category_title')
			->from($db->quoteName('#__Product') . ' AS a')
			->where('a.id=' . $pid);

		// Set the query and load the result.
		$db->setQuery($query);

		return $query;
	}

	/**
	 * Get the Detail Of Extension table for com_category component.
	 *
	 * @return  mixed Array Of Object
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
	 * get the id of array
	 *
	 * @param   integer  $pid  id of product
	 *
	 * @return  mixed
	 */
	public function getidArray($pid)
	{
		// Initialiase variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Create the base select statement.
		$query->select('a.*')
			->from($db->qn('#__Product') . ' AS a')
			->where($db->qn('a.categories') . 'like' . $db->q('%' . $pid . '%'));

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
	 * get the title of category
	 *
	 * @param   integet  $id  id of the record
	 *
	 * @return  mixed
	 */
	public function getcategoryTitle($id)
	{
		// Initialiase variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Create the base select statement.
		$query->select('a.title as categoryTitle')
			->from($db->quoteName('#__Category') . ' AS a')
			->where($db->quoteName('a.id') . ' = ' . $db->quote($id));

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
	 * ChangeImage Method for change image on click event in front side.
	 *
	 * @return  Array  Array of orignal image and src of image.
	 */
	public function changeImage()
	{
		$input         = JFactory::getApplication()->input;
		$orignalimage  = $input->get('image');
		$fullImagePath = JPATH_ROOT . '/media/com_category/images/' . $orignalimage;
		$image         = new JImage(JPath::clean($fullImagePath));
		$thumbs        = $image->createThumbs('175x175');
		$src           = basename($thumbs[0]->getPath());
		$array = array('image' => $orignalimage,
						'thumbs' => $src
					);

		return $array;

	}
}
