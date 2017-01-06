<?php
$q=$_GET["q"];
$r=$_GET["r"];
$s=$_GET["s"];
$t=$_GET["t"];
$u=$_GET["u"];
$v=$_GET["v"];
$w=$_GET["w"];
$x=$_GET["x"];

include('config.php');

$SDate=strtotime($q);
$SDate = date( 'Y-m-d H:i:s', $SDate );

$EDate=strtotime($r);
$EDate = date( 'Y-m-d H:i:s', $EDate );

$RDate=strtotime($w);
$RDate = date( 'Y-m-d H:i:s', $RDate );

$currentdate = date('Y-m-d h:i:s', time());

if($SDate>$EDate) {echo "Start Date can't be after End Date"; exit();}
if($SDate>$t || $EDate>$t) {echo "Start Date or End Date can't be after delivery date"; exit();}
if($SDate<$w || $EDate<$w) {echo "Start Date or End Date can't be before receive date"; exit();}

$update="update accept set SDate='$SDate',DDate='$EDate',entrydate='$currentdate',user='$s',effort='$v' where masterid='$x' AND indx='$u'";
//echo $update;

if (mysql_query($update))
       {
		echo "Row updated....";
	   }
else
       {
		die (mysql_error());
		exit();
	   }

mysql_close($con);
?> 