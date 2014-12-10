<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the HelloWorld Component
 *
 * @since  0.0.1
 */
class CategoryViewCategories extends JViewLegacy
{
	/**
	 * Overwritting JViwe display method
	 *
	 * @param   int  $tpl  default templete value
	 *
	 * @return  boolean        return true or false
	 */
	function display($tpl = null)
	{
		$input    = JFactory::getApplication()->input;
		$id       = $input->getInt('id');
		$this->id = $id;
		$model    = $this->getModel('Categories', 'CategoryModel');

		// Get the Width and Height of the image in table.
		$extension = $this->get('Extensions');
		$jsonarray = json_decode($extension->params, true);
		if ($jsonarray['image_width'] && $jsonarray['image_height'])
		{
			$imagesize = $jsonarray['image_width'] . "x" . $jsonarray['image_height'];
		}
		else
		{
			$imagesize = "140x140" ;
		}


		// Assign data to the view
		$this->data = $this->get('Category');

		for ($i = 0; $i < count($this->data); $i++)
		{
			$fullImagePath = JPATH_ROOT . '/media/com_category/images/' . $this->data[$i]->image;
			$image         = new JImage(JPath::clean($fullImagePath));
			$thumbs        = $image->createThumbs($imagesize);
			$this->data[$i]->image = basename($thumbs[0]->getPath());
		}

		if ($id > 0)
		{
			$this->productData = $this->get('Items');

			// Remove category which is not releted to product.
			for ($k = 0; $k < count($this->productData); $k++)
			{
				$categoryArray = explode(",", $this->productData[$k]->categories);

				if (!in_array($id, $categoryArray))
				{
					unset($this->productData[$k]);
					$this->productData = array_values($this->productData);
				}
			}

			for ($i = 0; $i < count($this->productData); $i++)
			{
				$imagearray    = explode(",", $this->productData[$i]->image);
				$fullImagePath = JPATH_ROOT . '/media/com_category/images/' . $this->productData[$i]->default;
				$image         = new JImage(JPath::clean($fullImagePath));
				$image->getImageFileProperties($fullImagePath);
				$thumbs = $image->createThumbs($imagesize);
				$this->productData[$i]->image = basename($thumbs[0]->getPath());
			}

			$this->CategoryTitle = $model->CategoryHeading($id);
			$pagination = $this->get('Pagination');
			$this->pagination = $pagination;

			for ($i = 0; $i < count($this->productData); $i++)
			{
				$string = "";
				$categoriesArray = explode(",", $this->productData[$i]->categories);

				for ($j = 0; $j < count($categoriesArray); $j++)
				{
					$array[$j] = $model->getcategoryTitle($categoriesArray[$j]);
					$string .= $array[$j]->title . ",";
				}

				$patern = "/[,]$/";
				$string = preg_replace($patern, "", $string);
				$this->productData[$i]->category_title = $string;
				$array  = array();
			}
		}

		// Display the view
		parent::display($tpl);
	}
}
