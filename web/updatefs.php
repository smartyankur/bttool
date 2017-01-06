<?php
$q=$_GET["q"];
$r=$_GET["r"];
$p=$_GET["p"];
$currentdate= date("Y-m-d");

//echo "status  :".$p."    "."actionid  :".$q."   "."finding  :".$r."    ".$currentdate;

include('config.php');
$q = mysql_real_escape_string(trim($q));
$r = mysql_real_escape_string($r);

//echo "r value:".$r;
//echo "</br>";

$query = "UPDATE actionitem SET finding = '".$r."',nctype='".$p."',sepgcomdate='".$currentdate."' WHERE actionid = '".$q."'";
//echo $query;
$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "Row updated with new finding desc. for actionid :"."<b>".$q."</b>";

mysql_close($con);

?> 