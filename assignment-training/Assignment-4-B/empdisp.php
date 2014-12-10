<html>
	<head>
	<title> Display Employe Detail </title>
	</head>
	<?php

	require_once 'dbconn.class.php';
	$obj = new Db;
	$res = $obj->selquery("select * from employee where enddate='null';");
	?>
	<body>
		<form method="post">
		<table border='1'>
		<th> Employe Name </th>
		<th> City </th>
		<th> Phone </th>
		<th> Joining Date </th>
		<th> Salary </th>
		<?php

		while ($ress = mysqli_fetch_row($res))
		{
			?>
			<tr>
				<td><?php echo $ress[1]; ?></td>
				<td><?php echo $ress[2]; ?></td>
				<td><?php echo $ress[3]; ?></td>
				<td><?php echo $ress[4]; ?></td>
				<td><?php echo $ress[5]; ?></td>
			</tr>
			<?php
		}
?>
		</table>
		<a href="empadd.php"> Add Employe Detail </a>
		</form>
		<?php

		?>
	</body>
</html>
