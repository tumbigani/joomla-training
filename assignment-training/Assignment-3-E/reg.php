<html>
	<head>
	<title> Register Form </title>
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
	function pwd(pwd,cpwd,pwderr)
	{
		var pwdd=document.getElementById(pwd).value
		var cpwdd=document.getElementById(cpwd).value
		if (pwdd != cpwdd)
		{
			submitflag=false;
			document.getElementById(pwderr).innerHTML="<font color='red'>Password Does Not Match</font>";
		}
		else
		{
			document.getElementById(pwderr).innerHTML="";
		}
	}
	function mobileval(x,y)
	{
		var reg=/^[0-9]{10}$/;
		if(reg.test(document.getElementById(x).value)==false)
		{
			submitflag=false;
			document.getElementById(y).innerHTML="<font color='red'>Please Enter Valid Mobile No.</font>";
		}
	    else
		{
			document.getElementById(y).innerHTML="";
		}
	}
	function validation()
	{
		submitflag=true;
		nullvali('txtname','nameerr');
		nullvali('txtuser','usererr');
		nullvali('txtpwd','pwderr');
		nullvali('txtcpwd','cpwderr');
		nullvali('txtmno','mobileerr');
		pwd('txtpwd','txtcpwd','cpwdmatcherr');
		mobileval('txtmno','formaterr');
		return submitflag
	}

	</script>
	</head>
	<body>
		<form method="post" onsubmit="return validation();">
		<table>
			<tr>
				<td> Name : </td>
				<td> <input type="text" name="txtname" id="txtname" onblur="nullvali('txtname','nameerr');"></td>
				<td> <p id="nameerr"></p>
			</tr>
			<tr>
				<td> User : </td>
				<td> <input type="text" name="txtuser" id="txtuser" onblur="nullvali('txtuser','usererr');"></td>
				<td> <p id="usererr"></p>
			</tr>
			<tr>
				<td> Password : </td>
				<td> <input type="password" name="txtpwd" id="txtpwd" onblur="nullvali('txtpwd','pwderr');"></td>
				<td> <p id="pwderr"></p>
			</tr>
			<tr>
				<td> Confirm Password : </td>
				<td> <input type="password" name="txtcpwd" id="txtcpwd" onblur="nullvali('txtcpwd','cpwderr');pwd('txtpwd','txtcpwd','cpwdmatcherr');"></td>
				<td> <p id="cpwderr"></p><p id="cpwdmatcherr"></p>
			</tr>
			<tr>
				<td> Mobile : </td>
				<td> <input type="text" name="txtmno" id="txtmno" onblur="nullvali('txtmno','mobileerr');mobileval('txtmno','formaterr');"></td>
				<td> <p id="mobileerr"></p><p id="formaterr"></p>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="submit" value="Register" >
				<input type="reset" name="reset" value="Reset"></td>
			</tr>
		</table>
		</form>
		<?php

		if (isset($_POST['submit']))
		{
			require_once 'dbconn.class.php';

			$dbb = new  Db;

			$dbb->query("insert into user values('" . uniqid() . "','" . $_POST['txtname'] . "','" . $_POST['txtuser'] . "','" . md5($_POST['txtpwd']) . "','" . $_POST['txtmno'] . "');");
		}
		?>
	</body>
</html>
