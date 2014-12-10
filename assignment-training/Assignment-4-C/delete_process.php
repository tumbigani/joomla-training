<?php
require_once 'dbconn.class.php';
$obj = new Db;
$datee = date("Y-m-d");
$obj->query("update employee set enddate='$datee' where id=" . $_GET['id'] . ";");
header('location:empdisp.php');
