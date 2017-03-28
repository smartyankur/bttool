<?php
error_reporting(~E_ALL & ~E_NOTICE & ~E_DEPRECATED);

include("config.php");

class DailyUpdateProjectReport {
	
	function prepareData($con) {
		
		echo $cur_date_timestamp = strtotime(date('Y-m-d', strtotime("-1 Days")));
		$sub_sql = "select project_id from tbl_functional_review where UNIX_TIMESTAMP(statusupdate) >= '".$cur_date_timestamp."' group by project_id UNION select project_id from qcuploadinfo where UNIX_TIMESTAMP(whenchangedstatus) >= '".$cur_date_timestamp."' group by project_id";
		try {
			$retval = mysql_query($sub_sql, $con);
			$rows = array();
			while($row = mysql_fetch_assoc($retval)) {
				$rows[] = $row['project_id'];
			}
			$error = array();
			if(count($rows) < 1) {
				$error['errorMessage'] = "No result found in current date update";
				return $error;
			}
			$project_ids = implode(',', $rows);
			$sql = "SELECT fr.version, fr.phase_closed, fr.out_sourced, fr.id, fr.course_level, fr.reject_course, fr.pagecount, pm.pin, pm.clientspoc, pm.projectname FROM tbl_functional_review fr join projectmaster pm on pm.pindatabaseid = fr.project_id WHERE project_id IN($project_ids) and fr.status != 'rejected'";
			$retval = mysql_query($sql, $con);
			$results = mysql_num_rows($retval);
			
			if($results == 0){
			  $error['errorMessage'] = "No item was found with this project name";
			  return $error;
			} else {
				$tmp = array();
				$screen_count = array();
				while($row = mysql_fetch_assoc($retval)) {
					
					$sql1 = "select count(bugstatus) as bug_status_count, bugstatus, function, bcat, severity from qcuploadinfo where chd_id = '".$row['id']."' group by bugstatus, function, severity"; 
					
					$stmt = mysql_query($sql1, $con);
					$result = mysql_num_rows($stmt);
					while($v = mysql_fetch_assoc($stmt)) {
						$row['bug_info'][] = $v;
					}
					$pin = $row['pin'];
					$screen_count[$pin][$row['version']] = $row['pagecount'];
					unset($row['pin']);
					unset($row['pagecount']);
					$tmp[$pin][] = $row;
					$tmp[$pin]['screen_count'] = $screen_count[$pin];
					
				}
			
			}
			
			$final = array();
			foreach($tmp as $key1 => $val1) {
				$final[$key1]['screen_count'] = $val1['screen_count'];
				unset($val1['screen_count']);
				foreach($val1 as $key => $val) {
					$version = $val['version'];
					if($val['phase_closed']) {
						$final[$key1][$version]['phase_closed'] = 1;
					} else {
						$final[$key1][$version]['phase_closed'] = 0;
					}
					if(!$val['out_sourced']) {
						$final[$key1][$version]['outsourced_false'] += 1;
					} else {
						$final[$key1][$version]['outsourced_true']  += 1;
					}
					if($val['reject_course']) {
						$final[$key1][$version]['course_rejected'] += 1;
					} else {
						$final[$key1][$version]['course_selected'] += 1;
					}
					$final[$key1][$version]['lh'] = $final[$key1]['screen_count'][$version]/40;
					$final[$key1][$version]['client'] = $val1[0]['clientspoc'];				
					$final[$key1][$version]['project'] = $val1[0]['projectname'];			
					if(array_key_exists('bug_info', $val)) {
						foreach($val['bug_info'] as $k => $v) {
							if(!array_key_exists('bug_closed', $final[$key1][$version])) {
								$final[$key1][$version]['bug_closed'] = 0;
							}
							if(!array_key_exists('oai', $final[$key1][$version])) {
								$final[$key1][$version]['oai'] = 0;
							}
							if(!array_key_exists('hold', $final[$key1][$version])) {
								$final[$key1][$version]['hold'] = 0;
							}
							if(!array_key_exists('mclosed', $final[$key1][$version]['L1'])) {
								$final[$key1][$version]['L1']['mclosed'] = 0;
							}
							if(!array_key_exists('eclosed', $final[$key1][$version]['L1'])) {
								$final[$key1][$version]['L1']['eclosed'] = 0;
							}
							if(!array_key_exists('fclosed', $final[$key1][$version]['L1'])) {
								$final[$key1][$version]['L1']['fclosed'] = 0;
							}
							if(!array_key_exists('mclosed', $final[$key1][$version]['L2'])) {
								$final[$key1][$version]['L2']['mclosed'] = 0;
							}
							if(!array_key_exists('eclosed', $final[$key1][$version]['L2'])) {
								$final[$key1][$version]['L2']['eclosed'] = 0;
							}
							if(!array_key_exists('fclosed', $final[$key1][$version]['L2'])) {
								$final[$key1][$version]['L2']['fclosed'] = 0;
							}
							if(!array_key_exists('mclosed', $final[$key1][$version]['L3'])) {
								$final[$key1][$version]['L3']['mclosed'] = 0;
							}
							if(!array_key_exists('eclosed', $final[$key1][$version]['L3'])) {
								$final[$key1][$version]['L3']['eclosed'] = 0;
							}
							if(!array_key_exists('fclosed', $final[$key1][$version]['L3'])) {
								$final[$key1][$version]['L3']['fclosed'] = 0;
							}
							if(strtolower($v['severity']) != "suggestion") {
								if(strtolower($v['bugstatus']) == "closed" || strtolower($v['bugstatus']) == "fixed" || strtolower($v['bugstatus']) == "reopened"){
									$final[$key1][$version]['total_bug_closed'] = $final[$key1][$version]['total_bug_closed'] + $v['bug_status_count'];
								}
								if(strtolower($v['bugstatus']) == "ok as is") {
									$final[$key1][$version]['oai'] = $final[$key1][$version]['oai'] + $v['bug_status_count'];	
								} 
								if(strtolower($v['bugstatus']) == "hold") {
									$final[$key1][$version]['hold'] = $final[$key1][$version]['hold'] + $v['bug_status_count'];	
								}
								if(strtolower($v['function']) == "media") {
									if($v['bugstatus'] == "closed" && strtolower($v['severity']) == 'low') {
										$final[$key1][$version]['L1']['mclosed'] = $final[$key1][$version]['L1']['mclosed'] + $v['bug_status_count'];	
									} if($v['bugstatus'] == "closed" && strtolower($v['severity']) == 'medium') {
										$final[$key1][$version]['L2']['mclosed'] = $final[$key1][$version]['L2']['mclosed'] + $v['bug_status_count'];	
									} if($v['bugstatus'] == "closed" && strtolower($v['severity']) == 'high'){
										$final[$key1][$version]['L3']['mclosed'] = $final[$key1][$version]['L3']['mclosed'] + $v['bug_status_count'];
									}
									$final[$key1][$version]['total_media_bug'] = $final[$key1][$version]['total_media_bug'] + $v['bug_status_count'];
								}
								$final[$key1][$version]['total_media_bug_closed'] = $final[$key1][$version]['L1']['mclosed'] + $final[$key1][$version]['L2']['mclosed'] + $final[$key1][$version]['L3']['mclosed'];
								$final[$key1][$version]['total_media_dd'] = $final[$key1][$version]['total_media_bug'] / $final[$key1][$version]['lh'];
								
								if(strtolower($v['function']) == "functionality") {
									if( $v['bugstatus'] == "closed" && strtolower($v['severity']) == 'low') {
										$final[$key1][$version]['L1']['fclosed'] = $final[$key1][$version]['L1']['fclosed'] + $v['bug_status_count'];	
									} if($v['bugstatus'] == "closed" && strtolower($v['severity']) == 'medium') {
										$final[$key1][$version]['L2']['fclosed'] = $final[$key1][$version]['L2']['fclosed'] + $v['bug_status_count'];	
									} if($v['bugstatus'] == "closed" && strtolower($v['severity']) == 'high'){
										$final[$key1][$version]['L3']['fclosed'] = $final[$key1][$version]['L3']['fclosed'] + $v['bug_status_count'];
									}
									$final[$key1][$version]['total_functional_bug'] = $final[$key1][$version]['total_functional_bug'] + $v['bug_status_count'];
								}									
								$final[$key1][$version]['total_functional_bug_closed'] = $final[$key1][$version]['L1']['fclosed'] + $final[$key1][$version]['L2']['fclosed'] + $final[$key1][$version]['L3']['fclosed'];
								$final[$key1][$version]['total_functional_dd'] = $final[$key1][$version]['total_functional_bug'] / $final[$key1][$version]['lh'];
								if(strtolower($v['function']) == "editorial") {	
									if($v['bugstatus'] == "closed" && strtolower($v['severity']) == 'low') {
										$final[$key1][$version]['L1']['eclosed'] = $final[$key1][$version]['L1']['eclosed'] + $v['bug_status_count'];	
									}  if($v['bugstatus'] == "closed" && strtolower($v['severity']) == 'medium') {
										$final[$key1][$version]['L2']['eclosed'] = $final[$key1][$version]['L2']['eclosed'] + $v['bug_status_count'];	
									}  if($v['bugstatus'] == "closed" && strtolower($v['severity']) == 'high'){
										$final[$key1][$version]['L3']['eclosed'] = $final[$key1][$version]['L3']['eclosed'] + $v['bug_status_count'];
									}
									$final[$key1][$version]['total_editorial_bug'] = $final[$key1][$version]['total_editorial_bug'] + $v['bug_status_count'];
								}
								$final[$key1][$version]['total_editorial_bug_closed'] = $final[$key1][$version]['L1']['eclosed'] + $final[$key1][$version]['L2']['eclosed'] + $final[$key1][$version]['L3']['eclosed'];
								$final[$key1][$version]['total_editorial_dd'] = $final[$key1][$version]['total_editorial_bug'] / $final[$key1][$version]['lh'];
								$final[$key1][$version]['total_bug'] = $final[$key1][$version]['total_bug'] + $v['bug_status_count'];
								$final[$key1][$version]['bug_density'] = $final[$key1][$version]['total_bug_closed']/$final[$key1][$version]['lh'];
							} else if(strtolower($v['severity']) == "suggestion") {
								if(strtolower($v['bugstatus']) == "closed" || strtolower($v['bugstatus']) == "fixed" || strtolower($v['bugstatus']) == "reopened"){
									$final[$key1][$version]['total_closed_suggestion_bug'] = $final[$key1][$version]['total_closed_suggestion_bug'] + $v['bug_status_count'];
								}
							}
						}
						
					}
				}	
			}
			//echo '<pre>'; print_r($final); die;
			echo json_encode($final);
			return json_encode($final);
		} catch(Exception $e) {
			return $error['errorMessage'] = $e->getMessgae();
		}		
	}
}

$obj = new DailyUpdateProjectReport();
$res = $obj->prepareData($con);
if( is_array($res) && array_key_exists('errorMessage', $res)) {
	echo "No Record Found";
    return;
}
	
$url = "http://61.12.24.68/Efficianttestv1/api/BTToolIntegration/syncbt";

$ch = curl_init( $url );
# Setup request to send json via POST.
curl_setopt( $ch, CURLOPT_POSTFIELDS, $res);
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
# Return response instead of printing.
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
# Send request.
echo $result = curl_exec($ch);
curl_close($ch);

?>
	
	
