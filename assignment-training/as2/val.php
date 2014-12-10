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
		alert("null");
	}

}
function check()
{
	val("name1");
	val("name2");
}
</script>
</head>
<body>
<form name="frm" method="post" onsubmit="return check();">
<input type="text" name="name" id="name1" />
<input type="text" name="name" id="name2" />
<input type="submit" value="submit" name="submit">
</form></body></html>