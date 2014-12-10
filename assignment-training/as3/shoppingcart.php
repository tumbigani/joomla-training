<?php session_start();

if (isset($_SESSION['id']))
{
}
else
{
	$_SESSION['id'] = array();
}

if (isset($_GET['remove']))
{
	$remove = $_GET['remove'];
	$key = array_search($remove, $_SESSION['id']);
	unset($_SESSION['id'][$key]);

}
?>
<html>
	<head>
		<title> Shopping Cart </title>
	</head>
	<body>
	<div style="margin:auto;">

	<h1> Shopping Cart</h1>
	<a href="cart.php"><img src="vw.png" width='150px' height="50px"> </a>
	<?php

	require_once 'dbconn.class.php';
	$dbb = new Db;

	$res = $dbb->qry("select * from product");
	echo "<table border='1'>";

	while ($ress = mysqli_fetch_row($res))
	{
		if (in_array($ress[0], $_SESSION['id']))
		{
		}
		else
		{
		echo "<tr>";
		echo "<td><img src='" . $ress[3] . "' width='250px' height='250px'/>";
		echo "<p>" . $ress[1] . "</p>";
		echo "<h3> Price :- " . $ress[2] . " </h3>";
		echo "<a href='cart.php?cart=" . $ress[0] . "''><img src='cart.png' width='150px'> </a>";
		echo "</td>";
		echo "</tr>";
		}
	}

	echo "</table>";
	?>

	<br>
		</div>
	</body>
</html>
