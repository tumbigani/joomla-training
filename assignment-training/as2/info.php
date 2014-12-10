<?php
echo $_SERVER['REMOTE_ADDR'];
echo "<br>Path of current script execution :- ".__FILE__;
//echo  "<br>".$_SERVER["SCRIPT_NAME"];
$file=$_SERVER["SCRIPT_NAME"];
$ary = Explode('/', $file);
$pfile = $ary[count($ary) - 1];
//echo count($break) - 1
echo "<br>File name of current php script execution:-<i>".$pfile."</i>";
echo "<br>".phpversion();
echo "<br> Server Name :- ".$_SERVER['SERVER_NAME'];
$link=$_SERVER['REQUEST_URI'];

?>
