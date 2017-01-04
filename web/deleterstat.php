<?php
$q=$_GET["q"];
$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
$q = mysql_real_escape_string($q);

$query = "delete from bugreport where id = '$q'";
$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "Record deleted for bugid :"."<b>".$q."</b>";
echo "</br>";
mysql_close($con);
?> 