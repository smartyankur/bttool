<?php

$r=$_GET["r"];
$p=$_GET["p"];

$r = strtotime($r);
$r = date( 'Y-m-d', $r );

echo "P :".$p;
echo "R :".$r;
/*
$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);

$query = "UPDATE actionitem SET discussiondate='$q',targetdate='$r' where actionid='$p'";
//echo $query;

$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "Row updated with New Dates For actionid :"."<b>".$p."</b>";

mysql_close($con);
*/
?> 