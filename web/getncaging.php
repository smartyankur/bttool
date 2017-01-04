<?php
$q=$_GET["q"];
$pro_id=$_GET["pro_id"];
$auditee=$_GET["r"];

include("config.php");


$sql="SELECT * FROM actionitem WHERE status='open' and project_id = '".$pro_id."'";

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
  echo "Owner :".$row['owner']."</br>";
  echo "Discussion Date :".$row['discussiondate']."</br>";
  echo "Auditee Comment :".$row['auditeecomment']."</br>";
  echo "Target Date :".$row['targetdate']."</br>";
  echo "NC Type :".$row['nctype']."</br>";
  echo "SEPG Comment :".$row['sepgcomment']."</br>";
  echo "Status :".$row['status']."</br>";
  echo "<textarea id=".$row['actionid']." rows="."4"." maxlength="."160"." cols="."30"."></textarea>";
  ?>
   <input type="button" value="Submit Response" onclick="submitresponse(<?php echo $row['actionid']?>)">
  <?php
  echo "<br>";
  echo "--------------------------------------------------------------------------------------------------------------------";
  }
mysql_close($con);
?> 