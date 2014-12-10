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
class CategoryViewProducts extends JViewLegacy
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
		$document = JFactory::getDocument();
		$document->addScript(JURI::root(true) . '/media/jui/js/jquery.min.js');
		$document->addScript(JURI::root(true) . "/media/com_category/js/com_category.js");
		$document->addStylesheet(JURI::root(true) . "/media/com_category/style/style.css");
		$input             = JFactory::getApplication()->input;
		$id                = $input->getInt('id');
		$pid               = $input->getInt('pid');
		$extension         = $this->get('Extensions');
		$this->slideshow   = json_decode($extension->params, true);
		$this->slide = $this->slideshow['slidshow'];
		$model             = $this->getModel('Products', 'CategoryModel');
		$image = " ";
		$this->productData = $this->get('Items');

		for ($i = 0; $i < count($this->productData); $i++)
		{
			$this->imagearray                    = explode(",", $this->productData[$i]->image);
			$fullImagePath                       = JPATH_ROOT . '/media/com_category/images/' . $this->productData[$i]->default;
			$this->key = array_search($this->productData[$i]->default, $this->imagearray);
			$image                               = new JImage(JPath::clean($fullImagePath));
			$thumbs                              = $image->createThumbs('175x175');
			$this->productData[$i]->image        = basename($thumbs[0]->getPath());
			$this->productData[$i]->orignal      = basename($fullImagePath);
			$this->productData[$i]->imagearray   = $this->imagearray;
			$this->productData[$i]->orignalarray = $this->imagearray;

			for ($j = 0; $j < count($this->imagearray); $j++)
			{
				$fullImagePath = JPATH_ROOT . '/media/com_category/images/' . $this->imagearray[$j];
				$image = new JImage(JPath::clean($fullImagePath));
				$thumbs = $image->createThumbs('75x75');
				$this->productData[$i]->imagearray[$j] = basename($thumbs[0]->getPath());
			}
		}

		$value = $model->getidArray($id);

		for ($i = 0; $i < count($value); $i++)
		{
			$this->idArray[$i] = $value[$i]->id;
		}

		$this->maximum = max(array_keys($this->idArray));
		$this->minimum = min(array_keys($this->idArray));
		$current       = array_search($pid, $this->idArray);
		$prev          = 0;

		if ($current >= 0)
		{
			$prev = $current;
			$prev = $prev-1;
		}

		if ($current >= 0)
		{
			$current = $current + 1;
		}

		$this->nextshow = false;
		$this->prevshow = false;

		if ($this->maximum >= $current)
		{
			$this->nextshow = true;
			$this->pid = $this->idArray[$current];
		}

		$this->prev = $prev;

		if ($this->prev >= 0)
		{
			$this->prevshow = true;
		}

		$this->id = $id;
		$title = $model->getcategoryTitle($id);
		$this->slideMax = max(array_keys($this->productData[0]->orignalarray));
		$this->slideMin = min(array_keys($this->productData[0]->orignalarray));

		for ($i = 0; $i < count($this->productData); $i++)
		{
			$this->productData[$i]->category_title = $title->categoryTitle;
		}

		// Display the view
		parent::display($tpl);
	}
}
