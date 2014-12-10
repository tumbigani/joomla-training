<!DOCTYPE html>
<html>
<body>

<?php
echo "Array Reverse<br>";
$ary=array("abc"=>"ABC","def"=>"DEF","pqr"=>"PQR");
var_dump(array_reverse($ary));

echo "<hr>";
echo "Array Keys<br>";
$ary2=array("abc"=>"ABC","def"=>"DEF","pqr"=>"PQR");
var_dump(array_keys($ary2));

echo "<hr>";
echo "string reverse";
echo "<br>".strrev("Hello PHP");

echo "<hr>";
echo "Sub string<br>";
echo substr("Hello PHP",6);
?>

</body>
</html>
