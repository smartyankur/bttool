<?php
$q=$_GET["q"];
$r=$_GET["r"];
$s=$_GET["s"];

//echo $q; echo $r; echo $s;

$fdate=strtotime($r);
$fdate=date( 'Y-m-d', $fdate );

$tdate=strtotime($s);
$tdate=date( 'Y-m-d', $tdate );

if($fdate>$tdate) {echo "Choose proper dates"; exit();}

include("config.php");
if($q!="ALL")
{
$sql="SELECT * FROM cabbooking where date BETWEEN '$fdate' and '$tdate' AND dept='$q'";
//echo $sql;
}
else
{
$sql="SELECT * FROM cabbooking where date >= '$fdate' AND date <='$tdate'";
//echo $sql;
}

$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('Data Not Found');
}

//echo "---------------------------------------------------------------------------------------------------------------------";
echo "<table width='100%' border='1' cellspacing='0' cellpadding='0'>";

?>
<tr><th>ID</th><th>Dept</th><th>BilledTo</th><th>Project</th><th>Request From</th><th>Cost</th><th>Date</th></tr>
<?php

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>"."<div style="."width:40;height:53;overflow:auto>".$row['id']."</div>"."</td>";
  echo "<td>"."<div style="."width:40;height:53;overflow:auto>".$row['dept']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['billedto']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['project']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['user']."</div>"."</td>";
  echo "<td>"."<div style="."width:60;height:53;overflow:auto>".$row['cost']."</div>"."</td>";
  echo "<td>"."<div style="."width:60;height:53;overflow:auto>".$row['date']."</div>"."</td>";
  }
mysql_close($con);

?> 