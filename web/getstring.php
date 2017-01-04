<?php

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

$q=$_GET["q"];
$r=mysql_real_escape_string($_GET["r"]);

mysql_select_db("audit", $con);
//echo "Hi    :".$q;
//"SELECT * FROM `table_name` WHERE `description` LIKE '%$search%'"; 
$sql="SELECT * FROM mommaster WHERE projectname = '".$q."' and (actionitem LIKE '%$r%' or agenda LIKE '%$r%')";
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
  echo "<td>"."<div style="."width:100;height:50;overflow:auto>".$row['agenda']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:50;overflow:auto>".$row['meetingdate']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:50;overflow:auto>".$row['type']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:50;overflow:auto>".$row['participants']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:50;overflow:auto>".$row['discussionpoint']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:50;overflow:auto>".$row['actionitem']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:50;overflow:auto>".$row['owner']."</div>"."</td>";
  //echo "<td>".$row['momid']."</td>";
  if($row['targetdate']=="1970-01-01"){
  echo "<td>"."<div style="."width:100;height:50;overflow:auto>"."TBD"."</div>"."</td>";
  }
  else{
  echo "<td>"."<div style="."width:100;height:50;overflow:auto>".$row['targetdate']."</div>"."</td>";
  }
  echo "<td>"."<div style="."width:100;height:50;overflow:auto>".$row['risk']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:50;overflow:auto>".$row['status']."</div>"."</td>";
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