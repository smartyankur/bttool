<?php
$q=$_GET["q"];

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
//echo "Hi    :".$q;

$sql="SELECT measuringunit, currentquantity FROM register WHERE item = '".$q."'";
//echo $sql;
$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('Data Not Found');
}

while($row = mysql_fetch_array($result))
{
 $unit=$row['measuringunit']; 
 $quantity=$row['currentquantity'];
}
echo "Measuring Unit :".$unit."  Quantity :".$quantity;
mysql_close($con);
?> 