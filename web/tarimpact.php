<?php
$r=$_GET["r"];
$p=$_GET["p"];

$r = strtotime($r);
$r = date( 'Y-m-d', $r );

//echo "Q :".$q;
//echo "R :".$r;

include('config.php');

$query = "UPDATE actionitem SET targetdate='$r' where actionid='$p'";
//echo $query;

$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "Row updated with New Target Date For actionid :"."<b>".$p."</b>";

mysql_close($con);

?> 