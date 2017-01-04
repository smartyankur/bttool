<?php
$q=$_GET["q"];

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
$sql="Delete FROM projection where id='$q'";
$result = mysql_query($sql);
echo "Row Deleted";
mysql_close($con);
?> 