<?php

// No direct access
defined('_JEXEC') or die;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');

$options['disable_search_threshold'] = 0;
JHtml::_('formbehavior.chosen', 'select', null, $options);
?>
<form action="<?php echo JRoute::_('index.php?option=com_category&layout=edit&id=' . (int) $this->item->id); ?>"

	method="post" enctype="multipart/form-data" name="adminForm" id="adminForm" class="form-validate">
	<?php echo JLayoutHelper::render('joomla.edit.title_alias', $this); ?>
	<div class="form-horizontal">
		<fieldset class="adminform">
		<div class="row-fluid">
			<div class="span9">
			<?php echo $this->form->getLabel('image'); ?>
			<?php echo $this->form->getInput('image'); ?>
			<?php
			$input = JFactory::getApplication()->input;
			$id    = $input->getInt('id', 0);

			if ($id > 0)
			{
				$ImageSrc = JURI::root() . '/media/com_category/images/' . $this->item->image;
				?>
				<br>
				<img src="<?php echo $ImageSrc; ?>" width='150px' height='150px'>
				<?php
			}
			?>
			<?php echo $this->form->getLabel('description'); ?>
			<?php echo $this->form->getInput('description'); ?>
			</div>
			<div class="span3">
			<?php echo JLayoutHelper::render('joomla.edit.global', $this);?>
			</div>
			</div>
		</fieldset>
	</div>
	<input type="hidden" name="task" value="category.edit" />
	<?php echo JHtml::_('form.token'); ?>
</form>
