<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include("config.php");

if(isset($_GET["id"])) {
	$pro_id = $_GET["id"];
}

$sql = "SELECT FR.version, FR.phase_closed, FR.out_sourced, FR.id, FR.course_level, FR.reject_course, FR.pagecount FROM tbl_functional_review as FR"; 
if(isset($_GET["id"])) {
	$sql .= " WHERE FR.project_id = ".$pro_id;
}

try {
	$retval = mysql_query($sql, $con);
	$results = mysql_num_rows($retval);
} catch (Exception $ex) {
	echo($ex->getMessage());
}
	
if($results == 0){
  die('No '.$issuetype.' item was found with this project name.');
} else {
	$tmp = array();
	$screen_count = array();
	while($row = mysql_fetch_assoc($retval)) {
		
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
?>
<div style="width:100%;margin:10px;">
	<div style="float:left;width:10%;height:70px;">Screen Count </div>
	<div style="float:left;width:20%;height:70px;">
	 <table cellpadding='1' cellspacing='0' border='1'>
		<tr>
		  <th>Alpha</th>
		  <th>Beta</th>
		  <th>Gold</th>
		  <th>POC</th>
		  <th>Proto</th>
		</tr>
		<tr>
		  <td><?php echo ($screen_count['alpha']) ? $screen_count['alpha'] : 0; ?></td>
		  <td><?php echo ($screen_count['beta']) ? $screen_count['beta'] : 0; ?></td>
		  <td><?php echo ($screen_count['gold']) ? $screen_count['gold'] : 0; ?></td>
		  <td><?php echo ($screen_count['POC']) ? $screen_count['POC'] : 0; ?></td>
		  <td><?php echo ($screen_count['proto']) ? $screen_count['proto'] : 0; ?></td>
		</tr>
	  </table>
	</div>
	<div id="exportPanel" style="width:48%;height:70px;float:right;text-align:right;">
		<input type="button" name="export" id="export" value="Export" style="margin-right:10px" onClick="export12();">
	</div>
</div>
<?php 

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
echo "<table cellpadding='5' cellspacing='0' border='1'>
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
	  echo "<tr>";
	  echo "<td>".ucfirst($key)."</td>";
	  
	?>
	<td><?php echo ($val['phase_status']) ? 'Closed' : 'Open'; ?></td>
	<?php if($val['outsourced_true'] > 0) { ?>
		<td><?php echo "Y - ".$val['outsourced_true']." | N - ".$val['outsourced_false']; ?></td>
	<?php } else { ?>
		<td>NO</td>
	<?php } ?>
	<?php
	  echo "<td>".(int)$val['total_bug']."</td>";
	  echo "<td>".(int)$val['bug_closed']."</td>";
	  echo "<td>".$val['oai']."</td>";
	  echo "<td>".$val['hold']."</td>";
	  echo "<td>".$val['course_rejected']."</td>";
	  echo "<td>".$val['L1']['mclosed']."</td>";
	  echo "<td>".$val['L2']['mclosed']."</td>";
      echo "<td>".$val['L3']['mclosed']."</td>";
	  echo "<td>".$val['L1']['fclosed']."</td>";
	  echo "<td>".$val['L2']['fclosed']."</td>";
	  echo "<td>".$val['L3']['fclosed']."</td>";
      echo "<td>".$val['L1']['eclosed']."</td>";
	  echo "<td>".$val['L2']['eclosed']."</td>";
	  echo "<td>".$val['L3']['eclosed']."</td>";
	  echo "<td>".$cumulative_total_bug."</td>";
	  echo "<td>".number_format(($val['bug_closed']/$screen_count[$key]) * 40, 2)."</td>";
	  echo "</tr>";
	  
	}
	echo "</table>";
?>
	
	
