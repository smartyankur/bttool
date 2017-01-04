<?php
$q=$_GET["q"];
$r=$_GET["r"];
$s=$_GET["s"];
$devreason=$_GET["devreason"];

include("config.php");

$s=mysql_real_escape_string($s);

$query = "UPDATE lmsblob SET status='$r', devcomment='$s', devreason='$devreason' WHERE id = '$q'";
$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "Row updated with new bug status for id :"."<b>".$q."</b>";

mysql_close($con);

?> 