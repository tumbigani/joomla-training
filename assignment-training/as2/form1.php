<html>
<head>
<script type="text/javascript">
var submitfalg=true;
function val(x)
{
	var name=document.getElementById(x).value;
	if(name=="")
	{
		submitfalg=false;

		alert("enter first name");
	}
return submitfalg;
}
function call()
{

	window.open("forminter.php");
}
function check()
{
	return val("fname");

}
</script>
</head>
<body>
<form name="frm" method="post" action="form2.php" onsubmit="return check();">
<table>
<tr>
	<td> First Name  </td>
	<td> Middle Name  </td>
	<td> Last Name  </td>
</tr>
<tr>
	<td> <input type="text" name="name[]" id="fname"/></td>
	<td> <input type="text" name="name[]" id="mname"/></td>
	<td> <input type="text" name="name[]" id="lname"/></td>
</tr>
<tr>
<td>
	Your Comments
</td>
<td>
<textarea rows="3" cols="24" name="cmtbox"> </textarea>
</td>

</tr>
<tr>
	<td> Gender  </td>
	<td> <input type="radio" name="gen" value="Male">Male
		<input type="radio" name="gen" value="Female"> Female  </td>
</tr>
<tr>
	<td> Are You interested in <br>our Newsletter  </td>
	<td> <input type="radio" name="news" value="yes">Yes
		<input type="radio" name="news" value="no"> No  </td>
</tr>
<tr>
<td> Area of proficiency</td>
	<td> <input type="checkbox" name="area[]" value="java">java<br>
	<input type="checkbox" name="area[]" value="Web Development Zone">Web Development Zone<br>
	<input type="checkbox" name="area[]" value="Visula basic">Visual basic<br>
	<input type="checkbox" name="area[]" value=".NET">.NET<br>
	<input type="checkbox" name="area[]" value="C#">C#<br>
	</td>
</tr>
<tr>
	<td>  Country</td>
	<td>  <select name="country">
			<option value="india"> India </option>
			<option value="australia"> Australia </option>
			<option value="burma"> Burma </option>
			<option value="china"> China </option>
			<option value="africa"> Africa </option>
	</select></td>
</tr>
<tr>
	<td><input type="hidden" name="password" value="123456"></td>
</tr>
</table>
<input type="button" name="review" value="Review">
<br>
<input type="image" name="submit" value="Submit" src="submit.png" width="75px" height="30px">
<br>
<input type="button" name="btn" value="pass" onclick="call();">
</form>


<?php

	session_start();
	$nam="";
		$name=$_POST['name'];

		foreach ($name as $tmp)
		{
				$nam=$nam.$tmp.",";

		}
		$_SESSION['name']=$nam;
		$lang="";
		$ckbox=$_POST['area'];
		foreach ($ckbox as $tmp)
		{
				$lang=$lang.$tmp.",";

		}
		$_SESSION['lang']   = $lang;
		$_SESSION['cmt']    = $_POST['cmtbox'];
		$_SESSION['gender'] = $_POST['gen'];
		$_SESSION['news']   = $_POST['news'];
		$_SESSION['cntry']  = $_POST['country'];
		//header("location:forminter.php");


?>

</body>
</html>