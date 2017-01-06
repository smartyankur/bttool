<?php
$a=$_GET["a"];
$b=$_GET["b"];
$c=$_GET["c"];
$w=strtotime($c);
$x = date( 'Y-m-d', $w );
$d=$_GET["d"];
$mydate = date('Y-m-d h:i:s', time());

include('config.php');
$b = mysql_real_escape_string($b);

//echo "project :".$a."finding :".$b."targetdate :".$x."user :".$d;

$qm="insert into scm(project,finding,targetdate,user,loggedon) values('$a','$b','$x','$d','$mydate')";
//echo $qm;
$resm=mysql_query($qm) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "SCM action item createdted for :".$a;
echo "</br>";
mysql_close($con);

?> 