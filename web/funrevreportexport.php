<?php
include("config.php");


if( isset($_REQUEST['cat']) && !empty($_REQUEST['cat']) ){
  $bugcategory = $_REQUEST['cat'];
}else{
  $bugcategory = 'Instructional Design';
}


$activity_csv = '';
$header_csv   = '';
$csv_output   = "Functional Review Interface Report" . ",";
$csv_output  .= "\n";

$header_csv .= "S. No., Project, Reviewer, Reviewee";

$catArray = array('Instructional Design', 'Media', 'Functionality');
if($bugcategory != 'all'){
  $header_csv .= ", ". ucwords($bugcategory);
  $selectSubCategories = "SELECT subcat FROM catmaster WHERE cat='$bugcategory'";
  $querySubCategories  = mysql_query($selectSubCategories);
  while($fetchSubCategories = mysql_fetch_array($querySubCategories)){
    $header_csv .= ", ". ucwords($fetchSubCategories['subcat']);
  }
}else{
  $header_csv .= ", Instructional Design";
  $header_csv .= ", Media";
  $header_csv .= ", Functionality";
}

$header_csv .= "\n";

$i=1;

$selectFunrevreport  = "SELECT `project_id` ,`project`, `reviewer`, `reviewee`, `cat`, COUNT(`cat`) AS `ttlcat` FROM `blobt` 
WHERE `cat`='" . $bugcategory . "' 
GROUP BY `project`, `reviewer`, `reviewee`, `cat` 
ORDER BY `project` ASC";
$queryFunrevreport   = mysql_query($selectFunrevreport);
$numrowsFunrevreport = mysql_num_rows($queryFunrevreport);
if( !empty($numrowsFunrevreport) ){
  while($fetchFunrevreport  = mysql_fetch_array($queryFunrevreport)){
    $activity_csv .= str_replace(",", ";", $i) . ",";
    $activity_csv .= str_replace(",", ";", $fetchFunrevreport['project']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchFunrevreport['reviewer']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchFunrevreport['reviewee']) . ",";
    $activity_csv .= str_replace(",", ";", $fetchFunrevreport['ttlcat']) . ",";      
                   
    if($bugcategory != 'all'){
      $selectSubCategories = "SELECT subcat FROM catmaster WHERE cat='$bugcategory'";
      $querySubCategories  = mysql_query($selectSubCategories);
      while($fetchSubCategories  = mysql_fetch_array($querySubCategories)){
        $selectSCV = "SELECT COUNT(subcat) AS ttlsubcat FROM blobt WHERE project_id='".$fetchFunrevreport['project_id']."' AND reviewer='".$fetchFunrevreport['reviewer']."' AND reviewee='".$fetchFunrevreport['reviewee']."' AND cat='".$bugcategory."' AND subcat='".$fetchSubCategories['subcat']."'";
        $querySCV  = mysql_query($selectSCV);
        $fetchSCV  = mysql_fetch_assoc($querySCV);
            
        $activity_csv .= str_replace(",", ";", $fetchSCV['ttlsubcat']) . ",";
      }
    }else{
      foreach($catArray as $catName){
        $queryOther = mysql_query("SELECT count(cat) as ttlcat FROM `blobt` WHERE project_id = '" . $fetchFunrevreport['project_id'] . "' AND reviewer='" . $fetchFunrevreport['reviewer'] . "' AND reviewee = '" . $fetchFunrevreport['reviewee'] . "' AND cat = '" . $catName . "'");      
        $fetchOther  = mysql_fetch_array($queryOther);
            
        $activity_csv .= str_replace(",", ";", $fetchOther['ttlcat']) . ",";
      }
    }
    $activity_csv .= "\n";       
    $i++;
  }
}else{
    $activity_csv .= "No result found.\n";
}  

$csv_output .= $header_csv;
$csv_output .= $activity_csv;

//$randnum = rand(1, 50);
define('FILE_NAME', 'Funrev_Report_');
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