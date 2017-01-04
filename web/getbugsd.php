<?php
$upload_path = './qcfiles/';
$issuetype = $_GET["issuetype"];
$q         = $_GET["q"];
$auditee   = $_GET["r"];

include("config.php");

if($issuetype != 'any'){
  $sql = "SELECT * FROM qcuploadinfo WHERE project = '".$q."' and bugstatus = '".$issuetype."'";
}else{
  $sql = "SELECT * FROM qcuploadinfo WHERE project = '".$q."'";
}
$result = mysql_query($sql);
$count  = mysql_num_rows($result);

if($count==0){
  die('No '.$issuetype.' item was found with this project name.');
} else {
echo "<table cellpadding='0' cellspacing='0' border='1'>
	<tr>
	  <th>Bug ID</th>
	  <th>Severity</th>
	  <th>Phase</th>
	  <th>Module</th>
	  <th>Topic</th>
	  <th>Screen</th>
	  <th>Environment</th>	
	  <th>Description</th>
	  <th>QC</th>
	  <th>Asignee</th>
	  <th>QC Comment</th>
	  <th>Round</th>
	  <th>Dev Comment</th>
	  <th>Status</th>
	  <th>Category</th>
	  <th>View attachment</th>
	  <th>Submit Response</th>
	</tr>
	";
	while($row = mysql_fetch_array($result))
	  {
	  echo "<tr>";
	  echo "<td>".$row['id']."</td>";
	  echo "<td>".$row['severity']."</td>";
	  //echo "Auditee :".$auditee."</br>";
	  echo "<td>".$row['phase']."</td>";
	  echo "<td>".$row['module']."</td>";
	  echo "<td>".$row['topic']."</td>";
	  echo "<td>".$row['screen']."</td>";
	  echo "<td>".$row['browser']."</td>";	
	  echo "<td>".htmlspecialchars ($row['bdr'])."</td>";
	  echo "<td>".$row['qc']."</td>";
	  echo "<td>".$row['asignee']."</td>";
	  echo "<td>".$row['qccomment']."</td>";
	  echo "<td>"."<b>".$row['round']."</b>"."</td>";
	  echo "<td>".$row['devcomment']."</td>";
	  echo "<td>".$row['bugstatus']."</td>";
	  echo "<td>"."<b>".$row['bcat']."</b>"."</td>";
	  echo "<td>".'<a href="'.$upload_path.$row['filepath'].'" title="Your File">'.$row['filepath'].'</a>'."</td>";
	  echo "<td><textarea id=".$row['id']." rows="."4"." maxlength="."160"." cols="."30"."></textarea>";
	  echo " Change Status ";
	  echo "<select id="."stat".$row['id'].">";
	  ?>
	  <option size=30 selected>Select</option>
	  <option value="fixed">Fixed</option>
	  <option value="hold">Hold</option>
	  <option value="ok as is">Ok As Is</option>
	  </select>
	  <input type="button" value="Submit Response" onclick="submitresponse(<?php echo $row['id']?>)">
	  <?php
	  echo "</td>";
	  }
  echo "</table>";
}
mysql_close($con);
?> 