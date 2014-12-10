<html>
	<head>
		<title>Database Connection</title>
	</head>
	<body>
<form method="post">
<table>
	<tr>
		<td>Host Name :-</td>
		<td><input type="text" name="hostname" required></td>
	</tr>
	<tr>
	 	<td>User Name :- </td>
		<td><input type="text" name="username" required></td>
	</tr>
	<tr>
		<td>Password :- </td>
	 	<td><input type="password" name="pwd" required></td>
	</tr>
	<tr>
		<td>Database Name :- </td>
	 	<td><input type="text" name="dbname" required></td>
	</tr>
	</table>
		<input type="submit" name="submit" value="Create File"><br>
		Connect Existing File<br>
		</form>
		<form method="post">
		<input type="submit" name="submit2" value="Connect">
		</form>

<?php

$filename = 'config/config.php';

if (isset($_POST['submit']))
{
	$handle = fopen($filename, 'w') or die('Cannot open file:  ' . $filename);
	$data = $_POST['hostname'] . "," .
	$_POST['username'] . "," .
	$_POST['pwd'] . "," .
	$_POST['dbname'];
	fwrite($handle, $data);
	echo "file Created";
}

if (isset($_POST['submit2']))
{
	$lines = file($filename);
	$conary = explode(",", $lines[0]);
	require_once 'dbconn.class.php';
	$dbb = new Db;
	$dbb->connect($conary[0], $conary[1], $conary[2], $conary[3]);
}

?>
</form>
</body>
</html>
