<?php
$str="h,a,l,l,o,";
echo $str;
//$ary=array();
$ary=array("a","b");
foreach(explode(",",$str,-1) as $tmp)
{
		echo $tmp;
 }?>
