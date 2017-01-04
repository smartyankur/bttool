<?php
$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);

$a=mysql_real_escape_string($_GET["a"]); //logged
$b=mysql_real_escape_string($_GET["b"]); //dept
$c=mysql_real_escape_string($_GET["c"]); //func
$d=mysql_real_escape_string($_GET["d"]); //peer
$e=$_GET["e"]; //Q1
$f=$_GET["f"]; //Q2
$g=$_GET["g"]; //Q3
$h=$_GET["h"]; //Q4
$i=$_GET["i"]; //Q5
$j=$_GET["j"]; //Q6
$k=$_GET["k"]; //Q7
$l=$_GET["l"]; //Q8
$m=$_GET["m"]; //Q9
$n=$_GET["n"]; //Q10
$o=$_GET["o"]; //Q11

$cquery="select * from surveyreport where reviewee='$d' and respondent='$a'";
$cresult=mysql_query($cquery) or die (mysql_error());

if($crow = mysql_fetch_array($cresult))
{
 echo "<b>"."This Entry Already Exists"."</b>";
 exit();
}


$qname="select * from surveylogin where empid='$d'";
$qres=mysql_query($qname) or die (mysql_error());
while($qrow = mysql_fetch_assoc($qres)) 
{ 
 $revieweename=$qrow['name'];
}

$query = "insert into surveyreport(reviewee,Q1,Q2,Q3,Q4,Q5,Q6,Q7,Q8,Q9,Q10,Q11,respondent,dept,function) values('".$d."','".$e."','".$f."','".$g."','".$h."','".$i."','".$j."','".$k."','".$l."','".$m."','".$n."','".$o."','".$a."','".$b."','".$c."')";
$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "<b>"."Row createdted for ".$revieweename."...If you want to give response for another peer just select the name and proceed...."."</b>";
echo "</br>";
mysql_close($con);

?> 