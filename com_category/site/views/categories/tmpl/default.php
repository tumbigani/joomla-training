<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$data = $this->data;

$input = JFactory::getApplication()->input;
$itemId = $input->getInt('Itemid');

if ($this->id > 0)
{
	for ($i = 0; $i < count($this->CategoryTitle); $i++)
	{
		?>
		<h1>Category :- <?php echo $this->CategoryTitle[$i]->title; ?></h1>
		<?php
	}
}
?>



<main id="content" class="span12" role="main">
<div class='row'>

<?php

for ($i = 0; $i < count($data); $i++)
{
	?>
	<div class='span3' style="margin-left:0">
	<?php

	if ($data[$i]->image == '')
	{

		echo $data[$i]->image;
		$ImageSrc = JURI::root() . '/media/com_category/images/thumbs/default.gif';
		?>
		<img src="<?php echo $ImageSrc;?>"  class="img-polaroid">
		<?php
	}
	else
	{
		$ImageSrc = JURI::root() . '/media/com_category/images/thumbs/' . $data[$i]->image;
		?>
		<img src="<?php echo $ImageSrc;?>" class="img-polaroid">
		<?php
	}
	?>
	<h2> <a href="index.php?option=com_category&view=categories&Itemid=<?php echo $itemId; ?>&id=<?php echo $data[$i]->id;?>" ><?php echo  $data[$i]->title; ?> </a> </h2>
	<p><?php echo $data[$i]->description; ?></p>
	</div>
	<?php
}
?>
</div>

<?php
if ($this->id > 0)
{
	?>
	<div class='well well-small' ><h1> Products</h1> </div>
	<?php
	$productData = $this->productData;

	if (count($productData) == 0)
	{
		?>
		<h2> No Product Found </h2>
		<?php
	}
	else
	{
	?>
		<div class='row'>

		<?php

		for ($i = 0; $i < count($productData); $i++)
		{
			?>
			<div class='span3' style="margin-left:0" >
			<?php

			if ($productData[$i]->image)
			{
				$ImageSrc = JURI::root() . '/media/com_category/images/thumbs/' . $productData[$i]->image;
				?>
				<img src="<?php echo $ImageSrc; ?>" class='img-polaroid'>
				<?php
			}
			else
			{
				$ImageSrc = JURI::root() . '/media/com_category/images/thumbs/default.gif' ;
				?>
				<img src="<?php echo $ImageSrc; ?>" class='img-polaroid'>
			<?php
			}
			?>
			<h3><a href='index.php?option=com_category&view=products&Itemid=<?php echo $itemId; ?>&id=<?php echo $this->id; ?>&pid=<?php echo $productData[$i]->id; ?>'> <?php echo $productData[$i]->name; ?></a> </h3>

		<div class="span8">
			<p><?php
			$substring = substr($productData[$i]->description, 0,100);
			$pos = strripos($substring, ".");
			echo substr($substring,0,$pos+1) .
			 "<a href='index.php?option=com_category&view=products&id=" . $this->id ."&pid=" . $productData[$i]->id ."'> Read More...</a>"; ?></p>
		</div>
	</div>
		<?php
		}
		?>
	</div>

	<?php
	}
	?>
	<div class='footer'>
		<div class='pagination pagination-centered'>
		<?php
		echo $this->pagination->getListFooter(); ?>
		</div>
	</div>

		<?php
}
?>
</main>
