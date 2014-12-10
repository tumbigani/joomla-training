<?php

// No direct access
defined('_JEXEC') or die;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
$options['disable_search_threshold'] = 0;
JHtml::_('formbehavior.chosen', 'select', null, $options);
$document = JFactory::getdocument();
$document->addStylesheet(JURI::root(true) . "/media/com_category/style/style.css");
$document->addScript(JURI::root(true) . '/media/jui/js/jquery.min.js');
$document->addScript(JURI::root(true) . "/media/com_category/js/com_category.js");


?>
<form  action="<?php echo JRoute::_('index.php?option=com_category&layout=edit&view=product&id=' . (int) $this->item->id); ?>"

	method="post" enctype="multipart/form-data" id="adminForm" class="form-validate">


	<div class="form-horizontal">
		<fieldset class="adminform">
		<div class="row-fluid">
			<div class="span12">

		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_CATEGORY_PRODUCT_PRODUCT_INFORMATION', true)); ?>
		<div class="row-fluid">
			<div class="span9">

				<div class='span12'>
					<div class='span3'>
						<?php echo $this->form->getLabel('name'); ?>
					</div>
					<div class='span4'>
						<?php echo $this->form->getInput('name'); ?>
					</div>
				</div>

				<div class='span12'>
					<div class='span3' >
						<?php echo $this->form->getLabel('categories'); ?>
					</div>
					<div class='span4'>
						<?php echo $this->form->getInput('categories'); ?>
					</div>
				</div>


				<div class='span12'>
					<div class='span3' >
						<?php echo $this->form->getLabel('published'); ?>
					</div>
					<div class='span4'>
						<?php echo $this->form->getInput('published'); ?>
					</div>
				</div>
				<?php echo $this->form->getLabel('description'); ?>
				<?php echo $this->form->getInput('description'); ?>
			</div>

		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

			<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'publishing', JText::_('COM_CATEGORIES_PRODUCT_FIELDSET_IMAGE', true)); ?>
		<div class="row-fluid form-horizontal-desktop">

				<div class="span4">
				<?php echo $this->form->getLabel('image'); ?>
				<?php echo $this->form->getInput('image'); ?>
				</div>
			<div class="span7">
				<h3> Click On Image Set it default.</h3>
			<?php
			$input = JFactory::getApplication()->input;
			$id    = $input->getInt('id', 0);

			if ($id > 0)
			{
				$imageArray = $this->item->thumbsImage;
				$orignalArray = explode(",", $this->item->image);
				for ($i = 0; $i < count($imageArray); $i++)
				{
					?>
					<div class="span3 imagearea" id="<?php echo $orignalArray[$i]?>">
					<?php
					$ImageSrc = JURI::root() . '/media/com_category/images/thumbs/' . $imageArray[$i];
					$image = $orignalArray[$i];
					if ($orignalArray[$i] == $this->item->default)
					{
					?>
						<a href="#" class="closebtn"  id="<?php echo $orignalArray[$i]?>"><i class='icon-remove'></i></a>
						<img src="<?php echo $ImageSrc; ?>" class= "image imgborder" id ="<?php echo $image ?>">
					<?php
					}
					else
					{
						?>
						<a  href="#" class="closebtn"  id="<?php echo $orignalArray[$i]?>"><i class='icon-remove'></i></a>
						<img src="<?php echo $ImageSrc; ?>" class= "image" id ="<?php echo $image ?>">
						<?php
					}
					?>
					</div>
					<?php
				}
			}?>
			</div>


		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

			</div>

			<?php echo JHtml::_('bootstrap.endTabSet'); ?>
			</div>
		</fieldset>
	</div>
	<input type="hidden" name="task" value="category.edit" />
	<?php echo JHtml::_('form.token'); ?>
</form>
