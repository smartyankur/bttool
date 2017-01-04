<?php
$q=$_GET["q"];
$currentdate= date("Y-m-d");

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
//echo "Hi    :".$q;

$sql="select * from actionitem where status='open' and targetdate<'$currentdate' and projectname= '$q';";
//echo $sql;

$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('It seems target dates for closure are not yet due.');
}

echo "---------------------------------------------------------------------------------------------------------------------";

while($row = mysql_fetch_array($result))
  {
  echo "<br>";
  echo "Action ID :".$row['actionid']."</br>";
  echo "Finding :".$row['finding']."</br>";
  echo "Discussion Date :".$row['discussiondate']."</br>";
  echo "Target Date :".$row['targetdate']."</br>";
  echo "NC Type :".$row['nctype']."</br>";
  echo "SEPG Comment :".$row['sepgcomment']."</br>";
  echo "Auditee Comment :".$row['auditeecomment']."</br>";
  echo "Status :".$row['status']."</br>";
  $diff = strtotime($currentdate) - strtotime($row['targetdate']);
  $diffdays = $diff/60/60/24;
  echo "NC Aging :".$diffdays."</br>";
  echo "--------------------------------------------------------------------------------------------------------------------";
  }
mysql_close($con);
?> 