<?php
$q=$_GET["q"];
$r=$_GET["r"];
$s=$_GET["s"];
$t=$_GET["t"];
$v=$_GET["v"];

echo "Meeting Title :".$v;

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
//echo "Hi    :".$q;

if($s=="all")
{
 $sql="SELECT * FROM mommaster WHERE projectname = '".$q."' and type='".$r."' and meetingdate='".$t."' and discussionpoint LIKE '%$v%'";
}
else
{
 $sql="SELECT * FROM mommaster WHERE projectname = '".$q."' and type='".$r."' and status='".$s."' and meetingdate='".$t."' and discussionpoint LIKE '%$v%'";
//echo $sql;
}

$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('Data Not Found');
}

//echo "---------------------------------------------------------------------------------------------------------------------";

$row = mysql_fetch_array($result);
$agen=$row['agenda'];
$participants=$row['participants'];
?>
<table width='35%' border='1' cellspacing='0' cellpadding='0'>
<tr><th align="left"><div style=width:100;height:53;overflow:auto>Project Name</div></th><th><div style=width:100;height:53;overflow:auto><font size="3" color="red"><?php echo $q; ?></font></div></th><th align="left"><div style=width:100;height:53;overflow:auto>Meeting Date</div></th><th><div style=width:100;height:53;overflow:auto><font size="3" color="red"><?php echo $t; ?></font></div></th></tr>
<tr><th align="left"><div style=width:100;height:53;overflow:auto>Agenda</div></th><th><div style=width:100;height:53;overflow:auto><font size="3" color="red"><?php echo $agen; ?></font></div></th><th align="left"><div style=width:100;height:53;overflow:auto>Participants</div></th><th><div style=width:100;height:53;overflow:auto><font size="3" color="red"><?php echo $participants; ?></font></div></th></tr>
</table>
<br>
<?php
echo "<table width='100%' border='1' cellspacing='0' cellpadding='0'>";
?>
<tr><th>Agenda</th><th>Meeting date</th><th>Meeting Type</th><th>Participants</th><th>Meeting Title</th><th>Action Item</th><th>Owner</th><th>Target Date</th><th>Risk</th><th>Current Status</th><th>Change Status</th><th>Click To Change </th></tr>
<?php
$result = mysql_query($sql);
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['agenda']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['meetingdate']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['type']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['participants']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['discussionpoint']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['actionitem']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['owner']."</div>"."</td>";
  //echo "<td>".$row['momid']."</td>";
  if($row['targetdate']=="1970-01-01"){
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>"."TBD"."</div>"."</td>";
  }
  else{
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['targetdate']."</div>"."</td>";
  }
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['risk']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['status']."</div>"."</td>";
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