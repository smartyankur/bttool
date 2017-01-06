<?php
$q=$_GET["q"];

include('config.php');

$sql="SELECT * FROM register where item='$q'";
$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('Data Not Found');
}

//echo "---------------------------------------------------------------------------------------------------------------------";
echo "<table width='50%' border='1' cellspacing='0' cellpadding='0'>";
?>
<tr><th>Measuring Unit</th><th>Current Quantity</th></tr>
<?php
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  //echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['id']."</div>"."</td>";
  //echo "<td>"."<div style="."width:60;height:53;overflow:auto>".$row['item']."</div>"."</td>";
  echo "<td>"."<div style="."width:40;height:53;overflow:auto>".$row['measuringunit']."</div>"."</td>";
  echo "<td>"."<div style="."width:30;height:53;overflow:auto>".$row['currentquantity']."</div>"."</td>";
  }
mysql_close($con);
?> 