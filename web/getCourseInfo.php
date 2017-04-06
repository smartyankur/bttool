<?php

//include_once("lib/utility.class.php");

$q = $_GET["q"];
/* @saurav Change here to fetch data using project_id for both developer and tester */
$pro_id = $_GET["pro_id"];

include("config.php");

//$obj_utility = new Utility();
$sql="SELECT id, course_title from tbl_functional_review WHERE project_id = '".$pro_id."'";
$result = mysql_query($sql) or die (mysql_error());
$count = mysql_num_rows($result);
$ary=array();

if($count==0)
{
  die('Data Not Found');
} else {
	while($row = mysql_fetch_array($result)){
	    if(!empty($row['course_title']) && $row['course_title'] != "NA") {
			$ary[$row['id']."-".$row['course_title']] = $row['id']."-".$row['course_title'];
		}
	}
}

echo json_encode($ary);
mysql_close($con);
?> 