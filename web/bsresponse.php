<?php
$user=$_GET["s"]; //devresponding
$q=$_GET["q"];  //id 
$r=$_GET["r"];  //bugstatus
$t=$_GET["t"]; //qccomment
$currentdate= date('Y-m-d h:i:s', time()); //devrespdate

//echo $q."   ".$r."  ".$currentdate;

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
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

if(trim($t)<>"")
{
$query = "UPDATE qcuploadinfo SET whochangedstatus='$user',whenchangedstatus='$currentdate',bugstatus='$r',qccomment='$t' WHERE id = '$q'";
}
else
{
$query = "UPDATE qcuploadinfo SET whochangedstatus='$user',whenchangedstatus='$currentdate',bugstatus='$r' WHERE id = '$q'";
}
//echo $query;
$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "Row updated with Response For id :".$q;
 
mysql_close($con);
?> 