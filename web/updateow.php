<?php
$q=$_GET["q"];
$r=$_GET["r"];

//echo "actionid  :".$q."    "."value  :".$r;
$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
$q = mysql_real_escape_string(trim($q));
$r = mysql_real_escape_string($r);

//echo "r value:".$r;
//echo "</br>";

$query = "UPDATE actionitem SET owner = '".$r."' WHERE actionid = '".$q."'";
//echo $query;
$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "Row updated with new owner for actionid :"."<b>".$q."</b>";

mysql_close($con);
?> 