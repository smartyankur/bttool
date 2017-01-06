<?php
$q=$_POST["string"];

include('config.php');
//echo "Hi    :".$q;

//$query = "SELECT * FROM `table_name` WHERE `description` LIKE '%$search%'"; 

$sql="SELECT * FROM mommaster WHERE actionitem LIKE '"."%".$q."%"."'";
//echo $sql;

$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('Data Not Found');
}

//echo "---------------------------------------------------------------------------------------------------------------------";
echo "<table width='100%' border='1' cellspacing='0' cellpadding='0'>";
?>
<tr><th>Agenda</th><th>Meeting date</th><th>Meeting Type</th><th>Participants</th><th>Discussion Point</th><th>Action Item</th><th>Owner</th><th>Target Date</th><th>Risk</th><th>Current Status</th><th>Change Status</th><th>Click To Change </th></tr>
<?php
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>".$row['agenda']."</td>";
  echo "<td>".$row['meetingdate']."</td>";
  echo "<td>".$row['type']."</td>";
  echo "<td>".$row['participants']."</td>";
  echo "<td>".$row['discussionpoint']."</td>";
  echo "<td>".$row['actionitem']."</td>";
  echo "<td>".$row['owner']."</td>";
  //echo "<td>".$row['momid']."</td>";
  if($row['targetdate']=="1970-01-01"){
  echo "<td>"."TBD"."</td>";
  }
  else{
  echo "<td>".$row['targetdate']."</td>";
  }
  echo "<td>".$row['risk']."</td>";
  echo "<td>".$row['status']."</td>";
  ?>
  <TD><select id="<?php echo $row['momid'];?>" size="1">
  <option value="select" selected>Select</option>
  <option value="open">Open</option>
  <option value="close">Closed</option>
  <option value="wip">WIP</option>
  </select></TD>
  <TD><input type="button" value="Change Status" onclick="submitresponse(<?php echo $row['momid'] ?>)"></TD>
  <?php
  echo "</tr>";
  //echo "--------------------------------------------------------------------------------------------------------------------";
  }
mysql_close($con);
?> 