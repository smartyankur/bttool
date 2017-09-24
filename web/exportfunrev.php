<?php

include_once("lib/utility.class.php");

$q = $_GET["q"];
$pro_id = $_GET["pro_id"];
$searchBC = $_GET['searchBC'];
$searchBS = $_GET['searchBS'];
//$upload_path = './qcfiles/';
include("config.php");
	if(!empty($q)){
		$sql = "SELECT * FROM blobt WHERE project_id = ".$pro_id;
		if( !empty($searchBC) && $searchBC != "select" && $searchBC != "all"){
			$sql .= " and cat='".$searchBC."'";
		}

		if( !empty($searchBS) && ($searchBS != "select") && ($searchBS != "all") ){
			$sql .= " and status='".$searchBS."'";
		}

		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
		
		if($count==0){
		  die('Data Not Found');
		}
	} 
	



$str = "<table width='50%' border='1' cellspacing='0' cellpadding='0'>
<tr>
  <th>Id</th>
  <th>Project</th>
  <th>Phase</th>
  <th>Module Name</th>
  <th>Screen Details</th>
  <th>Reviewee</th>
  <th>Cat</th>
  <th>SubCat</th>
  <th>Bug</th>
  <th>Reviewer</th>
  <th>Severity</th>
  <th>Status</th>
  <th>Last Comment</th>
  <th>Creation Date</th>
 </tr>";

while($row = mysql_fetch_array($result))
  {
  $date = !empty($row['creationDate']) ? date("Y-m-d H:i:s", $row['creationDate']) : "N/A";
  $str.= "<tr>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['id'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['project'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['phase'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['module'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['screen'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['reviewee'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['cat'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['subcat'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['desc1'])."</div>"."</td>";
  $str.= "<td>"."<div align=left style="."width:100;height:160;overflow:auto>".htmlentities($row['reviewer'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['severity'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['status'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['comment'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".$date."</div>"."</td>";
  $str.= "</tr>";
  }

$str.="</table>";
$obj_utility = new Utility();
$obj_utility->force_download($str, 'xls', str_replace(" ","_",$q)."_funrev");
mysql_close($con);
?> 