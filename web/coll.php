<?php
$q=$_GET["q"];
$s=$_GET["s"];
$currentdate= date("Y-m-d");

include("config.php");
$q = mysql_real_escape_string($q);

$squery="select issue from collateral where project='$q'and issue='$s'";
$sresult=mysql_query($squery) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
$count = mysql_num_rows($sresult);

if($count>0)
{
 die("This issue already exists");
}

$query = "insert into collateral(project,issue) values('$q','$s')";
$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());

echo "Record created";
mysql_close($con);

?> 