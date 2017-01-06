<?php
$q=$_GET["q"];
$r=$_GET["r"];
$p=$_GET["p"];

$q = strtotime($q);
$q = date( 'Y-m-d', $q );

$r = strtotime($r);
$r = date( 'Y-m-d', $r );

//echo "Q :".$q;
//echo "R :".$r;

include('config.php');

$query = "UPDATE actionitem SET discussiondate='$q',targetdate='$r' where actionid='$p'";
//echo $query;

$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "Row updated with New Dates For actionid :"."<b>".$p."</b>";

mysql_close($con);

?> 