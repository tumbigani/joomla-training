<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$productData = $this->productData;
$input = JFactory::getApplication()->input;
$itemId = $input->getInt('Itemid');
?>
<ul class="pager">

	<?php
	if ($this->nextshow)
	{
	?>
		<li class="next"><a href="index.php?option=com_category&view=products&id=<?php echo $this->id?>&Itemid=<?php echo $itemId;?>&pid=<?php echo $this->pid ?>">Next </a></li>
	<?php
	}

	if ($this->prev >= 0)
	{
		$this->pid = $this->idArray[$this->prev];
	}

	if ($this->prevshow)
	{
	?>
		<li class="previous"><a href="index.php?option=com_category&view=products&id=<?php echo $this->id?>&Itemid=<?php echo $itemId;?>&pid=<?php echo $this->pid ?>">Previous</a></li>
	<?php
	}
	?>
</ul>

<?php

for ($i = 0; $i < count($productData); $i++)
{
	?>
	<div class="row-fluid">
	<div class='span5'>
		<h1><?php echo $productData[$i]->name; ?> </h1>
		<?php
		$ImageSrc = JURI::root() . '/media/com_category/images/thumbs/' . $productData[$i]->image;
		$modelImageSrc = JURI::root() . '/media/com_category/images/' . $productData[$i]->orignal;
		?>
		<img src="<?php echo $ImageSrc; ?>" class='img-rounded'  href="#myModal" data-toggle="modal" id = "<?php echo $productData[$i]->default?>">

				<!-- Slide Show Modal -->
				<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">

						<div id="myCarousel" class="carousel slide">
							<ol class="carousel-indicators">
							<?php
							for ($j = 0; $j < count($productData[$i]->imagearray); $j++)
							{
								?>
								<li data-target="#myCarousel" data-slide-to="<?php echo $j;?>" ></li>
							<?php
							}
							?>
							</ol>
							<!-- Carousel items -->
							<div class="carousel-inner">
							<?php

							for ($j = 0; $j < count($productData[$i]->orignalarray); $j++)
							{
							?>
								<div class="item" id ="<?php echo $productData[$i]->orignalarray[$j]?>" align='center'>
								<?php
									$additional = JURI::root() . '/media/com_category/images/' . $productData[$i]->orignalarray[$j];
									?>

									<img src="<?php echo $additional; ?>" class ="model" >
									</div>
							<?php
							}
							?>

							</div>
							<!-- Carousel nav -->
							<?php
							if ($this->slide == 1)
							{
							?>
								<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
								<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
							<?php
							}
							?>
							</div>
						</div>
					<div class="modal-footer">
					</div>
				</div>
	<div class= 'span12'>
	<?php
			for ($j = 0; $j < count($productData[$i]->imagearray); $j++)
			{
				$additional = JURI::root() . '/media/com_category/images/thumbs/' . $productData[$i]->imagearray[$j];
				?>

				<img src="<?php echo $additional; ?>" class='img-polaroid' id = "<?php echo $productData[$i]->orignalarray[$j]?>">

			<?php
			}
			?>

	</div>
</div>
	<div class='span6'>
		<h3> From :-  <a href="index.php?option=com_category&view=categories&Itemid=<?php echo $itemId;?>&id=<?php echo $this->id;?>" ><?php echo $productData[$i]->category_title; ?> </a></h3>
		 <?php echo $productData[$i]->description;?>
	</div>
</div>

	<?php
}
?>

