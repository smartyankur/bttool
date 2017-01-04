<?php
$q=$_GET["q"]; //bugid
$r=$_GET["r"]; //action
$p=$_GET["p"]; //root cause
$s=$_GET["s"]; //who did rca
$currentdate= date("Y-m-d");

//echo "status:".$p."    "."actionid".$q."   "."sepg comment".$r."    ".$currentdate;

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
$p = mysql_real_escape_string($p);
$r = mysql_real_escape_string($r);

$query = "UPDATE qcuploadinfo SET rootcause = '$p',correctiveaction='$r',whodidrca='$s' WHERE id = '$q'";
//echo $query;
$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "Row updated with rootcause and action for bugid :"."<b>".$q."</b>";

mysql_close($con);

?> 