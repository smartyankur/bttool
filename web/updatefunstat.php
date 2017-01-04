<?php
$q=$_GET["q"];
$r=$_GET["r"];
$s=$_GET["s"];

include("config.php");
$q = mysql_real_escape_string($q);
$r = mysql_real_escape_string($r);
$s = mysql_real_escape_string($s);

$query = "UPDATE blobt SET status = '$r',comment='$s' WHERE id = '$q'";
//echo $query;
$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "Row updated with new bug status for id :"."<b>".$q."</b>";

mysql_close($con);

?> 