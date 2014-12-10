<html>
	<head>
		<title>Log In</title>
		<script type="text/javascript">

	var submitflag=true;
	function nullvali(txtvalue,err)
	{
		var txt=document.getElementById(txtvalue).value
		var sp = txt.search(" ");
		if (txt.length==0 || sp==0)
		{
			submitflag=false;
			document.getElementById(err).innerHTML="<font color='red'>Enter the Value</font>";
		}
		else
		{
			document.getElementById(err).innerHTML="";
		}
	}
	function vali()
	{
		nullvali('uname','unameerr');
		nullvali('pwd','pwderr');
		return submitflag;
	}
	</script>
	</head>
	<body>
		<form method="post" onsubmit="return vali();">
			<table>
				<tr>
					<td> User Name </td>
					<td> <input type="text" name="uname" id="uname" onblur="nullvali('uname','unameerr');"></td>
					<td> <p id="unameerr">
				</tr>
				<tr>
					<td> Password </td>
					<td> <input type="password" name="pwd" id="pwd" onblur="nullvali('pwd','pwderr');"></td>
					<td><p id="pwderr"></p>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="submit" value="Log In">
					<a href="reg.php">Create New User</td>
				</tr>
			</table>
		</form>
		<?php

		if (isset($_POST['submit']))
		{
			session_start();
			require_once 'dbconn.class.php';
			$dbb = new  Db;
			$res = $dbb->selquery("select * from user where user_name='" . $_POST['uname'] . "' and pwd='" . md5($_POST['pwd']) . "';");
			$cnt = mysqli_num_rows($res);

			if ($cnt == 0)
			{
				echo "User Not Found";
			}
			else
			{
				echo "User  Found";

				while ($ress = mysqli_fetch_row($res)):
					$_SESSION['userid'] = $ress[0];
				endwhile;

				header('location:user.php');
			}
		}
		?>
	</body>
</html>
