<html>
<head>
<script type="text/javascript">
function ck()
{
		var cboxes = document.getElementsByName('lagn[]');
		var len=cboxes.length;
		var str='';
			 for (var i=0; i<len; i++) {
        	if(cboxes[i].checked)
        	{
        		str=cboxes[i].value+","+str;
        	}
    }
    	window.open("chkboxjs2.php?language="+str);
	}
</script>
</head>
<body>
<form name="form1" method="post">
<input type="checkbox" name="lagn[]" value="JAVA" id="javaa"/> JAVA <br>
<input type="checkbox" name="lagn[]" value="PHP"/> PHP<br>
<input type="checkbox" name="lagn[]" value="ASP"/> ASP<br>
<input type="checkbox" name="lagn[]" value="VB"/> VB<br>
<input type="submit" name="submit" id="submit" value="submit" onclick="ck()">
</form>
</body>
</html>