<html>
<?php
require_once 'dbconn.class.php';
$obj = new Db;
?>
<head>
<script type="text/javascript">
	var submitflag=true;
	function nullvali(txtvalue,nameerr)
	{
		var txt=document.getElementById(txtvalue).value
		var sp = txt.search(" ");
		if (txt.length==0 || sp==0)
		{
			submitflag=false;
			document.getElementById(nameerr).innerHTML="<font color='red'>Enter the Value</font>";
		}
		else
		{
			document.getElementById(nameerr).innerHTML="";
		}
	}
	function numberval(txtsal,noerr)
	{
		var reg=/^[0-9]*$/;
		if (reg.test(document.getElementById(txtsal).value) == false)
		{
			submitflag=false;
			document.getElementById(noerr).innerHTML="<font color='red'>Enter Valid Salary</font>";
		}
		else
		{
				document.getElementById(noerr).innerHTML="";
		}
	}
	function checkdata()
	{
		var jdate=document.getElementById('date').value;

		var matches = /^([0-9]{4})\-([0-9]{2})\-([0-9]{2})$/.exec(jdate);
		if (matches == null)
		{
			submitflag=false;
			alert("enter valid date format :YYYY-MM-DD");
		}
	}
	function validation()
	{
		submitflag=true;
		nullvali('txtname','nameerr');
		nullvali('txtcity','cityerr');
		nullvali('txtphone','phoneerr');
		nullvali('date','dateerr');
		nullvali('txtsal','salerr');
		numberval('txtsal','noerr');
		return submitflag
	}
	</script>
	</head>
<?php

if (isset($_GET['uid']))
{
	require_once 'dbconn.class.php';
	$obj = new Db;
	$res = $obj->selquery("select * from employee where id=" . $_GET['uid'] . ";");
	?>
	<form method="post" onsubmit="return validation();">
	<table>
		<?php
	while ($ress = mysqli_fetch_row($res)):
	?>
			<tr>
				<td> Employe Name : </td>
				<td> <input type="text" name="txtname" id="txtname" value="<?php echo $ress[1]; ?>" onblur="nullvali('txtname','nameerr');"></td>
				<td> <p id="nameerr"></p>
			</tr>
			<tr>
				<td> City : </td>
				<td> <input type="text" value="<?php echo $ress[2]; ?>" name="txtcity" id="txtcity"  onblur="nullvali('txtcity','cityerr');"></td>
				<td> <p id="cityerr"></p>
			</tr>
			<tr>
				<td> Phone : </td>
				<td> <input type="text" name="txtphone" value="<?php echo $ress[3]; ?>" id="txtphone" onblur="nullvali('txtphone','phoneerr');"></td>
				<td> <p id="phoneerr"></p>
			</tr>
			<tr>
				<td> Joining Data : </td>
				<td> <input type="text" name="txtdatee" value="<?php echo $ress[4]; ?>" id="date">
				<td> <p id="dateerr"></p></td>
			</tr>
			<tr>
				<td> Salary : </td>
				<td> <input type="text" name="txtsal" value="<?php echo $ress[5]; ?>" id="txtsal" onblur="nullvali('txtsal','salerr');numberval('txtsal','noerr');"></td>
				<td> <p id="salerr"></p><p id="noerr"></p>
			</tr>
<?php
	endwhile;

?>
</table>
<input type="submit" name="submit" value="Update" onclick="checkdata();" >
<input type="reset" name="reset" value="Reset">
</form></html>
<?php
}
if (isset($_POST['submit']))
{
	$obj->query("update employee set name='" . $_POST['txtname'] . "',city='" . $_POST['txtcity'] . "',phone='" . $_POST['txtphone'] . "',join_date='" . $_POST['txtdatee'] . "',salary=" . $_POST['txtsal'] . " where id=" . $_GET['uid'] . ";");
	header('location:empdisp.php');
}
