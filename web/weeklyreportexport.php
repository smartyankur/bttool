<?php
date_default_timezone_set('EST');

include("config.php");

$activity_csv = '';
$header_csv   = '';
$csv_output   = 'Weekly Report' . ",";
$csv_output  .= "\n";

$header_csv .= "Req ID,Project,Task,Round,Who Sent,When Sent To QC,Status,Delivery Date,When Last Status Achieved,QC,Planned Effort,Actual Effort,Variance,Total bugs,Open bugs,closed bugs,Reopened bugs,Fixed,Hold,OK as is";
$header_csv .= "\n";

$selectCommon = "SELECT pt.project, pt.id as wpid, qcr.indx as reqid, qcr.status, qcr.forround, qcr.whosent, qcr.DDate FROM projecttask pt INNER JOIN qcreq qcr ON pt.id = qcr.id WHERE qcr.status = 'closed' ORDER BY pt.project ASC";
$queryCommon = mysql_query($selectCommon);
$numrowsCommon  = mysql_num_rows($queryCommon);

while($fetchCommon = mysql_fetch_array($queryCommon)){
	$indxCommon = $fetchCommon['reqid'];
	$selectQCPlan = "SELECT * FROM qcplan WHERE indx = $indxCommon ORDER BY indx";
	$queryQCPlan  = mysql_query($selectQCPlan);
	$numrowsQCPlan  = mysql_num_rows($queryQCPlan);
  if($numrowsQCPlan != 0){
    while($fetchQCPlan = mysql_fetch_array($queryQCPlan)){

  $queryBugsDetails = mysql_query("SELECT count(id) as totalBugs, 
                                        (select count(status) from `lmsblob` where status = 'open' and `reqid` = ".$fetchQCPlan['indx'].") as openBugs,
                                        (select count(status) from `lmsblob` where status = 'closed' and `reqid` = ".$fetchQCPlan['indx'].") as closedBugs,                                           
                                        (select count(status) from `lmsblob` where status = 'reopened' and `reqid` = ".$fetchQCPlan['indx'].") as reopenedBugs,   
                                        (select count(status) from `lmsblob` where status = 'fixed' and `reqid` = ".$fetchQCPlan['indx'].") as fixedBugs,  
                                        (select count(status) from `lmsblob` where status = 'hold' and `reqid` = ".$fetchQCPlan['indx'].") as holdBugs,
                                        (select count(status) from `lmsblob` where status = 'ok as is' and `reqid` = ".$fetchQCPlan['indx'].") as okasisBugs                                                                                
                                 FROM `lmsblob` where `reqid` = ".$fetchQCPlan['indx']);
  $fetchBugsDetails = mysql_fetch_array($queryBugsDetails);

  $search = array(",");
  $replace = array(";"); 
  
    $activity_csv .= str_replace(",", ";", $fetchCommon['reqid']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['project']) . ",";
    $activity_csv .= str_replace($search, $replace, trim(preg_replace('/\s\s+/', ' ', $fetchQCPlan['task']))) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['forround']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['whosent']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchQCPlan['SDate']) . ",";            
    $activity_csv .= str_replace(",", ";", $fetchQCPlan['status']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['DDate']) . ",";        
    $activity_csv .= str_replace(",", ";", $fetchQCPlan['whenchanged']) . ",";    
    $activity_csv .= str_replace(",", ";", $fetchQCPlan['qc']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchQCPlan['effort']) . ",";    
    $activity_csv .= str_replace(",", ";", $fetchQCPlan['actualeffort']) . ",";
    $activity_csv .= round((($fetchQCPlan['actualeffort']-$fetchQCPlan['effort'])/$fetchQCPlan['effort']), 2) . ",";
    $activity_csv .= str_replace(",", ";", $fetchBugsDetails['totalBugs']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchBugsDetails['openBugs']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchBugsDetails['closedBugs']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchBugsDetails['reopenedBugs']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchBugsDetails['fixedBugs']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchBugsDetails['holdBugs']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchBugsDetails['okasisBugs']) . ",";                                                    
    $activity_csv .= "\n";  
    }
  }//else{
//     $activity_csv .= " No records,";                                        
//     $activity_csv .= "\n";
//   }
}  

$csv_output .= $header_csv;
$csv_output .= $activity_csv;

//$randnum = rand(1, 50);
define('FILE_NAME', 'Weekly_Report_');
$fullfilename = FILE_NAME . date("dMy", time()) . '.csv';
//$filename = 'D:/octagon/' . $fullfilename;
$filename = $fullfilename;
$fp = fopen($filename, "w");
fwrite($fp, $csv_output);
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
header("Content-Type: application/ms-excel");
header("Content-Disposition: attachment; filename=" . $fullfilename . ";");
header("Content-Transfer-Encoding: binary");
header("Content-Length: " . filesize($filename));
readfile("$filename");
fclose( $fp );
unlink($filename);

?>