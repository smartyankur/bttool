<?php
error_reporting(0);
$q=$_GET["q"];

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
//echo "Hi    :".$q;

$sql="SELECT * FROM scm WHERE project = '".$q."'";
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
<tr><th>ID</th><th>Project</th><th>Finding</th><th>Target Date</th><th>Logged By</th><th>Logged On</th><th>Current Status</th><th>Update Status</th><th>Change Status</th></tr>
<?php
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['id'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['project'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['finding'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['targetdate'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['user'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['loggedon'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['status'])."</div>"."</td>";
  ?>
  <TD><select id="<?php echo $row['id'];?>" size="1">
  <option value="select" selected>Select</option>
  <option value="open">Open</option>
  <option value="closed">Closed</option>
  </select></TD>
  <TD><input type="button" value="Change Status" onclick="submitresponse(<?php echo $row['id'] ?>)"></TD>
  <?php
  }
mysql_close($con);
?> 