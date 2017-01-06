<?php
$q=$_GET["q"];

include('config.php');
echo "Hi    :".$q;
/*
$sql="SELECT * FROM actionitem WHERE status='open' and projectname = '".$q."'";
//echo $sql;

$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('No open action item was found with this project name.');
}

echo "---------------------------------------------------------------------------------------------------------------------";

while($row = mysql_fetch_array($result))
  {
  echo "<br>";
  echo "Action ID :".$row['actionid']."</br>";
  echo "Finding :".$row['finding']."</br>";
  echo "Discussion Date :".$row['discussiondate']."</br>";
  echo "Target Date :".$row['targetdate']."</br>";
  echo "SEPG Comment :".$row['sepgcomment']."</br>";
  echo "Status :".$row['status']."</br>";
  echo "<textarea id=".$row['actionid']." rows="."4"." cols="."30"."></textarea>";
  echo "--------------------------------------------------------------------------------------------------------------------";
  }
mysql_close($con);
*/
?> 