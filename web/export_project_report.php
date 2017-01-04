<?php
include_once("lib/utility.class.php");
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include("config.php");

if(isset($_GET["pro_id"])) {
	$pro_id = $_GET["pro_id"];
} else {
	die('select project name');
}

$sql = "SELECT project_name, version, phase_closed, out_sourced, id, course_level, reject_course, pagecount FROM tbl_functional_review"; 
if(isset($_GET["pro_id"])) {
	$sql .= " WHERE project_id = ".$pro_id;
}

try {
	$retval = mysql_query($sql, $con);
	$results = mysql_num_rows($retval);
} catch (Exception $ex) {
	echo($ex->getMessage());
}
$project_name = null;	
if($results == 0){
  die('No '.$issuetype.' item was found with this project name.');
} else {
	$tmp = array();
	$screen_count = array();
	while($row = mysql_fetch_assoc($retval)) {
		$project_name = $row['project_name'];
		$sql1 = "select count(bugstatus) as bug_status_count, bugstatus, bcat, severity from qcuploadinfo where chd_id = '".$row['id']."' group by bugstatus, bcat, severity"; 
		try {
			$stmt = mysql_query($sql1, $con);
			$result = mysql_num_rows($stmt);
		} catch (Exception $ex) {
			echo($ex->getMessage());
		}
		while($v = mysql_fetch_assoc($stmt)) {
			$row['bug_info'][] = $v;
		}
		$tmp[] = $row;
		$screen_count[$row['version']] = $row['pagecount'];
	}
	
}

$final = array();

foreach($tmp as $val) {
	$version = $val['version'];
	if(!$val['phase_closed']) {
		$final[$version]['phase_status'] = 0;
	}
	if(!$val['out_sourced']) {
		$final[$version]['outsourced_false'] += 1;
	} else {
		$final[$version]['outsourced_true']  += 1;
	}
	if($val['reject_course']) {
		$final[$version]['course_rejected'] += 1;
	} else {
		$final[$version]['course_selected'] += 1;
	}
	if(array_key_exists('bug_info', $val)) {
		foreach($val['bug_info'] as $k => $v) {
			if($v['bugstatus'] == "closed" || $v['bugstatus'] == "fixed" || $v['bugstatus'] == "reopened") {
				$final[$version]['bug_closed'] = $final[$version]['bug_closed'] + $v['bug_status_count'];
			}
			if($v['bugstatus'] == "ok as is") {
				$final[$version]['oai'] = $final[$version]['oai'] + $v['bug_status_count'];	
			} 
			if($v['bugstatus'] == "hold") {
				$final[$version]['hold'] = $final[$version]['hold'] + $v['bug_status_count'];	
			}
			if($v['bcat'] == "media" && $v['bugstatus'] == "closed" && $v['severity'] == 'Low') {
				$final[$version]['L1']['mclosed'] = $final[$version]['L1']['mclosed'] + $v['bug_status_count'];	
			} if($v['bcat'] == "media" && $v['bugstatus'] == "closed" && $v['severity'] == 'Medium') {
				$final[$version]['L2']['mclosed'] = $final[$version]['L2']['mclosed'] + $v['bug_status_count'];	
			} if($v['bcat'] == "media" && $v['bugstatus'] == "closed" && $v['severity'] == 'High'){
				$final[$version]['L3']['mclosed'] = $final[$version]['L3']['mclosed'] + $v['bug_status_count'];
			} 
			if($v['bcat'] == "functionality" && $v['bugstatus'] == "closed" && $v['severity'] == 'Low') {
				$final[$version]['L1']['fclosed'] = $final[$version]['L1']['fclosed'] + $v['bug_status_count'];	
			} if($v['bcat'] == "functionality" && $v['bugstatus'] == "closed" && $v['severity'] == 'Medium') {
				$final[$version]['L2']['fclosed'] = $final[$version]['L2']['fclosed'] + $v['bug_status_count'];	
			} if($v['bcat'] == "functionality" && $v['bugstatus'] == "closed" && $v['severity'] == 'High'){
				$final[$version]['L3']['fclosed'] = $final[$version]['L3']['fclosed'] + $v['bug_status_count'];
			} if($v['bcat'] == "editorial" && $v['bugstatus'] == "closed" && $v['severity'] == 'Low') {
				$final[$version]['L1']['eclosed'] = $final[$version]['L1']['eclosed'] + $v['bug_status_count'];	
			}  if($v['bcat'] == "editorial" && $v['bugstatus'] == "closed" && $v['severity'] == 'Medium') {
				$final[$version]['L2']['eclosed'] = $final[$version]['L2']['eclosed'] + $v['bug_status_count'];	
			}  if($v['bcat'] == "editorial" && $v['bugstatus'] == "closed" && $v['severity'] == 'High'){
				$final[$version]['L3']['eclosed'] = $final[$version]['L3']['eclosed'] + $v['bug_status_count'];
			}
			$final[$version]['total_bug'] = $final[$version]['total_bug'] + $v['bug_status_count'];
		}
	}
}

$str =	"<table cellpadding='1' cellspacing='0' border='1'>
		<tr>
		  <th>Alpha</th>
		  <th>Beta</th>
		  <th>Gold</th>
		  <th>POC</th>
		  <th>Proto</th>
		</tr>
		<tr>";
	if($screen_count['alpha']) {
		$str .=	 "<td>".$screen_count['alpha']."</td>";
	} else {
		$str .= "<td>0</td>";
	} if($screen_count['beta']) {
		$str .=	 "<td>".$screen_count['beta']."</td>";
	} else {
		 $str .= "<td>0</td>";
	} if($screen_count['gold']) {
		$str .=	 "<td>".$screen_count['gold']."</td>";
	} else {
		$str .= "<td>0</td>";
	} if($screen_count['POC']) {
		$str .=	 "<td>".$screen_count['POC']."</td>";
	} else {
		$str .= "<td>0</td>";
	} if($screen_count['proto']) {
		$str .=	 "<td>".$screen_count['proto']."</td>";
	} else {
		$str .= "<td>0</td>";
	}
	$str .=  "</tr>
	  </table><br/>";


$str .= "<table cellpadding='5' cellspacing='0' border='1'>
	<tr>
	  <th>Phase</th>
	  <th>Status</th>
	  <th>Outsourced</th>
	  <th>Total Bugs Logged</th>
	  <th>Total Closed</th>
	  <th>OAI</th>
	  <th>Deffered</th>
	  <th># of QC rejection</th>
	  <th>L1 (Media closed)</th>
	  <th>L2 (Media closed)</th>
	  <th>L3 (Media closed)</th>
	  <th>L1 (ID closed)</th>
	  <th>L2 (ID closed)</th>
	  <th>L3 (ID closed)</th>
	  <th>L1 (Prog closed)</th>
	  <th>L2 (Prog closed)</th>
	  <th>L3 (Prog closed)</th>
	  <th>Cumulative Total Of Bugs</th>
	  <th>Bug Density</th>
	</tr>
	";
	$cumulative_total_bug = 0;
	foreach($final as $key => $val) {
		if(!isset($val['phase_status'])) $val['phase_status'] = 1;
		if(!isset($val['outsourced_false'])) $val['phase_status'] = 0;
		if(!isset($val['outsourced_true'])) $val['outsourced_true'] = 0;
		if(!isset($val['bug_closed'])) $val['bug_closed'] = 0;
		if(!isset($val['oai'])) $val['oai'] = 0;
		if(!isset($val['hold'])) $val['hold'] = 0;
		if(!isset($val['course_rejected'])) $val['course_rejected'] = 0;
		if(!isset($val['course_selected'])) $val['course_selected'] = 0;
		if(!isset($val['L1']['mclosed'])) $val['L1']['mclosed'] = 0;
		if(!isset($val['L2']['mclosed'])) $val['L2']['mclosed'] = 0;
		if(!isset($val['L3']['mclosed'])) $val['L3']['mclosed'] = 0;
		if(!isset($val['L1']['fclosed'])) $val['L1']['fclosed'] = 0;
		if(!isset($val['L2']['fclosed'])) $val['L2']['fclosed'] = 0;
		if(!isset($val['L3']['fclosed'])) $val['L3']['fclosed'] = 0;
		if(!isset($val['L1']['eclosed'])) $val['L1']['eclosed'] = 0;
		if(!isset($val['L2']['eclosed'])) $val['L2']['eclosed'] = 0;
		if(!isset($val['L3']['eclosed'])) $val['L3']['eclosed'] = 0;
		$cumulative_total_bug += $val['total_bug'];
		$str .= "<tr>";
		$str .= "<td>".ucfirst($key)."</td>";
		if($val['phase_status']) {
			$str .= "<td>Closed</td>";
		} else {
			$str .= "<td>Open</td>";
		}
	    if($val['outsourced_true'] > 0) {
			$str .= "<td>Y - ".$val['outsourced_true']." | N - ".$val['outsourced_false']."</td>";
		} else { 
			$str .= "<td>NO</td>";
		} 
		$str .= "<td>".$val['total_bug']."</td>";
		$str .= "<td>".$val['bug_closed']."</td>";
		$str .= "<td>".$val['oai']."</td>";
		$str .= "<td>".$val['hold']."</td>";
		$str .= "<td>".$val['course_rejected']."</td>";
		$str .= "<td>".$val['L1']['mclosed']."</td>";
		$str .= "<td>".$val['L2']['mclosed']."</td>";
		$str .= "<td>".$val['L3']['mclosed']."</td>";
		$str .= "<td>".$val['L1']['fclosed']."</td>";
		$str .= "<td>".$val['L2']['fclosed']."</td>";
		$str .= "<td>".$val['L3']['fclosed']."</td>";
		$str .= "<td>".$val['L1']['eclosed']."</td>";
		$str .= "<td>".$val['L2']['eclosed']."</td>";
		$str .= "<td>".$val['L3']['eclosed']."</td>";
		$str .= "<td>".$cumulative_total_bug."</td>";
		$str .= "<td>".number_format(($val['bug_closed']/$screen_count[$key]) * 40, 2)."</td>";
		$str .= "</tr>";
	  
	}
	$str .= "</table>";
$obj_utility = new Utility();
if(isset($_GET["pro_id"]) && $_GET["pro_id"] != 'null') {
	$obj_utility->force_download($str, 'xls', str_replace(" ","_", $project_name)."_project_report");
}
mysql_close($con);
?> 