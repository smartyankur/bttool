<?php
//$q=$_GET["q"];

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
//echo "Hi    :".$q;

$sql="SELECT * FROM manual";
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
<tr><th>ID</th><th>Desc</th><th>Cost</th><th>Mode Of Payment</th><th>Date</th><th>Type</th><th>Edit</th></tr>
<?php
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['id']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['descr']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['cost']."</div>"."</td>"; 
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['mop']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['date']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['type']."</div>"."</td>";
  ?>
  <TD><input type="button" value="EDIT" onclick="submitresponse(<?php echo $row['id'] ?>)"></TD>
  <?php
  }
echo "</table>";
mysql_close($con);
?> 