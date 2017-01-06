<?php

include_once("lib/utility.class.php");

$q=$_GET["q"];
$upload_path = './qcfiles/';
include('config.php');

$mode=isset($_REQUEST['mode']) && !empty($_REQUEST['mode']) ? $_REQUEST['mode'] : '';
$filter_name = isset($_REQUEST['filter_name']) ? $_REQUEST['filter_name'] : '';
$filter_value = isset($_REQUEST[str_replace('filter_','',$filter_name)."1"]) ? $_REQUEST[str_replace('filter_','',$filter_name)."1"] : '';
$export = (isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'export') ? true : false;
$start_date = isset($_REQUEST['start_date']) ? $_REQUEST['start_date'] : "";
$end_date = isset($_REQUEST['end_date']) ? $_REQUEST['end_date'] : "";

if($mode=="openbug" && !empty($q)) {

	if(!empty($filter_name) && in_array(str_replace('filter_','',$filter_name),array("bcat","severity","bugstatus","asignee","qc")) && !empty($filter_value)){
		$sql = "SELECT * FROM qcuploadinfo WHERE project = '".$q."' AND ".str_replace('filter_','',$filter_name)." = '".$filter_value."'";
	} else {
		$sql = "SELECT * FROM qcuploadinfo WHERE project = '".$q."'";
	}

	$result = mysql_query($sql);
	$count = mysql_num_rows($result);
	
	if($count==0){
	  die('Data Not Found');
	}
} else if($mode == "admin_export"){

	if(!empty($start_date) && !empty($end_date)) {

		$start_date_ary = explode("-",$start_date);
		$end_date_ary = explode("-",$end_date);

var_dump($start_date_ary);
var_dump($end_date_ary);


		if(count($start_date_ary) == 3 && count($end_date_ary) == 3) {
die("123123123");
			$start_date = $start_date_ary[2]."-".$start_date_ary[1]."-".$start_date_ary[0];
			$end_date = $end_date_ary[2]."-".$end_date_ary[1]."-".$end_date_ary[0];
		}

		if(!empty($q)) {
			echo $sql="SELECT * FROM qcuploadinfo WHERE project='".$q."' AND uploaddate BETWEEN '".$start_date."' AND '".$end_date."'";
		} else {
			echo $sql="SELECT * FROM qcuploadinfo WHERE uploaddate BETWEEN '".$start_date."' AND '".$end_date."'";
		}

		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
		
		if($count==0){
		  die('Data Not Found');
		}
	} else {
		die("Invalid Start Date & End Date");
	}
	
}


$str = "<table width='50%' border='1' cellspacing='0' cellpadding='0'>
<tr>
  <th>ID</th>
  <th>Browser</th>
  <th>Module</th>
  <th>Topic</th>
  <th>Screen</th>
  <th>Bug Cat</th>
  <th>Severity</th>
  <th>Bug Desc</th>
  <th>Bug Status</th>
  <th>Select New Bug Status</th>
  <th>Submit Bug Status</th>
  <th>View</th>
  <th>Upload Date</th>
  <th>Asignee</th>
  <th>QC</th>
  <th>Round</th>
  <th>Edit Bug detail</th>
  <th>Dev Comment</th>
  <th>Dev Name</th>
  <th>Dev Comment Date</th>
  <th>QC Comment</th>
  <th>QC Name</th>
  <th>QC Comment Date</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  $str.= "<tr>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['id'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['browser'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['module'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['topic'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['screen'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['bcat'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['severity'])."</div>"."</td>"; 
  $str.= "<td>"."<div align=left style="."width:350;height:160;overflow:auto>".htmlentities($row['bdr'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['bugstatus'])."</div>"."</td>";

  $str.= "<TD><select id='bug".$row['id']."' size='1'>
  <option value='select' selected>Select</option>
  <option value='open'>Open</option>
  <option value='closed'>Closed</option>
  <option value='hold'>Hold</option>
  <option value='reopened'>Reopened</option>
  <option value='ok as is'>Ok As Is</option>
  </select></TD>
  <TD><input type='button' value='Change Status' onclick='submitbugresponse(".$row['id'].")'></TD>";

  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".'<a href="'.htmlentities($upload_path).htmlentities($row['filepath']).'" title="Your File" target="new">'.$row['filepath'].'</a>'."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['uploaddate'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['asignee'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['qc'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['round'])."</div>"."</td>";

  $str.= "<TD><input type='button' value='Edit' onclick='editbug(".$row['id'].")'></TD>";

  $str.= "<td>"."<div align=center style="."width:130;height:53;overflow:auto>".htmlentities($row['devcomment'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['devresponding'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['devrespdate'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['qccomment'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['qcresponding'])."</div>"."</td>";
  $str.= "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['qcrespdate'])."</div>"."</td>";
  $str.= "</tr>";
  }

$str.="</table>";
$obj_utility = new Utility();
$obj_utility->force_download($str, 'xls', str_replace(" ","_",$q)."_bugs");
  mysql_close($con);
?> 