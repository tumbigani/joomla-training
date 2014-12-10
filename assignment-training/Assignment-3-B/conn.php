<?php

require_once 'dbconn.class.php';

$dbb = new  Db;
?>
<html>
	<head> <title>Database Connection</title> </head>
	<body>
<form method="post">
<table>
	<tr>
		<td>Host Name :-</td>
		<td><input type="text" name="hostname"></td>
	</tr>
	<tr>
	 	<td>User Name :- </td>
		<td><input type="text" name="username"></td>
	</tr>
	<tr>
		<td>Password :- </td>
	 	<td><input type="password" name="pwd"></td>
	</tr>
	<tr>
		<td>Database Name :- </td>
	 	<td><input type="text" name="dbname"></td>
	</tr>
	<tr>
		<td><input type="submit" name="submit" value="submit"></td>
		<td><input type="reset" name="reset" value="Reset"></td>
	</tr>
 </table>

</form>
 <?php
if (isset($_POST['submit']))
{
	$dbb->connect($_POST['hostname'],$_POST['username'],$_POST['pwd'],$_POST['dbname']);
}
?>
</body>
</html>
