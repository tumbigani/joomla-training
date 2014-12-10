<?php
/**
 * class for Sidebar
 */
class CategorySidebar
{
	/**
	 * For the set the views and links
	 *
	 * @return  mixed  Associative array
	 */
	public static function sidebar()
	{
		$option=array();
		$option['Categories']=JRoute::_('index.php?option=com_category&view=categories');
		$option['Products']=JRoute::_('index.php?option=com_category&view=products');
		return $option;
	}
}