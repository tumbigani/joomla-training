<html>
	<head>

	</head>
	<body>
	<form name="form1" method="post">
	<input type="checkbox" name="lagn[]" value="JAVA"/> JAVA <br>
	<input type="checkbox" name="lagn[]" value="PHP"/> PHP<br>
	<input type="checkbox" name="lagn[]" value="ASP"/> ASP<br>
	<input type="checkbox" name="lagn[]" value="VB"/> VB<br>
	<input type="submit" name="submit" id="submit" value="submit">
	</form>
<?php
$name="";
if(isset($_POST['submit']))
{


		if(isset($_POST['lagn']))
		{
			foreach($_POST['lagn'] as $tmp)
			{
					$name=$name.$tmp.",";

			}

		}

		if($name=="")
			echo "nothing selected";
		else
		{
			header("location:chkboxar2.php?language=$name");
		}

}

?>
</body>
</html>