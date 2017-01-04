<?php
error_reporting(0);
$q=$_GET["q"]; //project
$r=$_GET["r"];

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);

$sql="SELECT * FROM qcplan WHERE project = '".$q."'";
$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('Data Not Found');
}

echo "<table width='100%' border='1' cellspacing='0' cellpadding='0' bordercolor=\"orangered\">";
?>
<tr><th>Pckt ID</th><th>Task ID</th><th>Project</th><th>Task</th><th>QC</th><th>Start Date</th><th>End Date</th><th>Planned Effort</th><th>Status</th><th>Actual Effort</th><th>No Of Issues</th><th>Sent to Dev</th><th>Edit</th></tr>
<?php
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['masterid'])."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['id'])."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['project'])."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:200;height:53;overflow:auto>".htmlentities($row['task'])."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:70;height:53;overflow:auto>".htmlentities($row['qc'])."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['SDate'])."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['EDate'])."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['effort'])."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['status'])."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['actualeffort'])."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['noofissues'])."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['senttodev'])."</div>"."</td>";
  ?>
  <TD class="table_text"><input type="button" class="button" value="Close" onclick="closetask(<?php echo $row['id'];?>,<?php echo $row['masterid'];?>)"></TD>
  <?php
  echo "<tr>";
  }
mysql_close($con);
?> 