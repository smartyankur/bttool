<?php
$q=$_GET["q"];

include('config.php');
//echo "Hi    :".$q;

$sql="SELECT * FROM projecttask WHERE project = '".$q."'";
//echo $sql;

$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('Data Not Found');
}

//echo "---------------------------------------------------------------------------------------------------------------------";
echo "<table width='100%' border='1' cellspacing='0' cellpadding='0' bordercolor=\"orangered\">";
?>
<tr class="table_text"><th>ID</th><th>Task</th><th>Type</th><th>Phase</th><th>Developer</th><th>Effort</th><th>Who Created</th><th>When Created</th><th>Status</th><th>Round</th><th>Send To QC</th><th>When Sent To QC</th></tr>
<?php
while($row = mysql_fetch_array($result))
  {
  echo "<tr class=\"table_text\">";
  echo "<td class=\"table_text\">"."<div style="."width:30;height:53;overflow:auto>".$row['id']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div style="."width:200;height:70;overflow:auto>".$row['task']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div style="."width:70;height:70;overflow:auto>".$row['type']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div style="."width:50;height:53;overflow:auto>".$row['phase']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div style="."width:100;height:53;overflow:auto>".$row['developers']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div style="."width:50;height:53;overflow:auto>".$row['effort']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div style="."width:100;height:53;overflow:auto>".$row['user']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div style="."width:100;height:53;overflow:auto>".$row['timestamp']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div style="."width:80;height:53;overflow:auto>".$row['status']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div style="."width:20;height:53;overflow:auto>".$row['round']."</div>"."</td>";
  ?>
  <TD class="table_text"><input type="button" class="button" value="Send To QC" onclick="sendtoqc(<?php echo $row['id']; ?>)"></TD>
  <?php
  echo "<td class=\"table_text\">"."<div style="."width:100;height:53;overflow:auto>".$row['whentoqc']."</div>"."</td>"; 
  echo "</tr>"; 
  }
mysql_close($con);
?> 