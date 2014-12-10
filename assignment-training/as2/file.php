<html>
<head>
<script type="text/javascript">
submitflag=true;
function filecheck()
{
	var fname = document.getElementById('file').value;
	var exten=fname.substring(fname.lastIndexOf('.') + 1);
	if(exten=="pdf" || exten=="doc")
	{
		submitflag=true;
	}
	else
	{

			alert("wrong file uploaded");
			submitflag=false;
	}
	return submitflag;
}

</script>
</head>
<body>
<form enctype="multipart/form-data" method="post" onsubmit="return filecheck();">
<label> File </label>
<input type="file" name="file" id="file">
<input type="submit" name="submit" value="submit">

<?php
if(isset($_POST['submit']))
{


if ($_FILES["file"]["error"] > 0)
{
  echo "error: " . $_FILES["file"]["error"] . "<br>";
}
else
{

      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"]);


  echo "<br>File Upload Successfully: " . $_FILES["file"]["name"] . "<br>";

}
}

?>
</form>
</body>
</html>