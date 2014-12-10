<?php
		$nam="";
		$name=$_POST['name'];

		foreach ($name as $tmp)
		{
				$nam=$nam.$tmp.",";

		}
		$lang="";
		$ckbox=$_POST['area'];
		foreach ($ckbox as $tmp)
		{
				$lang=$lang.$tmp.",";

		}
 	echo "Your Name is :- ".$nam;
	echo "Your comments :- ".$_POST['cmtbox'];
	echo "<br>Gender :- ".$_POST['gen'] ;
	echo "<br>News Letter :- ".$_POST['news'];
	echo "<br>Area of proficiency :- ".$lang;
	echo "<br>Country :-".$_POST['country'];
	echo "<br>Your password :- ".$_POST['password'];


?>
