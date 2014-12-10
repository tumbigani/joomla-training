<html>
	<head>
	<title> Display Employe Detail </title>
	<script type="text/javascript">
	function confirmcheck()
	{
		if (confirm("Are You Sure?") == true)
		{
			return true;
		}
		else
		{
		    return false;
		}
	}
</script>
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
		<th> Edit </th>
		<th> Delete </th>
		<?php

		while ($ress = mysqli_fetch_row($res)):
		?>
			<tr>
				<td><?php echo $ress[1]; ?></td>
				<td><?php echo $ress[2]; ?></td>
				<td><?php echo $ress[3]; ?></td>
				<td><?php echo $ress[4]; ?></td>
				<td><?php echo $ress[5]; ?></td>
				<td> <a href="update_process.php?uid=<?php echo $ress[0]; ?>">Modify </a></td>
				<td> <a href="delete_process.php?id=<?php echo $ress[0]; ?>" onclick="return confirmcheck()">Delete </a></td>
				</tr>
			<?php
		endwhile;
?>
		</table>
		<a href="empadd.php"> Add Employe Detail </a>
		</form>
		<?php

		?>
	</body>
</html>

