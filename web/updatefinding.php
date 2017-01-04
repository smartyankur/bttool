<?php
$q=$_GET["q"];
$r=$_GET["r"];
$p=$_GET["p"];
$currentdate= date("Y-m-d");

//echo "status:".$p."    "."actionid".$q."   "."sepg comment".$r."    ".$currentdate;

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
$q = mysql_real_escape_string($q);
$r = mysql_real_escape_string($r);

$query = "UPDATE actionitem SET sepgcomment = '$r',status='$p',sepgcomdate='$currentdate' WHERE actionid = '$q'";
//echo $query;
$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "Row updated with SEPG Response For actionid :"."<b>".$q."</b>";

mysql_close($con);

?> 