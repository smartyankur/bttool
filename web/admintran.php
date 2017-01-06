<?php
$q=$_GET["q"];

include('config.php');
//echo "Hi    :".$q;

if($q!='ALL')
{
 $sql="SELECT * FROM admintran WHERE item = '".$q."'";
}
else
{
 $sql="SELECT * FROM admintran";
}
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
<tr><th>Item</th><th>Action</th><th>Quantity</th><th>Cash</th><th>Date</th><th>User</th></tr>
<?php
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['item']."</div>"."</td>";
  echo "<td>"."<div style="."width:60;height:53;overflow:auto>".$row['action']."</div>"."</td>";
  echo "<td>"."<div style="."width:40;height:53;overflow:auto>".$row['quantity']."</div>"."</td>";
  echo "<td>"."<div style="."width:60;height:53;overflow:auto>".$row['cash']."</div>"."</td>";
  echo "<td>"."<div style="."width:80;height:53;overflow:auto>".$row['date']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['user']."</div>"."</td>";
  }
mysql_close($con);
?> 