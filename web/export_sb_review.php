<?php

include_once("lib/utility.class.php");

include("config.php");

$sql = "SELECT * FROM tbl_sbreview";  

if(isset($_GET["pro_id"]) && $_GET["pro_id"] != 'null') {
	$pro_id = $_GET["pro_id"];
	$sql .= " WHERE project_id = '".$pro_id."'";
}
 
$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0){
  die('Data Not Found');
}



$str = "<table width='50%' border='1' cellspacing='0' cellpadding='0'>
<tr>
  <th>Review Date</th>
  <th>Project Name</th>
  <th>Course Name</th>
  <th>Learning Hours</th>
  <th>Author</th>
  <th>Reviewer</th>
  <th>SB Review Round</th>
  <th>No. of L1 Issues</th>
  <th>No. of L2 Issues</th>
  <th>No. of L3 Issues</th>
  <th>Comment</th>
  <th>SVN Path of the Reviewed SB</th>
  <th>Review Submit Date</th>
</tr>";
$project_name = '';
while($row = mysql_fetch_array($result))
  {
  $project_name = $row['project_name'];
  $str.= "<tr>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['review_date'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['project_name'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['course_name'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['learning_hours'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['author'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['reviewer'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['sb_review_round'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['l1_issues'])."</div>"."</td>"; 
  $str.= "<td>"."<div align=left style="."width:350;height:160;overflow:auto>".htmlentities($row['l2_issues'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['l3_issues'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['comment'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['svn_path_reviewe'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['review_submit_date'])."</div>"."</td>";

  
  }

$str.="</table>";
$obj_utility = new Utility();
if(isset($_GET["pro_id"]) && $_GET["pro_id"] != 'null') {
	$obj_utility->force_download($str, 'xls', str_replace(" ","_", $project_name)."_sb_review");
} else {
	$obj_utility->force_download($str, 'xls', "sb_review");
}
mysql_close($con);
?> 