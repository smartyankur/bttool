<?php
$user=$_GET["s"]; //devresponding
$q=$_GET["q"];  //id 
$r=$_GET["r"];  //devcomment
$t=$_GET["t"];  //status
$currentdate= date('Y-m-d h:i:s', time()); //devrespdate


include("config.php");
$q = mysql_real_escape_string($q);
$r = mysql_real_escape_string($r);

/*
$check = "select auditeecomment from actionitem WHERE actionid = '$q'";
$retval = mysql_query( $check, $con );
$row = mysql_fetch_array($retval);

if ($row['auditeecomment']<>NULL) 
   {
      die('You Have Already Given Response :'.$row['auditeecomment']);
   }
*/  
$query = "UPDATE qcuploadinfo SET devcomment = '$r',devrespdate='$currentdate',devresponding='$user',whochangedstatus='$user',whenchangedstatus='$currentdate',bugstatus='$t' WHERE id = '$q'";

$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "Row updated with Response For id :".$q;
 
mysql_close($con);
?> 