<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_Category
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Hello Table class
 *
 * @since  0.0.1
 */
class CategoryTableCategory extends JTableNested
{
	/**
	 * Constructor
	 *
	 * @param   object  &$db  Database connector object
	 */
	function __construct(&$db)
	{
		parent::__construct('#__Category', 'id', $db);
	}

	/**
	 * if root not found in table then it create root.
	 *
	 * @return  void
	 */
	public function addRoot()
	{
		$db = JFactory::getDbo();
		$sql = 'INSERT INTO `#__Category`'
			. ' SET parent_id = 0'
			. ', lft = 0'
			. ', rgt = 1'
			. ', level = 0'
			. ', title = ' . $db->quote('root')
			. ', alias = ' . $db->quote('root')
			. ', access = 1'
			. ', path = ' . $db->quote('');
		$db->setQuery($sql);
		$db->query();

		return $db->insertid();
	}
}
