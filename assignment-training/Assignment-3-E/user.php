<?php

session_start();

if (isset($_SESSION['userid']))
{
	echo "user found:- ";
	echo $_SESSION['userid'];
}
else
{
	header('location:index.php');
}
