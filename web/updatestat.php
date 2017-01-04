<?php
$q=$_GET["q"];
$r=$_GET["r"];

//echo "momid:".$q."    "."status".$r;

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
$q = mysql_real_escape_string($q);
$r = mysql_real_escape_string($r);

$query = "UPDATE mommaster SET status = '$r' WHERE momid = '$q'";
//echo $query;
$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "Status updated with response for momid :"."<b>".$q."</b>";

mysql_close($con);
?> 