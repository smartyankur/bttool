<?php
include("config.php");

$activity_csv = '';
$header_csv   = '';
$csv_output   = "Function Wise Categorized Report" . ",";
$csv_output  .= "\n";

$header_csv .= "Project, Project Mgr, Review Date, Audio, Editorial, Functionality, Media, Simulation, Suggesstions, Ok AS Is, Hold, Valid Issues, Total, ID, Media, Script, QC FM, QC";
$header_csv .= "\n";

$query  = "SELECT qc.*, COUNT(*), prom.fmone,prom.fmtwo,prom.fmthree,prom.fmfour,prom.projectmanager FROM qcuploadinfo AS qc INNER JOIN projectmaster AS prom ON qc.project_id = prom.pindatabaseid WHERE qc.bcat<> 'suggesstion' AND (qc.bugstatus='closed' or qc.bugstatus='open' or qc.bugstatus='reopened' or qc.bugstatus='fixed') group by qc.project ASC";
$retval = mysql_query( $query, $con );
$count  = mysql_num_rows($retval);

if($count != 0){
  while($row = mysql_fetch_assoc($retval)){ 
    $count=$row['COUNT(*)'];
    $proj=$row['project'];
    $proj_id=$row['project_id'];
	$revdt = date( 'Y-m-d', strtotime($row['uploaddate']) );
    $fmone=$row['fmone'];
	$fmtwo=$row['fmtwo'];
	$fmthree=$row['fmthree'];
	$fmfour=$row['fmfour']; 
	$totpm=$row['projectmanager'];
	$totqc=$row['qc'];
	//$assignee=$row['asignee'];
	$okcount = 0;
	$okhold = 0;
	$oksug = 0;
	$totmed = 0;
	$totau = 0;
	$totfn = 0;
	$toted = 0;
	$totsim = 0; 
	$totsug = 0;
	
	$count_by_status ="select bugstatus, count(*) from qcuploadinfo where project_id='$proj_id' group by `bugstatus`";
	$ret = mysql_query( $count_by_status, $con );
	  
	while($bug_row = mysql_fetch_assoc($ret))  { 
		if($bug_row['bugstatus'] == "ok as is")
			$okcount = $bug_row['count(*)'];
		else if($bug_row['bugstatus'] == "hold")
			$okhold = $bug_row['count(*)'];
		else if ($bug_row['bugstatus'] == "suggesstion")
			$oksug = $bug_row['count(*)'];
		}
	$tot = $okcount + $okhold + $oksug;
	  
	  
	$count_by_cat="select bcat, count(*) from qcuploadinfo where project_id='$proj_id' AND bugstatus='closed' group by 'bcat'";
	$retcat=mysql_query( $count_by_cat, $con );  
  
	while($bug_row_cat = mysql_fetch_assoc($retcat))  { 
		if($bug_row_cat['bcat'] == "media")
			$totmed = $bug_row_cat['count(*)'];
		else if($bug_row_cat['bcat'] == "editorial")
			$toted = $bug_row_cat['count(*)'];
		else if ($bug_row_cat['bcat'] == "functionality")
			$totfn = $bug_row_cat['count(*)'];
		else if ($bug_row_cat['bcat'] == "audio")
			$totau = $bug_row_cat['count(*)'];
		else if ($bug_row_cat['bcat'] == "simulation")
			$totsim = $bug_row_cat['count(*)'];
		else if ($bug_row_cat['bcat'] == "suggesstion")
			$totsug = $bug_row_cat['count(*)'];
	}
    /*$countok="select count(*) from qcuploadinfo where project='$proj' AND bugstatus='ok as is'";
    $retok = mysql_query( $countok, $con );
    $rowok = mysql_fetch_assoc($retok); 
    $okcount = $rowok['count(*)'];
    
    $counthold="select count(*) from qcuploadinfo where project='$proj' AND bugstatus='hold'";
    $rethold = mysql_query( $counthold, $con );
    $rowhold = mysql_fetch_assoc($rethold); 
    $okhold = $rowhold['count(*)'];
    
    $countsug="select count(*) from qcuploadinfo where project='$proj' AND bugstatus='suggesstion'";
    $retsug = mysql_query( $countsug, $con );
    $rowsug = mysql_fetch_assoc($retsug); 
    $oksug = $rowsug['count(*)'];
    
    $counttot="select count(*) from qcuploadinfo where project='$proj'";
    $rettot=mysql_query( $counttot, $con );  
    $rowtot = mysql_fetch_assoc($rettot);
    $tot=$rowtot['count(*)'];
    
    $countmed="select count(*) from qcuploadinfo where project='$proj' AND bcat='media' AND bugstatus='closed'";
    $retmed=mysql_query( $countmed, $con );  
    $rowmed = mysql_fetch_assoc($retmed);
    $totmed=$rowmed['count(*)'];
    
    $counted="select count(*) from qcuploadinfo where project='$proj' AND bcat='editorial' AND bugstatus='closed'";
    $reted=mysql_query( $counted, $con );  
    $rowed = mysql_fetch_assoc($reted);
    $toted=$rowed['count(*)'];
    
    $countfn="select count(*) from qcuploadinfo where project='$proj' AND bcat='functionality' AND bugstatus='closed'";
    $retfn=mysql_query( $countfn, $con );  
    $rowfn = mysql_fetch_assoc($retfn);
    $totfn=$rowfn['count(*)'];
    
    $countau="select count(*) from qcuploadinfo where project='$proj' AND bcat='audio' AND bugstatus='closed'";
    $retau=mysql_query( $countau, $con );  
    $rowau = mysql_fetch_assoc($retau);
    $totau=$rowau['count(*)'];
    
    $countsim="select count(*) from qcuploadinfo where project='$proj' AND bcat='simulation' AND bugstatus='closed'";
    $retsim=mysql_query( $countsim, $con );  
    $rowsim = mysql_fetch_assoc($retsim);
    $totsim=$rowsim['count(*)'];
    
    $countsug="select count(*) from qcuploadinfo where project='$proj' AND bcat='suggesstion' AND bugstatus='closed'";
    $retsug=mysql_query( $countsug, $con );  
    $rowsug = mysql_fetch_assoc($retsug);
    $totsug=$rowsug['count(*)'];
    
    $fmqr="select fmone,fmtwo,fmthree,fmfour from projectmaster where projectname='$proj'";
    $retfm=mysql_query( $fmqr, $con );  
    $rowfm = mysql_fetch_assoc($retfm);
    $fmone=$rowfm['fmone'];
    $fmtwo=$rowfm['fmtwo'];
    $fmthree=$rowfm['fmthree'];
    $fmfour=$rowfm['fmfour']; 
    
    $qc="select qc from qcuploadinfo where project='$proj'";
    $retqc=mysql_query( $qc, $con );  
    $rowqc = mysql_fetch_assoc($retqc);
    $totqc=$rowqc['qc'];
    
    $pm="select projectmanager from projectmaster where projectname='$proj'";
    $retpm=mysql_query( $pm, $con );  
    $rowpm = mysql_fetch_assoc($retpm);
    $totpm=$rowpm['projectmanager']; */ 

      $activity_csv .= str_replace(",", ";", $proj) . ",";
      $activity_csv .= str_replace(",", ";", $totpm) . ",";
      $activity_csv .= str_replace(",", ";", $revdt) . ",";
      $activity_csv .= str_replace(",", ";", $totau) . ",";
      $activity_csv .= str_replace(",", ";", $toted) . ",";
      $activity_csv .= str_replace(",", ";", $totfn) . ",";
      $activity_csv .= str_replace(",", ";", $totmed) . ",";
      $activity_csv .= str_replace(",", ";", $totsim) . ",";
      $activity_csv .= str_replace(",", ";", $totsug) . ",";
      $activity_csv .= str_replace(",", ";", $okcount) . ",";
      $activity_csv .= str_replace(",", ";", $okhold) . ",";
      $activity_csv .= str_replace(",", ";", $count) . ",";
      $activity_csv .= str_replace(",", ";", $tot) . ",";
      $activity_csv .= str_replace(",", ";", $fmone) . ",";
      $activity_csv .= str_replace(",", ";", $fmtwo) . ",";
      $activity_csv .= str_replace(",", ";", $fmthree) . ",";
      $activity_csv .= str_replace(",", ";", $fmfour) . ",";
      $activity_csv .= str_replace(",", ";", $totqc) . ",";
      $activity_csv .= "\n";       
    }  
}

$csv_output .= $header_csv;
$csv_output .= $activity_csv;
define('FILE_NAME', 'Categorized_Report_');
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