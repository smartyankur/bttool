<?php

include_once("lib/utility.class.php");

$pro_id = $_GET["pro_id"];
include("config.php");
$sql="SELECT id , course_title, version from tbl_functional_review WHERE project_id = '".$pro_id."'";
$result = mysql_query($sql) or die (mysql_error());
$count = mysql_num_rows($result);
$ary=array();

if($count==0)
{
  die('Data Not Found');
} else {
	$row = mysql_fetch_array($result);
}

echo json_encode($row);
mysql_close($con);
?> 