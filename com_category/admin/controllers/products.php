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
 * Categories Controller
 *
 * @since  0.0.1
 */
class CategoryControllerProducts extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    name of model
	 * @param   string  $prefix  name of model prefix
	 * @param   array   $config  config array
	 *
	 * @since       2.5
	 *
	 * @return  void
	 */
	public function getModel($name = 'Product', $prefix = 'CategoryModel', $config=array())
	{
		return parent::getModel($name, $prefix, array('ignore_request' => true));
	}

	/**
	 * search the data in through ajax
	 *
	 * @return  void
	 */
	public function searchAjax()
	{
		// Required objects
		$app = JFactory::getApplication();
		$input = JFactory::getApplication()->input;
		$model = $this->getModel('Product', 'categoryModel');
		$like = $input->get('like', null, 'word');
		$like = str_replace(" ", "-", $like);

		// Receive request data
		$filters = array(
			'like'      => $like,
			'title'     => trim($app->input->get('title', null, 'word')),
			'flanguage' => $app->input->get('language', null),
			'published' => $app->input->get('published', 1, 'integer'),
			'parent_id' => $app->input->get('parent_id', null, 'integer')
		);

		if ($categories = $model->searchParent($filters))
		{
			// Output a JSON object
			echo json_encode($categories);
		}

		$app->close();
	}
}
