<?php
$q=$_GET["q"];
$auditee=$_GET["r"];
$pro_id=$_GET["pro_id"];

include("config.php");
//echo "Hi    :".$q;

$sql="SELECT * FROM qcuploadinfo WHERE project_id = '".$pro_id."'";
//echo $sql;

$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('No open item was found with this project name.');
}

echo "---------------------------------------------------------------------------------------------------------------------";

while($row = mysql_fetch_array($result))
  {
  echo "<br>";
  echo "Bug ID :".$row['id']."</br>";
  //echo "Auditee :".$auditee."</br>";
  echo "Phase :".$row['phase']."</br>";
  echo "Module :".$row['module']."</br>";
  echo "Topic :".$row['topic']."</br>";
  echo "Screen :".$row['screen']."</br>";
  echo "Description :".$row['bdr']."</br>";
  echo "QC :".$row['qc']."</br>";
  echo "Asignee :".$row['asignee']."</br>";
  echo "QC Comment :".$row['qccomment']."</br>";
  echo "Round :"."<b>".$row['round']."</b>"."</br>";
  echo "Dev Comment :".$row['devcomment']."</br>";
  echo "Bug Status :".$row['bugstatus']."</br>";
  echo "<textarea id=".$row['id']." rows="."4"." maxlength="."160"." cols="."30"."></textarea>";
  echo " ";
  echo "<select id="."round".$row['id'].">"; 
  ?>
  <option size=30 selected>Select</option>
  <option value="R2">R2</option>
  <option value="R3">R3</option>
  <option value="R4">R4</option>
  </select>
  <input type="button" value="Submit Response" onclick="submitresponse(<?php echo $row['id']?>)">
  <?php
  echo "<br>";
  echo "--------------------------------------------------------------------------------------------------------------------";
  }
mysql_close($con);
?> 