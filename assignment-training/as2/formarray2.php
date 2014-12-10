<?php
$nam="";

		$name=$_POST['name'];

		foreach ($name as $tmp)
		{
				$nam=$nam.$tmp.",";

		}

	echo "yes";
	echo $nam;
	?>