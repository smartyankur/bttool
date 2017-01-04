<?php
$q=date('Y-m-d',strtotime($_GET["q"]));
$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
//echo "Hi    :".$q;

$sql="SELECT * FROM utilization WHERE date = '".$q."'";
//echo $sql;

$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('Data Not Found');
}

//echo "---------------------------------------------------------------------------------------------------------------------";
echo "<table width='50%' border='1' cellspacing='0' cellpadding='0' bordercolor=\"orangered\">";
?>
<tr valign="middle" class="table_text"><th>ID</th><th>FM</th><th>TM</th><th>Date</th><th>Project</th><th>Hours</th><th>Edit</th><th>Delete</th></tr>
<?php
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td valign=\"middle\" class=\"table_text\">"."<div style="."width:50;height:53;overflow:auto>".htmlentities($row['id'])."</div>"."</td>";
  echo "<td valign=\"middle\" class=\"table_text\">"."<div style="."width:120;height:53;overflow:auto>".htmlentities($row['fm'])."</div>"."</td>";
  echo "<td valign=\"middle\" class=\"table_text\">"."<div style="."width:120;height:53;overflow:auto>".htmlentities($row['tm'])."</div>"."</td>";
  echo "<td valign=\"middle\" class=\"table_text\">"."<div style="."width:120;height:53;overflow:auto>".htmlentities($row['date'])."</div>"."</td>";
  echo "<td valign=\"middle\" class=\"table_text\">"."<div style="."width:120;height:53;overflow:auto>".htmlentities($row['project'])."</div>"."</td>";
  echo "<td valign=\"middle\" class=\"table_text\">"."<div style="."width:60;height:53;overflow:auto>".htmlentities($row['hours'])."</div>"."</td>";
  ?>
  <TD align="center" class="table_text">&nbsp;&nbsp;<input type="button" value="Change Dates" onclick="submitresponse(<?php echo $row['id'] ?>)" class="button"></TD>
  <TD align="center" class="table_text">&nbsp;&nbsp;<input type="button" value="Delete" onclick="del(<?php echo $row['id'] ?>)" class="button"></TD>
  <?php
  }
mysql_close($con);
?> 