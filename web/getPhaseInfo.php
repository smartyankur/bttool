<?php

//include_once("lib/utility.class.php");

$q = explode("-", $_GET["q"]);


include("config.php");

//$obj_utility = new Utility();
$sql="SELECT version, start_date  from tbl_functional_review WHERE id = '".$q[0]."'";
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