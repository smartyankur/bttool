<?php
$upload_path = './qcfiles/';
$q=$_GET["q"];
$auditee=$_GET["r"];

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
//echo "Hi    :".$q;

$sql="SELECT * FROM qcuploadinfo WHERE project = '".$q."' AND (bugstatus='open' OR bugstatus='hold' OR bugstatus='reopened')";

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
  echo "View attachment :".'<a href="'.$upload_path.$row['filepath'].'" title="Your File">'.$row['filepath'].'</a>'."</br>";
  echo "<textarea id=".$row['id']." rows="."4"." maxlength="."160"." cols="."30"."></textarea>";
  echo " Change Status ";
  echo "<select id="."stat".$row['id'].">";
  ?>
  <option size=30 selected>Select</option>
  <option value="fixed">Fixed</option>
  <option value="hold">Hold</option>
  <option value="ok as is">Ok As Is</option>
  </select></TD>
  <input type="button" value="Submit Response" onclick="submitresponse(<?php echo $row['id']?>)">
  <?php
  echo "<br>";
  echo "--------------------------------------------------------------------------------------------------------------------";
  }
mysql_close($con);
?> 