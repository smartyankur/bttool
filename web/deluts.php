<?php
$q=$_GET["q"];
include('config.php');
//echo "Hi    :".$q;
$sql="delete FROM utilization WHERE id = '".$q."'";
//echo $sql;
mysql_query($sql) or die (mysql_error());
echo "Deleted";
mysql_close($con);
?> 