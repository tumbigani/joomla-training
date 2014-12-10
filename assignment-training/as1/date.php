<?php
echo date("Y-m-d");
echo  "<br>";
echo date("d/m/y");
echo  "<br>";
echo date("m/d/y");
echo "<br>";
echo date("Ymd");
echo "<br>";
$date=date_create(date(d/m/y));
date_add($date,date_interval_create_from_date_string("1 days"));
echo date_format($date,"Ymd");
?>d