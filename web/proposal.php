<?php
$q=$_GET["q"];
$r=$_GET["r"];
$s=$_GET["s"];
$currentdate= date("Y-m-d");

//echo $q."   ".$r."  ".$currentdate;

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
$q = mysql_real_escape_string($q);
$user=$r;

$query = "insert into pip(name,proposal,date,practice) values('$user','$q','$currentdate','$s')";
//echo $query;
//echo "</br>";
$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());

$squery="select pipid from pip where name='".$user."'and proposal='".$q."' and date='".$currentdate."'";
//echo $squery;
//echo "</br>";
$sresult=mysql_query($squery) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());

while($srow = mysql_fetch_array($sresult))
{
 $id = $srow['pipid'];
}

$mquery = "insert into piphistory(pipid,date) values('$id','$currentdate')";
//echo $mquery;
//echo "</br>";

$mresult = mysql_query($mquery) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "Row inserted with Response From:".$user;

mysql_close($con);

?> 