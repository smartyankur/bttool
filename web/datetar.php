<?php
$q=$_GET["q"];
$p=$_GET["p"];

$q = strtotime($q);
$q = date( 'Y-m-d', $q );

//echo "Target Date :".$q;
//echo "Action ID :".$p;


$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);

$query = "UPDATE actionitem SET targetdate='$q' where actionid='$p'";
//echo $query;

$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "Row updated with New Date For actionid :"."<b>".$p."</b>";

mysql_close($con);

?> 