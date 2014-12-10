<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_category
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * The Category Controller
 *
 * @package     Joomla.Site
 * @subpackage  com_tags
 * @since       3.1
 */
class CategoryControllerCategories extends JControllerLegacy
{
	/**
	 * Set the default image in front side.
	 *
	 * @return void
	 */
	public function setImage()
	{
		$app = JFactory::getApplication();
		$input = JFactory::getApplication()->input;
		$image = $input->get('image');
		$model = $this->getModel('Products', 'CategoryModel');
		echo json_encode($model->changeImage());
		$app->close();
	}

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
	public function getModel($name = 'Products', $prefix = 'CategoryModel', $config=array())
	{
		return parent::getModel($name, $prefix, array('ignore_request' => true));
	}
}
