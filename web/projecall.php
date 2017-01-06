<?php
$q=$_GET["q"];

include('config.php');
$sql="SELECT * FROM projection where project='$q'";
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
<tr><th>ID</th><th>Project</th><th>Scope</th><th>Effort</th><th>Del Date</th><th>FS Impacted</th><th>Planned Testing Date</th><th>AM/PM</th><th>Delete</th></tr>
<?php
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['id']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['project']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['scope']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['effort']."</div>"."</td>"; 
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['ddate']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['fsimpact']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['tdate']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['ampm']."</div>"."</td>";
  ?>
  <TD><input type="button" value="Delete" onclick="submitresponse(<?php echo $row['id'] ?>)"></TD>
  <?php
  echo "<tr>";
  }
echo "</table>";
mysql_close($con);
?> 