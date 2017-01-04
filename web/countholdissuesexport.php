<?php
include("config.php");

$activity_csv = '';
$header_csv   = '';
$csv_output   = "Count or Hold Issues Report" . ",";
$csv_output  .= "\n";

$header_csv .= "S. No., Project, Round name, Count of Hold Issues";
$header_csv .= "\n";

$i=1;    
$selectCounts = "SELECT `project`, `round`, COUNT(`round`) AS `roundcount` FROM `qcuploadinfo` WHERE `bugstatus`='hold' GROUP BY `project`, `round` ORDER BY `project` ASC";
$queryCounts = mysql_query($selectCounts);
while($fetchCounts = mysql_fetch_array($queryCounts)){
  $search = array(",");
  $replace = array(";"); 
  
  $activity_csv .= str_replace(",", ";", $i) . ",";
  $activity_csv .= str_replace(",", ";", $fetchCounts['project']) . ",";
  $activity_csv .= str_replace(",", ";", $fetchCounts['round']) . ",";
  $activity_csv .= str_replace(",", ";", $fetchCounts['roundcount']) . ",";
  $activity_csv .= "\n";
  
  $i++;
}

$csv_output .= $header_csv;
$csv_output .= $activity_csv;

//$randnum = rand(1, 50);
define('FILE_NAME', 'Hold_Issues_Report_');
$fullfilename = FILE_NAME . date("dMy", time()) . '.csv';
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