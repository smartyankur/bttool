<?php
$q=$_GET["q"];
include('config.php');
$sql="Delete FROM projection where id='$q'";
$result = mysql_query($sql);
echo "Row Deleted";
mysql_close($con);
?> 