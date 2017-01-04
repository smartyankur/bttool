<?php
date_default_timezone_set('EST');

include("config.php");

$row_csv      = '';
$header_csv   = '';
$csv_output   = 'Product Level Bugs Report' . ",";
$csv_output  .= "\n";

$header_csv .= "Project, Bug No, Req ID, Reviewer, Developer, Build, Type, Category, Priority, Severity, Status, Dev Comment, QC Comment, BugDesc";
$header_csv .= "\n";

$selectRecords = "SELECT * FROM lmsblob WHERE (btype='product' OR devcomment LIKE '%product%') ORDER BY project ASC";
$queryRecords = mysql_query($selectRecords);
$numrowsRecords  = mysql_num_rows($queryRecords);
if( !empty($numrowsRecords) ){
  while($fetchRecords = mysql_fetch_array($queryRecords)){

    $search = array(",");
    $replace = array(";"); 
  
    $row_csv .= str_replace(",", ";", $fetchRecords['project']) . ",";
    $row_csv .= $fetchRecords['id'] . ",";
    $row_csv .= $fetchRecords['reqid'] . ",";    
    $row_csv .= str_replace(",", ";", $fetchRecords['reviewer']) . ",";    
    $row_csv .= str_replace(",", ";", $fetchRecords['dev']) . ",";
    $row_csv .= str_replace(",", ";", $fetchRecords['build']) . ",";
    $row_csv .= str_replace(",", ";", $fetchRecords['type']) . ",";
    $row_csv .= str_replace(",", ";", $fetchRecords['btype']) . ",";
    $row_csv .= str_replace(",", ";", $fetchRecords['priority']) . ",";
    $row_csv .= str_replace(",", ";", $fetchRecords['severity']) . ",";
    $row_csv .= str_replace(",", ";", $fetchRecords['status']) . ",";
    $row_csv .= str_replace($search, $replace, trim(preg_replace('/\s\s+/', ' ', $fetchRecords['devcomment']))) . ",";
    $row_csv .= str_replace($search, $replace, trim(preg_replace('/\s\s+/', ' ', $fetchRecords['qccomment']))) . ",";
    $row_csv .= str_replace($search, $replace, trim(preg_replace('/\s\s+/', ' ', $fetchRecords['bdr']))) . ",";
    $row_csv .= "\n";  
  }
}else{
    $row_csv .= " No records,";                                        
    $row_csv .= "\n";
}  

$csv_output .= $header_csv;
$csv_output .= $row_csv;

//$randnum = rand(1, 50);
define('FILE_NAME', 'Product_Level_Bugs_');
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