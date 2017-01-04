<?php
$q=$_GET["q"];
$upload_path = './qcfiles/';
$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
//echo "Hi    :".$q;

$sql="SELECT * FROM qcuploadinfo WHERE project = '".$q."'";
//echo $sql;

$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('Data Not Found');
}

//echo "---------------------------------------------------------------------------------------------------------------------";
echo "<table width='50%' border='1' cellspacing='0' cellpadding='0'>";
?>
<tr><th>ID</th><th>Project</th><th>Phase</th><th>Module</th><th>Topic</th><th>Receive Date</th><th>Browser</th><th>Course Status</th><th>Select New Course Status</th><th>Submit Course Status</th><th>Bug Status</th><th>Select New Bug Status</th><th>Submit Bug Status</th><th>Last time when status was assigned</th><th>Last time who assigned status</th><th>Bug Cat</th><th>Severity</th><th>Bug Desc</th><th>Asignee</th><th>QC</th><th>Screen</th><th>Upload Date</th><th>Uploaded File</th><th>View</th><th>Root Cause</th><th>Corrective Action</th><th>Who did rca</th><th>Delete Bug</th></tr>
<?php
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['id'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['project'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['phase'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['module'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['topic'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['receivedate'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['browser'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['coursestatus'])."</div>"."</td>";
  ?>
  <TD><select id="<?php echo $row['id'];?>" size="1">
  <option value="select" selected>Select</option>
  <option value="accepted">Accepted</option>
  <option value="rejected">Rejected</option>
  </select></TD>
  <TD><input type="button" value="Change Status" onclick="submitresponse(<?php echo $row['id'] ?>)"></TD>
  <?php
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['bugstatus'])."</div>"."</td>";
  ?>
  <TD><select id="<?php echo "bug".$row['id'];?>" size="1">
  <option value="select" selected>Select</option>
  <option value="open">Open</option>
  <option value="closed">Closed</option>
  <option value="hold">Hold</option>
  </select></TD>
  <TD><input type="button" value="Change Status" onclick="submitbugresponse(<?php echo $row['id'] ?>)"></TD>
  <?php
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['whenchangedstatus'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['whochangedstatus'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['bcat'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['severity'])."</div>"."</td>"; 
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['bdr'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['asignee'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['qc'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['screen'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['uploaddate'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['filename'])."</div>"."</td>";
  echo "<td>"."<div style="."width:350;height:53;overflow:auto>".'<a href="'.htmlentities($upload_path).htmlentities($row['filepath']).'" title="Your File">'.$row['filepath'].'</a>'."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['rootcause'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['correctiveaction'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['whodidrca'])."</div>"."</td>";
  ?>
  <TD><input type="button" value="Delete" onclick="editbug(<?php echo $row['id'] ?>)"></TD>
  <?php
  }
mysql_close($con);
?> 