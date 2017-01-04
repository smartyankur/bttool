<?php
date_default_timezone_set('EST');

include("config.php");

$userinfo = $_REQUEST["userinfo"];

$activity_csv = '';
$header_csv   = '';
$csv_output   = 'Weekly Report' . ",";
$csv_output  .= "\n";

$header_csv .= "Incident ID,Description,Reported Date,Requested By,Email ID,File Path";
$header_csv .= "\n";

//$selectCommon = "SELECT * FROM ticket";
$selectCommon   = "SELECT * FROM ticket where user='$userinfo'";
$queryCommon    = mysql_query($selectCommon);
$numrowsCommon  = mysql_num_rows($queryCommon);

while($fetchCommon = mysql_fetch_array($queryCommon)){
	
	 $search = array(",");
  $replace = array(";");
	$activity_csv .= str_replace(",", ";", $fetchCommon['id']) . ",";
    $activity_csv .= str_replace($search, $replace, trim(preg_replace('/\s\s+/', ' ', $fetchCommon['ticket']))) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['timestamp']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['requestedby']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['officialemail']) . ",";            
    $activity_csv .= str_replace(",", ";", $fetchCommon['filepath']) . ",";
    $activity_csv .= "\n";  
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