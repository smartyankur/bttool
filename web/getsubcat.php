<?php
include("config.php");

if(isset($_GET['cat'])) {
	$q = $_GET["cat"];
	$sql="SELECT id, category from tbl_category WHERE parent_id = '".$q."'";
	$result = mysql_query($sql) or die (mysql_error());
	$count = mysql_num_rows($result);
	$arr = array();
	if($count==0)
	{
	  die('Data Not Found');
	} else {
		while($row = mysql_fetch_array($result)) {
			$arr[] = $row;
		}
	}
	echo json_encode($arr);
	
} else if(isset($_GET['subcat'])){
	$sql="SELECT severity from tbl_category WHERE id = '".$_GET['subcat']."'";
	$result = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($result);
	$sev = trim($row['severity']);
	echo $sev;
}

mysql_close($con);
?> 