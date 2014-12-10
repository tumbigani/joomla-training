<?php

// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen', 'select');
$user           = JFactory::getUser();
$userId = $user->get('id');


// Check if the article uses configuration settings besides global. If so, use them.
if (isset($this->item->attribs['show_publishing_options']) && $this->item->attribs['show_publishing_options'] != '')
{
	$params->show_publishing_options = $this->item->attribs['show_publishing_options'];
}

?>
<form action="<?php echo JRoute::_('index.php?option=com_helloworld&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" name="adminForm" id="adminForm" class="form-validate">
	<div class="form-horizontal">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_HELLOWORLD_HELLOWORLD_DETAILS'); ?></legend>
			<div class="row-fluid">
				<div class="span12">



						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('greeting'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('greeting');?></div>
						</div>
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('published'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('published');?></div>
						</div>
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('txt'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('txt');?></div>
						</div>

						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('description'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('description');?></div>
						</div>
						<?php
							$dispatcher = JDispatcher::getInstance();
							$results = $dispatcher->trigger('onload');
						?>


				</div>
			</div>
		</fieldset>
	</div>
	<input type="hidden" name="created_by" value="<?php echo $userId; ?>">
	<input type="hidden" name="task" value="helloworld.edit" />
	<?php echo JHtml::_('form.token'); ?>
</form>
