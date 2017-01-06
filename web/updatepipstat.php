<?php
$q=$_GET["q"]; //id
$r=$_GET["r"]; //status

//echo "momid:".$q."    "."status".$r;

include('config.php');
$q = mysql_real_escape_string($q);
$r = mysql_real_escape_string($r);

$query = "UPDATE piphistory SET implemented = '$r' WHERE pipid = '$q'";
//echo $query;
$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "Implementation Status updated with response for pipid :"."<b>".$q."</b>";

mysql_close($con);
?> 