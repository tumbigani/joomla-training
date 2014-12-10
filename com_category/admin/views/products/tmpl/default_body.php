<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die;
//echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
$user		= JFactory::getUser();
$userId		= $user->get('id');
echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
?>
<?php foreach($this->items as $i => $item):
$canEdit    = $user->authorise('core.edit',       'com_helloworld.helloworld.' . $item->id);
$canCheckin = $user->authorise('core.manage',     'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
$canChange  = $user->authorise('core.edit.state', 'com_helloworld.helloworld.' . $item->id) && $canCheckin;
?>

		<tr class="row<?php echo $i % 2; ?>">
				<td>
					<?php echo JHtml::_('grid.id', $i, $item->id); ?>
				</td>
				<td>
					<?php echo JHtml::_('jgrid.published', $item->published, $i, 'products.'); ?>
				</td>
				<td>
				<?php
				if ($item->checked_out): ?>
				<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'products.', $canCheckin); ?>
				<?php endif; ?>


				<a href="<?php echo JRoute::_('index.php?option=com_category&view=product&task=product.edit&layout=edit&id=' . $item->id . ''); ?>">

				<?php echo $item->name; ?></a>
				</td>
				<td>
					<?php echo $item->category_title ?>
				</td>
				<td>
					<?php echo $item->id; ?>
				</td>
		</tr>
<?php endforeach; ?>
