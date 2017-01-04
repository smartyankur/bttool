<?php

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

//$q=$_GET["q"];
$r=mysql_real_escape_string($_GET["q"]);

mysql_select_db("audit", $con);
//echo "Hi    :".$q;
//"SELECT * FROM `table_name` WHERE `description` LIKE '%$search%'"; 
$sql="SELECT * FROM cabbooking WHERE user LIKE '%$r%' or billedto LIKE '%$r%' or project LIKE '%$r%' or billedto LIKE '%$r%' or frompl LIKE '%$r%' or topl LIKE '%$r%'";
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
<tr><th>Dept</th><th>BilledTo</th><th>Project</th><th>Request From</th><th>Cost</th><th>Date</th></tr>
<?php
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>"."<div style="."width:40;height:53;overflow:auto>".$row['dept']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['billedto']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['project']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['user']."</div>"."</td>";
  echo "<td>"."<div style="."width:60;height:53;overflow:auto>".$row['cost']."</div>"."</td>";
  echo "<td>"."<div style="."width:60;height:53;overflow:auto>".$row['date']."</div>"."</td>";
  }
mysql_close($con);
?> 