<?php
date_default_timezone_set('EST');

include("config.php");

$activity_csv = '';
$header_csv   = '';
$csv_output   = 'Weekly Report' . ",";
$csv_output  .= "\n";

$header_csv .= "Bug No,Req ID,Reviewer,Developer,Build,Type,Category,Priority,Severity,Status,Dev Reason,Module,Submodule,QC Comment,Dev Comment,BugDesc";
$header_csv .= "\n";

$selectCommon  = "SELECT * FROM lmsblob where project='".urldecode($_REQUEST['pname'])."'";
$queryCommon   = mysql_query($selectCommon);
$numrowsCommon = mysql_num_rows($queryCommon);
if($numrowsCommon != 0){
  while($fetchCommon = mysql_fetch_array($queryCommon)){
    $search = array(",");
    $replace = array(";"); 
  
    $activity_csv .= $fetchCommon['id'] . ",";
    $activity_csv .= $fetchCommon['reqid'] . ",";
    $activity_csv .= $fetchCommon['reviewer'] . ",";
    $activity_csv .= $fetchCommon['dev'] . ",";
    $activity_csv .= $fetchCommon['build'] . ",";            
    $activity_csv .= $fetchCommon['type'] . ",";
    $activity_csv .= $fetchCommon['btype'] . ",";        
    $activity_csv .= $fetchCommon['priority'] . ",";    
    $activity_csv .= $fetchCommon['severity'] . ",";
    $activity_csv .= $fetchCommon['status'] . ",";    
    $activity_csv .= $fetchCommon['devreason'] . ",";
    $activity_csv .= $fetchCommon['module'] . ",";
    $activity_csv .= $fetchCommon['submodule'] . ",";
    $activity_csv .= str_replace($search, $replace, trim(preg_replace('/\s\s+/', ' ', $fetchCommon['qccomment']))) . ",";
    $activity_csv .= str_replace($search, $replace, trim(preg_replace('/\s\s+/', ' ', $fetchCommon['devcomment']))) . ",";
    $activity_csv .= str_replace($search, $replace, trim(preg_replace('/\s\s+/', ' ', $fetchCommon['bdr']))) . ",";                                                    
    $activity_csv .= "\n";  
  }
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