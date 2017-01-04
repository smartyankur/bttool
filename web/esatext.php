<?php
date_default_timezone_set('EST');

include("config.php");

$activity_csv = '';
$header_csv   = '';
$csv_output   = 'ESAT Report' . ",";
$csv_output  .= "\n";

$header_csv .= "EmpID,User,Q11,Q12,Q13,Q14,Q15,Q21,Q21a,Q22,Q23,Q24,Q24a,Q25,Q26,Q31,Q31a,Q32,Q32a,Q33,Q34,Q35,Q36,Q37,Q41,Q42,Q43,Q44,Q45,Q46,Q47,Q51,Q52,Q53,Q54,Q55,Q56,Q57,Q58,Q59,Q59a,Q510,Q511,Q511a,Q512,Q61,Q61a,Q62,Q63,Q64,Q65,Q66,Q67";
$header_csv .= "\n";

$selectCommon = "SELECT * FROM esat";
$queryCommon = mysql_query($selectCommon);
$numrowsCommon  = mysql_num_rows($queryCommon);

while($fetchCommon = mysql_fetch_array($queryCommon)){
	

  $search = array(",");
  $replace = array(";"); 
  
    $activity_csv .= str_replace(",", ";", $fetchCommon['empid']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['user']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q11']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q12']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q13']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q14']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q15']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q21']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q21a']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q22']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q23']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q24']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q24a']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q25']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q26']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q31']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q31a']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q32']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q32a']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q33']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q34']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q35']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q36']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q37']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q41']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q42']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q43']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q44']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q45']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q46']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q47']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q51']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q52']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q53']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q54']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q55']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q56']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q57']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q58']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q59']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q59a']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q510']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q511']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q511a']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q512']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q61']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q61a']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q62']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q63']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q64']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q65']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q66']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchCommon['Q67']) . ",";
    
    $activity_csv .= "\n";  
    }
//  }//else{
//     $activity_csv .= " No records,";                                        
//     $activity_csv .= "\n";
//   }
//}  

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
