<?php

include_once("lib/utility.class.php");

$q = $_GET["q"];
/* @saurav Change here to fetch data using project_id for both developer and tester */
$pro_id = $_GET["pro_id"];
$mode = (isset($_REQUEST["mode"]) && $_REQUEST["mode"]) ? $_REQUEST["mode"] : "" ;

include("config.php");


if($mode == "developers") {
	$obj_utility = new Utility();
	$cols = [];
    foreach (range(1,25) as $key => $value) {
      array_push($cols, "dev".$value);
    }
    $join_cols = join(",",$cols);
    $sql="SELECT ".$join_cols." from projectmaster WHERE pindatabaseid = '".$pro_id."'";
	
	$result = mysql_query($sql);
	$count = mysql_num_rows($result);
	$ary=array();

	if($count==0)
	{
	  die('Data Not Found');
	} else {
		$row = mysql_fetch_assoc($result);
		$row = array_unique($row);
		foreach($row as $developer){
			if(!empty($developer) && $developer != "NA"  && $developer != "Select") {
				$ary[$developer] = $developer;
			}
		}
	}
	echo $obj_utility->php_to_js($ary);
} else if($mode == "testers") {
	$obj_utility = new Utility();
	$sql="SELECT tester1, tester2, tester3, tester4, tester5, tester6, tester7, tester8 from projectmaster WHERE pindatabaseid = '".$pro_id."'";
    $result = mysql_query($sql);
	$count = mysql_num_rows($result);
	$ary=array();

	if($count==0)
	{
	  die('Data Not Found');
	} else {
		$row = mysql_fetch_assoc($result);
		foreach($row as $tester){
			if(!empty($tester) && $tester != "NA") {
				$ary[$tester] = $tester;
			}
		}
	}
	echo $obj_utility->php_to_js($ary);
}

mysql_close($con);
?> 