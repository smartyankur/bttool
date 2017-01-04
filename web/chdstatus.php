<?php
$q=$_GET["q"];
$r=$_GET["r"];

include("config.php");

$query  = "UPDATE tbl_functional_review SET status = '$r' WHERE id = '$q'";
$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "CHD status has been changed successfully";

mysql_close($con);

?> 