<?php
$q=$_GET["q"]; //description
$r=$_GET["r"]; //cost
$s=$_GET["s"]; //expense type
$t=$_GET["t"]; //date
$u=$_GET["u"]; //mop

$date=strtotime($t);
$date = date( 'Y-m-d', $date );

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
$q = mysql_real_escape_string($q);
$r = mysql_real_escape_string($r);

$query = "insert into manual(descr,cost,date,type,mop) values('$q','$r','$date','$s','$u')";
$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
mysql_close($con);
echo "Row inserted for  ".$q." and ".$r." and type ".$s;
?> 