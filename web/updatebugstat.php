<?php
$q=$_GET["q"];
$r=$_GET["r"];
$s=$_GET["s"];

//echo "bugid:".$q."    "."status".$r;

include('config.php');
$q = mysql_real_escape_string($q);
$r = mysql_real_escape_string($r);
$mydate = date('Y-m-d h:i:s', time());

$query = "UPDATE qcuploadinfo SET bugstatus = '$r',whenchangedstatus='$mydate',whochangedstatus='$s' WHERE id = '$q'";
//echo $query;
$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "Row updated with new bug status for bugid :"."<b>".$q."</b>";

mysql_close($con);

?> 