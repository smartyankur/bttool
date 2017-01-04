<?php
include("config.php");

if(isset($_GET['fun'])) {
	$q = $_GET["fun"];
	$selectDEV  = "SELECT DISTINCT username FROM login WHERE dept='Content' AND role like '%".$q."%' ORDER BY username ASC";
	$queryDEV   = mysql_query($selectDEV);
	$numrowsDEV = mysql_num_rows($queryDEV);
	$arr = array();
	if($numrowsDEV==0)
	{
	  die('Data Not Found');
	} else {
		while($row = mysql_fetch_array($queryDEV)) {
			$arr[] = $row;
		}
	}
	echo json_encode($arr);
} 

mysql_close($con);
?> 