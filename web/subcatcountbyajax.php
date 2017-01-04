<?php
$pname      = $_GET['pname'];
$rvwrname   = $_GET['rvwrname'];
$rvwename   = $_GET['rvwename'];
$subcatname = $_GET['subCatName'];

include("config.php");

$query  = "SELECT COUNT(subcat) AS ttlSubCats FROM blobt WHERE subcat='$subcatname' AND project='$pname' AND reviewer='$rvwrname' AND reviewee='$rvwename'";
$retval = mysql_query($query, $con);
$row    = mysql_fetch_assoc($retval);
if( $row['ttlSubCats'] != 0 ){
  echo $row['ttlSubCats'];
}else{
 echo 0;
}
?> 