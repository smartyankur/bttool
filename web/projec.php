<?php
$q=$_GET["q"]; //project
$s=$_GET["s"]; //planned effort
$t=$_GET["t"]; // planned date
$u=$_GET["u"]; //fsimpact
$v=$_GET["v"]; //planned test date
$w=$_GET["w"]; //am or pm
$x=mysql_real_escape_string(trim($_GET["x"]));

$currentdate= date("Y-m-d");

$con = mysql_connect("localhost","root","password");

if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);


$t=strtotime($t);
$t = date( 'Y-m-d H:i:s', $t );

$v=strtotime($v);
$v = date( 'Y-m-d H:i:s', $v );

//echo $q."*".$s."*".$t."*".$u."*".$v."*".$w;


$query = "insert into projection(project,effort,ddate,fsimpact,tdate,ampm,scope) values('$q','$s','$t','$u','$v','$w','$x')";
$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());

echo "Record created";
mysql_close($con);

?> 