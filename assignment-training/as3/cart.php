<?php session_start();

if (isset($_SESSION['id']))
{
}
else
{
	$_SESSION['id'] = array();
}
?>
<html>
	<head>
		<title> Shopping Cart </title>
	</head>
	<body>


	<div style="margin:auto;">
	<h1> Your Shopping Cart</h1>
	<h3><a href="shoppingcart.php"> Shopping cart </a></h3>
	<br>


	</div>
	<?php
	$id = "";

	if (isset($_GET['cart']))
	{
		$id = $_GET['cart'];
		array_push($_SESSION['id'], $id);
	}

	if (isset($_SESSION['id']))
	{
		if (count($_SESSION['id']) == 0)
		{
			echo "Your shopping cart is empty";
		}
		else
		{
			require_once 'dbconn.class.php';
			$dbb = new Db;


?>
		<form method="post">
		<table border="1">
		<th>Item </th>
		<th> Item Name  </th>
		<th> Price  </th>
		<th>Action  </th>

<?php
		foreach ($_SESSION['id'] as $key)
		{
			$res = $dbb -> qry("select * from product where id=" . $key . ";");
			$amt = 0;

			while ($ress = mysqli_fetch_row($res))
			{
				$amt = $amt + $ress[2];
				echo "<tr>";
				echo "<td><img src='" . $ress[3] . "' width='150px' height='150px'/></td>";
				echo "<td><p>" . $ress[1] . "</p></td>";
				echo "<td><p> " . $ress[2] . " </p></td>";
				echo "<td><a href='shoppingcart.php?remove=" . $ress[0] . "' > <img src='del.png' width='50px' height='50px'> </a></td>";
				echo "</tr>";
			}
		}

		echo "</table>";
		echo "</form>";
		echo "<a href='order.php?amt=" . $amt . "'>Order Now </a>";
		}
	}

	?>
</html>
	</body>
