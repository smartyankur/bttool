<?php
$q=$_GET["q"];
$pro_id=$_GET["pro_id"];
$auditee=$_GET["r"];

include("config.php");
$sql="SELECT * FROM actionitem WHERE status='closed' and project_id = '".$pro_id."'";

$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('No closed action item was found with this project name.');
}

echo "---------------------------------------------------------------------------------------------------------------------";

while($row = mysql_fetch_array($result))
  {
  echo "<br>";
  echo "Action ID :".$row['actionid']."</br>";
  //echo "Auditee :".$auditee."</br>";
  echo "Finding :".$row['finding']."</br>";
  echo "Owner :".$row['owner']."</br>";
  echo "Discussion Date :".$row['discussiondate']."</br>";
  echo "Auditee Comment :".$row['auditeecomment']."</br>";
  echo "Target Date :".$row['targetdate']."</br>";
  echo "NC Type :".$row['nctype']."</br>";
  echo "SEPG Comment :".$row['sepgcomment']."</br>";
  echo "Status :".$row['status']."</br>";
  echo "--------------------------------------------------------------------------------------------------------------------";
  }
mysql_close($con);
?> 