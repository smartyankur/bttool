<?php
$q=$_GET["q"];
$r=$_GET["r"];

//echo "bugid:".$q."    "."status".$r;

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
$q = mysql_real_escape_string($q);
$r = mysql_real_escape_string($r);

$query = "UPDATE qcuploadinfo SET coursestatus = '$r' WHERE id = '$q'";
//echo $query;
$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "Row updated with new course status for actionid :"."<b>".$q."</b>";

mysql_close($con);

?> 