<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die;

// Load tooltip behavior
// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');

$options['disable_search_threshold'] = 0;
JHtml::_('formbehavior.chosen', 'select', $options);
$document = JFactory::getDocument();
$document->addScript(JURI::root(true) . '/media/jui/js/jquery.min.js');
$document->addScript(JURI::root(true) . "/media/com_category/js/com_category.js");
$document->addStylesheet(JURI::root(true) . "/media/com_category/style/style.css");


?>


<form action="<?php echo JRoute::_('index.php?option=com_category&view=products'); ?>" method="post" name="adminForm" id="adminForm"><div id="j-sidebar-container" class="span2">
<ul id="submenu" class="nav nav-list">
<?php
foreach ($this->side as $key => $value) {
    ?>
    <li>
        <li class="sidebar" >
        <a href="<?php echo $value; ?>"  ><?php echo $key; ?></a>
        </li>

    </li>
    <?php
}
?>
</ul>

</div>
<div id="j-main-container" class="span10">
        <table class="table table-striped">
                <thead><?php echo $this->loadTemplate('head');?></thead>
                <tbody><?php echo $this->loadTemplate('body');?></tbody>
                <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
        </table>
        <div>
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
</form>
