<?php
$q=$_GET["q"];

include('config.php');
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