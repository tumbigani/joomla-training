<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die;

$listDirn   = $this->escape($this->state->get('list.direction'));
//$archived   = $this->state->get('filter.published') == 2 ? true : false;
//$trashed    = $this->state->get('filter.published') == -2 ? true : false;
?>
<tr>
	<th width="20">
		<?php echo JHtml::_('grid.checkall'); ?>
	</th>

	<th width="10%" class="nowrap hidden-phone">
		<?php echo JHtml::_('searchtools.sort', 'JSTATUS', 'a.published', $listDirn); ?>
	</th>

	<th>
	   <?php echo JHtml::_('searchtools.sort', 'COM_CATEGORIES_PRODUCT_NAME', 'a.name', $listDirn); ?>
	</th>

	<th>
	   <?php echo JHtml::_('searchtools.sort', 'COM_CATEGORIES_CATEGORY_NAME', 'a.name', $listDirn); ?>
	</th>

	<th width="1%" class="nowrap hidden-phone">
		<?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn); ?>
	</th>
</tr>
