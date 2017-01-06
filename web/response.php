<?php
$user=$_GET["s"];
$q=$_GET["q"];
$r=$_GET["r"];
$currentdate= date("Y-m-d");

//echo $q."   ".$r."  ".$currentdate;

include('config.php');
$q = mysql_real_escape_string($q);
$r = mysql_real_escape_string($r);


$check = "select auditeecomment from actionitem WHERE actionid = '$q'";
$retval = mysql_query( $check, $con );
$row = mysql_fetch_array($retval);

if ($row['auditeecomment']<>NULL) 
   {
      die('You Have Already Given Response :'.$row['auditeecomment']);
   }
  

  $query = "UPDATE actionitem SET auditeecomment = '$r',auditeecomdate='$currentdate',auditee='$user' WHERE actionid = '$q'";
  //echo $query;
  $result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
  echo "Row updated with Response For actionid :".$q;

mysql_close($con);

?> 