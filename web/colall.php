<?php
//$q=$_GET["q"];
include("config.php");
$sql="SELECT * FROM collateral";

$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('Data Not Found');
}

//echo "---------------------------------------------------------------------------------------------------------------------";
echo "<table width='50%' border='1' cellspacing='0' cellpadding='0'>";
?>
<tr><th>Issue</th><th>Status</th></tr>
<?php
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['issue']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['status']."</div>"."</td>"; 
  echo "<tr>";
  }
echo "</table>";
mysql_close($con);
?> 