<?php
$q=$_GET["q"];
$r=$_GET["r"];

//echo "momid:".$q."    "."status".$r;

include('config.php');
$q = mysql_real_escape_string($q);
$r = mysql_real_escape_string($r);

$query = "UPDATE bugreport SET status = '$r' WHERE id = '$q'";
//echo $query;
$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "Status updated for bugid :"."<b>".$q."</b>";
echo "</br>";
mysql_close($con);
?> 