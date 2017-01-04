<?php

$id = $_POST['id'];
$key = $_POST['key'];
$value = $_POST['value'];
include("config.php");
$mydate = date('Y-m-d h:i:s', time());

$query = "update tbl_functional_review";
if($key == "rejectCourse")
$query .=  " set reject_course = $value, statusupdate = '".$mydate."' where id = $id";
else if($key == "phaseClosed")
$query .=  " set phase_closed = $value, statusupdate = '".$mydate."' where id = $id";
else if($key == "outSourced")
$query .=  " set out_sourced = $value, statusupdate = '".$mydate."' where id = $id";
mysql_query($query, $con);
mysql_close($con);

?> 