<?php
$q=$_GET["q"];
$r=$_GET["r"];
$s=$_GET["s"];//user
$t=$_GET["t"];//user
$mydate = date('Y-m-d h:i:s', time());
include('config.php');
$q = mysql_real_escape_string($q);
$r = mysql_real_escape_string($r);

$query = "UPDATE uploadinfo SET status = '$r', whochangedstatus='$s',whenchangedstatus=SYSDATE(),reason='$t' WHERE id = '$q'";

$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "Status updated for bug id #".$q;

mysql_close($con);

?> 