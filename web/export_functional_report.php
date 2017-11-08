<?php
include_once("lib/utility.class.php");
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include("config.php");

if(isset($_GET["pro_id"])) {
	$pro_id = $_GET["pro_id"];
}
$fdate = isset($_GET["fdate"]) ? strtotime($_GET["fdate"]) : '';
$tdate = isset($_GET["tdate"]) ? strtotime("+1 Day", strtotime($_GET["tdate"])) : ''; 

$sql = "SELECT * FROM blobt";

if( !empty($pro_id)){
  $sql .= " where project_id=$pro_id";
} else if( !empty($fdate) && !empty($tdate) ){
  $sql .= " where creationDate >= $fdate and creationDate <= $tdate";
}

try {
	$retval = mysql_query($sql, $con);
	$results = mysql_num_rows($retval);
} catch (Exception $ex) {
	echo($ex->getMessage());
}
$str = "<table width='100%' border='1' cellspacing='0' cellpadding='0'>
		<tr>
			<th>ID</th>
			<th>Project</th>
			<th>Phase</th>
			<th>Module Name</th>
			<th>Screen Details</th>
			<th>Reviewee</th>
			<th>Sevirity</th>
			<th>Cat</th>
			<th>SubCat</th>
			<th>Bug</th>
			<th>Reviewer</th>
			<th>Status</th>
			<th>Last Comment</th>
			<th>Creation Date</th>
		</tr>";
if($results > 0) {
	
	while($row = mysql_fetch_assoc($retval)) {
		$str .= "<tr>";
		$str .= "<td>".$row['id']."</td>";
		$str .= "<td>".$row['project']."</td>";
		$str .= "<td>".$row['phase']."</td>";
		$str .= "<td>".$row['module']."</td>";
		$str .= "<td>".$row['screen']."</td>";
		$str .= "<td>".$row['reviewee']."</td>";
		$str .= "<td>".$row['severity']."</td>";
		$str .= "<td>".$row['cat']."</td>";
		$str .= "<td>".$row['subcat']."</td>";
		$str .= "<td>".$row['desc1']."</td>";
		$str .= "<td>".$row['reviewer']."</td>";
		$str .= "<td>".$row['status']."</td>";
		$str .= "<td>".$row['comment']."</td>";
		$str .= "<td>".(!empty($row['creationDate']) ? date("Y-m-d H:i:s", $row['creationDate']) : 'N/A')."</td>";
		$str .= "</tr>";
	}
	$str .= "</table>";
}
$obj_utility = new Utility();
$obj_utility->force_download($str, 'xls', str_replace(" ","_","functional_report"));
mysql_close($con);
?> 