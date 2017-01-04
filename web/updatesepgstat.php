<?php
$q=$_GET["q"]; //id
$r=$_GET["r"]; //sepg response

//echo "momid:".$q."    "."status".$r;

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
$q = mysql_real_escape_string($q);
$r = mysql_real_escape_string($r);
$current=date("Y-m-d");
$query = "insert into piphistory(status,pipid,date) values('$r','$q','$current')";
//echo $query;
$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "SEPG Review Status updated with response for pipid :"."<b>".$q."</b>";

mysql_close($con);
?> 