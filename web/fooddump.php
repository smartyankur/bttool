<?php
//$q=$_GET["q"];
error_reporting(0);
$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
//echo "Hi    :".$q;

$sql="SELECT * FROM food";
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
<tr><th>ID</th><th>Dept</th><th>BilledTo</th><th>Request From</th><th>Cost</th><th>Date</th><th>Menu</th><th>Edit</th></tr>
<?php
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>"."<div style="."width:40;height:53;overflow:auto>".$row['id']."</div>"."</td>";
  echo "<td>"."<div style="."width:40;height:53;overflow:auto>".$row['dept']."</div>"."</td>";
  //echo "<td>"."<div style="."width:120;height:53;overflow:auto>".$row['project']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['billedto']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['user']."</div>"."</td>";
  echo "<td>"."<div style="."width:60;height:53;overflow:auto>".$row['cost']."</div>"."</td>";
  echo "<td>"."<div style="."width:60;height:53;overflow:auto>".$row['date']."</div>"."</td>";
  echo "<td>"."<div style="."width:60;height:53;overflow:auto>".$row['menu']."</div>"."</td>";
  ?>
  <TD><input type="button" value="Edit" onclick="editrow(<?php echo $row['id'] ?>)"></TD>
  <?php
  }
mysql_close($con);
?> 