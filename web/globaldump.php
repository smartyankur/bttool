<?php
$q=$_GET["q"];
$pro_id=$_GET["pro_id"];
$r=$_GET["r"];

$ddate = strtotime($r);
$ddateformat = date( 'Y-m-d', $ddate );

include("config.php");


$sql="SELECT * FROM actionitem WHERE status='open' and project_id = '".$pro_id."' and discussiondate='".$ddateformat."'";

$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('No action item was found');
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
  echo "Status :".$row['status']."</br>";
  echo "Auditee Comment :".$row['auditeecomment']."</br>";
  echo "<br>";
  echo "--------------------------------------------------------------------------------------------------------------------";
  }
mysql_close($con);

?> 