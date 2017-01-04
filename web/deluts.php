<?php
$q=$_GET["q"];
$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("audit", $con);
//echo "Hi    :".$q;
$sql="delete FROM utilization WHERE id = '".$q."'";
//echo $sql;
mysql_query($sql) or die (mysql_error());
echo "Deleted";
mysql_close($con);
?> 