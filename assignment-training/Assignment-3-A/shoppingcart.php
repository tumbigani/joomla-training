<?php

session_start();

if (isset($_SESSION['id']))
{
}
else
{
	$_SESSION['id'] = array();
}

if (isset($_SESSION['qty']))
{
}
else
{
	$_SESSION['qty'] = array();
}



function check($txtvalue)
{
	$flag = true;
	$options = array(
				'options' => array( 'min_range' => 1 )
				);

	if (filter_var($txtvalue, FILTER_VALIDATE_INT, $options) !== false)
	{
		$flag = true;
	}
	else
	{
		$flag = false;
	}

	return $flag;
}
?>

<html>
	<head>
		<title> Shopping Cart </title>
	</head>
	<body>
	<div style="margin:auto;">

	<h1> Shopping Cart</h1>

	<form method="post" >
	<?php

	require_once 'dbconn.class.php';
	$dbb = new Db;

	$res = $dbb->qry("select * from product");
	echo "<table border='1'>";
	echo "<tr>";

	while ($ress = mysqli_fetch_row($res)):
	?>
		<td><img src="<?php echo $ress[3]; ?>"  width='150px' height='150px'/>
	 	<h3><?php  echo $ress[1]; ?></h3>
		<h3> Price :- <I> <?php echo  $ress[2];?></I> </h3>

		Enter Qty : <input type="text" name="txt[]"  id="<?php echo $ress[0]; ?>" >
		<br>
			<center>
		<input type="image" name="submit[<?php echo $ress[0]; ?>]" src="cart.png" value="<?php echo $ress[0]; ?>" width='150px' height='50px' >
			</center>
		</td>
		<?php
	endwhile;

	echo "</tr>";
	echo "</table>";

	if (isset($_POST['submit']))
	{
		if (isset($_POST['txt']))
		{
			$qty = implode("", $_POST['txt']);
		}

		$check = check($qty);

		if ($check == true)
		{
			foreach ($_POST['submit'] as $key => $value)
			{
				if (in_array($key, $_SESSION['id'], true))
				{
					$nqty = $_SESSION['qty'][$key] + $qty;
					$_SESSION['qty'][$key] = $nqty;
				}
				else
				{
					array_push($_SESSION['id'], $key);
					$_SESSION['qty'][$key] = $qty;
				}
			}
		}
		else
		{
			echo "<font color=red> Only Number Allowed</font>";
		}
	}
	?>
</form>
	<br>
		</div>
	</body>
</html>
