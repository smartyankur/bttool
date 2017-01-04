<?php
$q=$_GET["q"];

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
//echo "Hi    :".$q;

$sql="delete FROM qcuploadinfo where id='".$q."'";
//echo $sql;
if(mysql_query($sql))
{
 echo "row deleted with id:".$q;
}
else
{
 echo "delete failed";
}
mysql_close($con);
?> 