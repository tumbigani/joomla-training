<html>
<head>
</head>
<body>
<?php
$ary=array("abc"=>"ABC","def"=>"DEF","pqr"=>"PQR","xyz"=>"XYZ");
?>
<table border="1">
<th> Key </th>
<th> Value </th>
<?php
foreach($ary as $x=>$x_value) {
	echo "<tr>";
	echo "<td>".$x."</td>";
	echo "<td>".$x_value."</td>";
	echo "</tr>";
}
?>
</table>
</body>
</html>