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
class CategoryControllerCategories extends JControllerAdmin
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
	public function getModel($name = 'Category', $prefix = 'categoryModel', $config=array())
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
		$model = $this->getModel('Category', 'categoryModel');
		$like = $input->get('like', null, 'word');

		$like = base64_encode($like);
		//echo urldecode($url);


		// Receive request data
		$filters = array(
			'like'      => $like,
			'title'     => trim($app->input->get('title', null)),
			'flanguage' => $app->input->get('flanguage', null),
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

	/**
	 * change the default image in backend
	 *
	 * @return  void
	 */
	public function clickImage()
	{
		$input     = JFactory::getApplication()->input;
		$imagename = $input->get('image');
		$model     = $this->getModel('Category', 'categoryModel');
		$model->changeImage($imagename);
	}

	/**
	 * delete image in table
	 *
	 * @return  void
	 */
	public function deleteImage()
	{
		$app   = JFactory::getApplication();
		$input = JFactory::getApplication()->input;
		$id    = $input->getInt('id');
		$image = $input->get('image');
		$thumbsimage = $input->get('thumb');
		$model = $this->getModel('Category', 'categoryModel');
		$model->deleteimage($image, $id, $thumbsimage);
		$app->close();
	}

	/**
	 * Rebuid the nested set tree.
	 *
	 * @return  boolean false on failure or error, true on success
	 */
	public function rebuild()
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		$this->setRedirect(JRoute::_('index.php?option=com_category&view=categories', null));

		if ($this->getModel()->rebuild())
		{
			// Rebuild succeeded.
			$this->setMessage(JText::_('COM_CATEGORIES_REBUILD_SUCCESS'));

			return true;
		}
		else
		{
			// Rebuild failed.
			$this->setMessage(JText::_('COM_CATEGORIES_REBUILD_FAILURE'));

			return false;
		}
	}
}

