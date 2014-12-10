<?php
session_start();
echo "yes";
if($_SESSION['name'])
{
	echo $_SESSION['name'];
}
else
{
	echo "no";
}
?>