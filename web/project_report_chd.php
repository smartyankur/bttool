<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include("config.php");

if(isset($_GET["id"])) {
	$pro_id = $_GET["id"];
}
else if(isset($_GET["fdate"])) {
	$fdate = strtotime($_GET["fdate"]);
}
$sql = "SELECT project_name, project_manager, course_title, course_level, version, pagecount, functional_manager_id, functional_manager_media, functional_manager_tech, developers_id, developers_media, developers_tech, testing_scope, partial_testing FROM tbl_functional_review"; 
if(isset($_GET["id"])) {
	$sql .= " WHERE project_id = ".$pro_id;
} else if(isset($_GET["fdate"])) {
	$sql .= " WHERE start_date >= ".$fdate;
}
try {
	$retval = mysql_query($sql, $con);
	$results = mysql_num_rows($retval);
} catch (Exception $ex) {
	echo($ex->getMessage());
}
	
if($results == 0){
  die('No item was found');
} else {
	$tmp = array();
	$screen_count = array();
	while($row = mysql_fetch_assoc($retval)) {
		
		$sql1 = "select count(bugstatus) as bug_count, bugstatus, function, bcat, bscat, qcuploadinfo.severity, category from qcuploadinfo left join tbl_category on tbl_category.id = qcuploadinfo.bscat where chd_id = '".$row['id']."' group by bugstatus, function, qcuploadinfo.severity, bscat"; 
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
		//$screen_count[$row['version']] = $row['pagecount'];
	}
	//echo '<pre>'; print_r($tmp);
}
?>
<!--<div style="width:100%;margin:10px;">
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
		  <td><?php //echo ($screen_count['alpha']) ? $screen_count['alpha'] : 0; ?></td>
		  <td><?php //echo ($screen_count['beta']) ? $screen_count['beta'] : 0; ?></td>
		  <td><?php //echo ($screen_count['gold']) ? $screen_count['gold'] : 0; ?></td>
		  <td><?php //echo ($screen_count['POC']) ? $screen_count['POC'] : 0; ?></td>
		  <td><?php //echo ($screen_count['proto']) ? $screen_count['proto'] : 0; ?></td>
		</tr>
	  </table>
	</div>-->
	<!--<div id="exportPanel" style="width:48%;height:70px;float:right;text-align:right;">
		<input type="button" name="export" id="export" value="Export" style="margin-right:10px" onClick="export12();">
	</div>-->
</div>
<?php 

$final = array();

foreach($tmp as $key => $val) {
	$version = $val['version'];
	$final[$key]['project_name'] = $val['project_name'];
	$final[$key]['project_manager'] = $val['project_manager'];
	$final[$key]['course_title'] = $val['course_title'];
	$final[$key]['course_level'] = $val['course_level'];
	$final[$key]['functional_manager_id'] = $val['functional_manager_id'];
	$final[$key]['functional_manager_media'] = $val['functional_manager_media'];
	$final[$key]['functional_manager_tech'] = $val['functional_manager_tech'];
	$final[$key]['developers'] = $val['developers_id'].",".$val['developers_media'].",".$val['developers_tech'];
	$final[$key]['version'] = $val['version'];
	$final[$key]['testing_scope'] = $val['testing_scope'];
	$final[$key]['partial_testing'] = $val['partial_testing'];
	$final[$key]['pagecount'] = $val['pagecount'];
	$final[$key]['lh'] = $val['pagecount']/40;
	if(array_key_exists('bug_info', $val)) {
		foreach($val['bug_info'] as $k => $v) {
			if(strtolower($v['severity']) != "suggestion") {
				if($v['bugstatus'] == "closed" || $v['bugstatus'] == "fixed" || $v['bugstatus'] == "reopened") {
					$final[$key]['bug_closed'] = $final[$key]['bug_closed'] + $v['bug_count'];
				}
				if($v['bugstatus'] == "ok as is") {
					$final[$key]['oai'] = $final[$key]['oai'] + $v['bug_count'];	
				} 
				if($v['bugstatus'] == "hold") {
					$final[$key]['hold'] = $final[$key]['hold'] + $v['bug_count'];	
				}
				if(strtolower($v['function']) == "media" || strtolower($v['bcat']) == "media") {
					if($v['bugstatus'] == "closed") {
						$final[$key]['mclosed'] = $final[$key]['mclosed'] + $v['bug_count'];	
					}
				}
				if(strtolower($v['function']) == "functionality" || strtolower($v['bcat']) == "functionality"){
					if($v['bugstatus'] == "closed") {
						$final[$key]['fclosed'] = $final[$key]['fclosed'] + $v['bug_count'];	
					}
				}
				if(strtolower($v['function']) == "editorial" || strtolower($v['bcat']) == "editorial") {
					if($v['bugstatus'] == "closed") {
						$final[$key]['eclosed'] = $final[$key]['eclosed'] + $v['bug_count'];	
					}
				}
				$final[$key]['total_bug'] = $final[$key]['total_bug'] + $v['bug_count'];
				if($v['category'] == "Text Formatting") {
					$final[$key]['tfbug_count'] = $final[$key]['tfbug_count'] + $v['bug_count'];
				}else if($v['category'] == "Text Mismatch") {
					$final[$key]['tmbug_count'] = $final[$key]['tmbug_count'] + $v['bug_count'];
				}else if($v['category'] == "Text Overlap/Truncation/Overflow") {
					$final[$key]['tobug_count'] = $final[$key]['tobug_count'] + $v['bug_count'];
				}else if($v['category'] == "Junck Characters") {
					$final[$key]['jcbug_count'] = $final[$key]['jcbug_count'] + $v['bug_count'];
				}else if($v['category'] == "Punctuation") {
					$final[$key]['pcbug_count'] = $final[$key]['pcbug_count'] + $v['bug_count'];
				}else if($v['category'] == "Spelling Error") {
					$final[$key]['spbug_count'] = $final[$key]['spbug_count'] + $v['bug_count'];
				}else if($v['category'] == "Grammatical Error") {
					$final[$key]['grbug_count'] = $final[$key]['grbug_count'] + $v['bug_count'];
				}else if($v['category'] == "Content Incorrect/Unclear") {
					$final[$key]['cibug_count'] = $final[$key]['cibug_count'] + $v['bug_count'];
				}else if($v['category'] == "Translation Error") {
					$final[$key]['tebug_count'] = $final[$key]['tebug_count'] + $v['bug_count'];
				}else if($v['category'] == "Inconsistent Use of Terms") {
					$final[$key]['iutbug_count'] = $final[$key]['iutbug_count'] + $v['bug_count'];
				}else if($v['category'] == "Instruction Text Missing/Unclear") {
					$final[$key]['itmbug_count'] = $final[$key]['itmbug_count'] + $v['bug_count'];
				}else if($v['category'] == "Inconsistent Layout") {
					$final[$key]['ilbug_count'] = $final[$key]['ilbug_count'] + $v['bug_count'];
				}else if($v['category'] == "Image Missing/Incorrect") {
					$final[$key]['imibug_count'] = $final[$key]['imibug_count'] + $v['bug_count'];
				}else if($v['category'] == "Image Stretched or Distorted") {
					$final[$key]['isdbug_count'] = $final[$key]['isdbug_count'] + $v['bug_count'];
				}else if($v['category'] == "Image/Animation/Video is  not loading") {
					$final[$key]['iavbug_count'] = $final[$key]['iavbug_count'] + $v['bug_count'];
				}else if($v['category'] == "Controls Do Not Function") {
					$final[$key]['cdnfbug_count'] = $final[$key]['cdnfbug_count'] + $v['bug_count'];
				}else if($v['category'] == "Image Overlap/Truncation/Missing Border") {
					$final[$key]['iotmbug_count'] = $final[$key]['iotmbug_count'] + $v['bug_count'];
				}else if($v['category'] == "Preloader Missing") {
					$final[$key]['pmbug_count'] = $final[$key]['pmbug_count'] + $v['bug_count'];
				}else if($v['category'] == "Settings Error") {
					$final[$key]['sebug_count'] = $final[$key]['sebug_count'] + $v['bug_count'];
				}else if($v['category'] == "Video With Blank Screen At The End") {
					$final[$key]['vwbsbug_count'] = $final[$key]['vwbsbug_count'] + $v['bug_count'];
				}else if($v['category'] == "Pronunciation Error") {
					$final[$key]['prebug_count'] = $final[$key]['prebug_count'] + $v['bug_count'];
				}else if($v['category'] == "Audio Mismatch With Transcript/CC Text") {
					$final[$key]['amwtbug_count'] = $final[$key]['amwtbug_count'] + $v['bug_count'];
				}else if($v['category'] == "Audio Pitch/Speed/Echo") {
					$final[$key]['apsebug_count'] = $final[$key]['apsebug_count'] + $v['bug_count'];
				}else if($v['category'] == "Audio Ends Abruptly") {
					$final[$key]['aeabug_count'] = $final[$key]['aeabug_count'] + $v['bug_count'];
				}else if($v['category'] == "Audio/Visuals Not In Synch") {
					$final[$key]['avnisbug_count'] = $final[$key]['avnisbug_count'] + $v['bug_count'];
				}else if($v['category'] == "Audio Missing") {
					$final[$key]['ambug_count'] = $final[$key]['ambug_count'] + $v['bug_count'];
				}else if($v['category'] == "Mentor's Lip Not in Sync With Audio") {
					$final[$key]['mlbug_count'] = $final[$key]['mlbug_count'] + $v['bug_count'];
				}else if($v['category'] == "Hit Area Incorrect") {
					$final[$key]['haibug_count'] = $final[$key]['haibug_count'] + $v['bug_count'];
				}else if($v['category'] == "Button/Link Not Functional") {
					$final[$key]['blnfbug_count'] = $final[$key]['blnfbug_count'] + $v['bug_count'];
				}else if($v['category'] == "Incorrect Link or Hotspot - Destination") {
					$final[$key]['ilhdbug_count'] = $final[$key]['ilhdbug_count'] + $v['bug_count'];
				}else if($v['category'] == "Template Functionality Error") {
					$final[$key]['tfebug_count'] = $final[$key]['tfebug_count'] + $v['bug_count'];
				}else if($v['category'] == "Information button/Hint Text Not Displaying") {
					$final[$key]['ibhtbug_count'] = $final[$key]['ibhtbug_count'] + $v['bug_count'];
				}else if($v['category'] == "Autojump Error") {
					$final[$key]['ajebug_count'] = $final[$key]['ajebug_count'] + $v['bug_count'];
				}else if($v['category'] == "Page Loading Error") {
					$final[$key]['plebug_count'] = $final[$key]['plebug_count'] + $v['bug_count'];
				}else if($v['category'] == "Page Not Responding") {
					$final[$key]['pnrbug_count'] = $final[$key]['pnrbug_count'] + $v['bug_count'];
				}else if($v['category'] == "Page or Frame Missing or Incorrect") {
					$final[$key]['pfibug_count'] = $final[$key]['pfibug_count'] + $v['bug_count'];
				}else if($v['category'] == "Flickering Error") {
					$final[$key]['flibug_count'] = $final[$key]['flibug_count'] + $v['bug_count'];
				}else if($v['category'] == "ADA/508 Error") {
					$final[$key]['adabug_count'] = $final[$key]['adabug_count'] + $v['bug_count'];
				}else if($v['category'] == "Bookmarking Error") {
					$final[$key]['bebug_count'] = $final[$key]['bebug_count'] + $v['bug_count'];
				}else if($v['category'] == "Scoring Error") {
					$final[$key]['scebug_count'] = $final[$key]['scebug_count'] + $v['bug_count'];
				}else if($v['category'] == "Completion Marking Error") {
					$final[$key]['cmebug_count'] = $final[$key]['cmebug_count'] + $v['bug_count'];
				}
			}
		}
		$final[$key]['closed_count_lh'] = $final[$key]['bug_closed'] / $final[$key]['lh'];
		$final[$key]['media_closed_count'] = $final[$key]['mclosed'];
		$final[$key]['media_closed_count_lh'] = $final[$key]['media_closed_count'] / $final[$key]['lh'];
		$final[$key]['fun_closed_count'] = $final[$key]['fclosed'];
		$final[$key]['fun_closed_count_lh'] = $final[$key]['fun_closed_count'] / $final[$key]['lh'];
		$final[$key]['edit_closed_count'] = $final[$key]['eclosed'];
		$final[$key]['edit_closed_count_lh'] = $final[$key]['edit_closed_count'] / $final[$key]['lh'];
	}
}
//echo '<pre>'; print_r($final);
echo "<table cellpadding='5' cellspacing='0' border='1'>
	<tr>
	  <th>S.No.</th>
	  <th>Project Name</th>
	  <th>Project Manager</th>
	  <th>Course Title</th>
	  <th>Course Level</th>
	  <th>Functional Manager[ID]</th>
	  <th>Functional Manager[Med]</th>
	  <th>Functional Manager[Tech]</th>
	  <th>Developers</th>
	  <th>Version</th>
	  <th>No. Of HTML/Flash Pages</th>
	  <th>LH</th>
	  <th>Scope for Testing</th>
	  <th>Partial Testing</th>
	  <th>Close bug count</th>
	  <th>ID Defects Closed</th>
	  <th>Media Defects Closed</th>
	  <th>Tech Defects Closed</th>
	  <th>Closed Count/LH</th>
	  <th>ID Defects Closed/LH</th>
	  <th>Media Defects Closed/LH</th>
	  <th>Tech Defects Closed/LH</th>
	  <th>Total Bugs Logged</th>
	  <th>Text Formatting</th>
	  <th>Text Mismatching</th>
	  <th>Text Overlap/Truncation/Overflow</th>
	  <th>Junck Characters</th>
	  <th>Punctuation</th>
	  <th>Spelling Error</th>
	  <th>Grammatical Error</th>
	  <th>Content Incorrect/Unclear</th>
	  <th>Translation Error</th>
	  <th>Inconsistent Use of Terms</th>
	  <th>Instruction Text Missing/Unclear</th>
	  <th>Inconsistent Layout</th>
	  <th>Image Missing/Incorrect</th>
	  <th>Image Stretched or Distorted</th>
	  <th>Image/Animation/Video is  not loading</th>
	  <th>Controls Do Not Function</th>
	  <th>Image Overlap/Truncation/Missing Border</th>
	  <th>Preloader Missing</th>
	  <th>Settings Error</th>
	  <th>Video With Blank Screen At The End</th>
	  <th>Pronunciation Error</th>
	  <th>Audio Mismatch With Transcript/CC Text</th>
	  <th>Audio Pitch/Speed/Echo</th>
	  <th>Audio Ends Abruptly</th>
	  <th>Audio/Visuals Not In Synch</th>
	  <th>Audio Missing</th>
	  <th>Mentor's Lip Not in Sync With Audio</th>
	  <th>Hit Area Incorrect</th>
	  <th>Button/Link Not Functional</th>
	  <th>Incorrect Link or Hotspot - Destination</th>
	  <th>Template Functionality Error</th>
	  <th>Information button/Hint Text Not Displaying</th>
	  <th>Autojump Error</th>
	  <th>Page Loading Error</th>
	  <th>Page Not Responding</th>
	  <th>Page or Frame Missing or Incorrect</th>
	  <th>Flickering Error</th>
	  <th>ADA/508 Error</th>
	  <th>Bookmarking Error</th>
	  <th>Scoring Error</th>
	  <th>Completion Marking Error</th>
	</tr>
	";
	$cumulative_total_bug = 0;
	foreach($final as $key => $val) {
		if(!isset($val['bug_closed'])) $val['bug_closed'] = 0;
		if(!isset($val['oai'])) $val['oai'] = 0;
		if(!isset($val['hold'])) $val['hold'] = 0;
		if(!isset($val['L1']['mclosed'])) $val['L1']['mclosed'] = 0;
		if(!isset($val['L2']['mclosed'])) $val['L2']['mclosed'] = 0;
		if(!isset($val['L3']['mclosed'])) $val['L3']['mclosed'] = 0;
		if(!isset($val['L1']['fclosed'])) $val['L1']['fclosed'] = 0;
		if(!isset($val['L2']['fclosed'])) $val['L2']['fclosed'] = 0;
		if(!isset($val['L3']['fclosed'])) $val['L3']['fclosed'] = 0;
		if(!isset($val['L1']['eclosed'])) $val['L1']['eclosed'] = 0;
		if(!isset($val['L2']['eclosed'])) $val['L2']['eclosed'] = 0;
		if(!isset($val['L3']['eclosed'])) $val['L3']['eclosed'] = 0;
	  echo "<tr>";
	  echo "<td>".ucfirst($key)."</td>";
	  echo "<td>".$val['project_name']."</td>";
	  echo "<td>".$val['project_manager']."</td>";
	  echo "<td>".$val['course_title']."</td>";
	  echo "<td>".$val['course_level']."</td>";
	  echo "<td>".$val['functional_manager_id']."</td>";
	  echo "<td>".$val['functional_manager_media']."</td>";
	  echo "<td>".$val['functional_manager_tech']."</td>";
      echo "<td>".$val['developers']."</td>";
	  echo "<td>".$val['version']."</td>";
	  echo "<td>".$val['pagecount']."</td>";
	  echo "<td>".$val['lh']."</td>";
      echo "<td>".$val['testing_scope']."</td>";
	  echo "<td>".$val['partial_testing']."</td>";
	  echo "<td>".(int)$val['bug_closed']."</td>";
	  echo "<td>".(int)$val['edit_closed_count']."</td>";
	  echo "<td>".(int)$val['media_closed_count']."</td>";
	  echo "<td>".(int)$val['fun_closed_count']."</td>";
	  echo "<td>".(int)$val['closed_count_lh']."</td>";
	  echo "<td>".(int)$val['edit_closed_count_lh']."</td>";
	  echo "<td>".(int)$val['media_closed_count_lh']."</td>";
	  echo "<td>".(int)$val['edit_closed_count_lh']."</td>";
	  echo "<td>".(int)$val['total_bug']."</td>";
	  echo "<td>".(int)$val['tfbug_count']."</td>";
	  echo "<td>".(int)$val['tmbug_count']."</td>";
	  echo "<td>".(int)$val['tobug_count']."</td>";
	  echo "<td>".(int)$val['jcbug_count']."</td>";
	  echo "<td>".(int)$val['pcbug_count']."</td>";
	  echo "<td>".(int)$val['spbug_count']."</td>";
	  echo "<td>".(int)$val['grbug_count']."</td>";
	  echo "<td>".(int)$val['cibug_count']."</td>";
	  echo "<td>".(int)$val['grbug_count']."</td>";
	  echo "<td>".(int)$val['tebug_count']."</td>";
	  echo "<td>".(int)$val['iutbug_count']."</td>";
	  echo "<td>".(int)$val['itmbug_count']."</td>";
	  echo "<td>".(int)$val['ilbug_count']."</td>";
	  echo "<td>".(int)$val['isdbug_count']."</td>";
	  echo "<td>".(int)$val['iavbug_count']."</td>";
	  echo "<td>".(int)$val['cdnfbug_count']."</td>";
	  echo "<td>".(int)$val['iotmbug_count']."</td>";
	  echo "<td>".(int)$val['pmbug_count']."</td>";
	  echo "<td>".(int)$val['sebug_count']."</td>";
	  echo "<td>".(int)$val['vwbsbug_count']."</td>";
	  echo "<td>".(int)$val['prebug_count']."</td>";
	  echo "<td>".(int)$val['amwtbug_count']."</td>";
	  echo "<td>".(int)$val['apsebug_count']."</td>";
	  echo "<td>".(int)$val['aeabug_count']."</td>";
	  echo "<td>".(int)$val['avnisbug_count']."</td>";
	  echo "<td>".(int)$val['ambug_count']."</td>";
	  echo "<td>".(int)$val['mlbug_count']."</td>";
	  echo "<td>".(int)$val['hiabug_count']."</td>";
	  echo "<td>".(int)$val['blnfbug_count']."</td>";
	  echo "<td>".(int)$val['ilhdbug_count']."</td>";
	  echo "<td>".(int)$val['tfebug_count']."</td>";
	  echo "<td>".(int)$val['ibhtbug_count']."</td>";
	  echo "<td>".(int)$val['ajebug_count']."</td>";
	  echo "<td>".(int)$val['plebug_count']."</td>";
	  echo "<td>".(int)$val['pnrbug_count']."</td>";
	  echo "<td>".(int)$val['pfibug_count']."</td>";
	  echo "<td>".(int)$val['flibug_count']."</td>";
	  echo "<td>".(int)$val['adabug_count']."</td>";
	  echo "<td>".(int)$val['bebug_count']."</td>";
	  echo "<td>".(int)$val['scebug_count']."</td>";
	  echo "<td>".(int)$val['cmebug_count']."</td>";
	  echo "</tr>";
	  
	}
	echo "</table>";
?>
	
	
