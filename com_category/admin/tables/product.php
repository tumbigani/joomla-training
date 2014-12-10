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
class ProductTableProduct extends JTable
{
	/**
	 * Constructor
	 *
	 * @param   object  &$db  Database connector object
	 */
	function __construct(&$db)
	{
		parent::__construct('#__Product', 'id', $db);
	}
}
