<html>
<head>
</head>
<body>
<form name="frm" method="post" action="formarray2.php" >
<table>
<tr>
	<td> First Name  </td>
	<td> Middle Name  </td>
	<td> Last Name  </td>
</tr>
<tr>
	<td> <input type="text" name="name[]" /></td>
	<td> <input type="text" name="name[]"  /></td>
	<td> <input type="text" name="name[]"  /></td>
</tr>
</table>
<input type="submit" value="submit" name="submit">
<?php


?>
</form></body></html>