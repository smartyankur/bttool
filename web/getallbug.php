<?php
$q=$_GET["q"];

include('config.php');
//echo "Hi    :".$q;

$sql="SELECT * FROM bugreport WHERE projectname = '".$q."'";
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
<tr><th>Projectname</th><th>Bug ID</th><th>Phase</th><th>Reviewer</th><th>Review Date</th><th>Module</th><th>Topic</th><th>Page</th><th>Desc</th><th>Status</th><th>Change Status</th><th>Update Status</th><th>Delete Record</th></tr>
<?php
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['projectname']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['id']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['phase']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['reviewer']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['reviewdate']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['module']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['topic']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['pagenumber']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['descr']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['status']."</div>"."</td>";
  ?>
  <TD><select id="<?php echo $row['id'];?>" size="1">
  <option value="select" selected>Select</option>
  <option value="open">open</option>
  <option value="close">close</option>
  <option value="wip">wip</option>
  </select></TD>
  <TD><input type="button" value="Change Status" onclick="submitresponse(<?php echo $row['id'];?>)"></TD>
  <TD><input type="button" onClick="deleter(<?php echo $row['id'];?>)" value="Delete Record"></TD>
  <?php
  }
mysql_close($con);
?> 