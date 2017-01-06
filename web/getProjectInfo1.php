<?php

include_once("lib/utility.class.php");

$q=$_GET["q"];
$mode = (isset($_REQUEST["mode"]) && $_REQUEST["mode"]) ? $_REQUEST["mode"] : "" ;

include('config.php');


if($mode == "developers") {
	$obj_utility = new Utility();
	$sql="SELECT dev1, dev2, dev3, dev4, dev5, dev6, dev7, dev8, dev9, dev10, dev11, dev12 from projectmaster WHERE projectname = '".$q."'";
	//echo $sql;
	$result = mysql_query($sql);
	$count = mysql_num_rows($result);
	$ary=array();

	if($count==0)
	{
	  die('Data Not Found');
	} else {
		$row = mysql_fetch_assoc($result);
		foreach($row as $developer){
			if(!empty($developer) && $developer != "NA") {
				$ary[$developer] = $developer;
			}
		}
	}
	echo $obj_utility->php_to_js($ary);
}else if($mode == "testers") {
	$obj_utility = new Utility();
	$sql="SELECT tester1, tester2, tester3, tester4, tester5, tester6, tester7, tester8 from projectmaster WHERE projectname = '".$q."'";
	//echo $sql;
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