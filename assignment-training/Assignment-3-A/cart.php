<?php

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
	<div>
	<h1> Your Shopping Cart</h1>

	<br>
	</div>
	<?php
	if (isset($_POST['delete']))
	{
		foreach ($_POST['delete'] as $key => $value)
		{
			$tmp = array_search($key, $_SESSION['id']);
			$tmp2 = array_search($key, $_SESSION['qty']);
			unset($_SESSION['id'][$tmp]);
			unset($_SESSION['qty'][$tmp2]);
		}
	}

	$edit = "";

if (isset($_POST['edit']))
{
	foreach ($_POST['edit'] as $key => $value)
	{
		$edit = $key;
	}
}

$txtvalue = "";
/** Function for check nullvalue and negetive value enter in textbox*/
function checkqty($txtvalue)
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

if (isset($_POST['update']))
{
	$txtvalue = implode("", $_POST['txt']);
	$checkqty = checkqty($txtvalue);

	if ($checkqty == true)
	{
		foreach ($_POST['update'] as $key => $value)
		{
			$pos = array_search($key, $_SESSION['qty']);
			$_SESSION['qty'][$pos] = $txtvalue;
		}
	}
	else
	{
		echo "<font color=red> Only Number Allowed</font>";
	}
}

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
	<tr>

<?php
$quantity = "";

foreach ($_SESSION['id'] as $key)
{
	$res = $dbb -> qry("select * from product where id=" . $key . ";");

	while ($ress = mysqli_fetch_row($res)):
		?>
		<td><img src="<?php echo $ress[3]; ?>" width='150px' height='150px'/>
		<h3><?php echo $ress[1]; ?></h3>
		<h3>Price :-<?php echo $ress[2];?> </h3>
		<?php

		foreach ($_SESSION['qty'] as $qtyky => $value)
		{
			if ($key == $qtyky)
			{
				if ($key == $edit)
				{
					$quantity = $value;
					?>
					<input type="text" value="<?php echo $value; ?>" name="txt[]">
					<input type="image" name="update[<?php echo $quantity; ?>]" value=<?php echo $quantity; ?> src="updt.png" width='50px' height='50px'>
					<?php
				}
				else
				{
					echo "Qty :- " . $value;
					$quantity = $value;
				}
			}
		}
		?>
			<input type="image" value=<?php echo $key; ?> src='edit.png' name="edit[<?php echo $key; ?>]" width="40px" height="30px">
		<?php
		echo "<h3> Amount :-  " . $ress[2] * $quantity . "</h3>";
		?>
			<center>
		<input type="image" name="delete[<?php echo $ress[0];?>]" src="del2.png" value=<?php echo $ress[0];?> width='100px' height='50px'>
			</center>
		<?php
	endwhile;
}
}
?>
			</td>
		</tr>
	</table>
</form>
</body>
</html>
