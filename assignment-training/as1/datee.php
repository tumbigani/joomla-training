<!DOCTYPE html>
<html>
<body>

<?php
$date=date_create(date(d/m/y));
date_add($date,date_interval_create_from_date_string("1 days"));
echo date_format($date,"Ymd");
?>

</body>
</html>
