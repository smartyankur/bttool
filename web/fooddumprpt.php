<?php
$q=$_GET["q"];
$r=$_GET["r"];
$s=$_GET["s"];
$v=$_GET["v"];

//echo $q; echo $r; echo $s;

$fdate=strtotime($r);
$fdate=date( 'Y-m-d', $fdate );

$tdate=strtotime($s);
$tdate=date( 'Y-m-d', $tdate );

if($fdate>$tdate) {echo "Choose proper dates"; exit();}

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
//echo "Hi    :".$q;

if($v == "-1") {
	if($q!="ALL")
	{
	 $sql="SELECT * FROM food where date BETWEEN '$fdate' and '$tdate' AND dept='$q'";
	}
	else
	{
	$sql="SELECT * FROM food where date BETWEEN '$fdate' and '$tdate'";
	//echo $sql;
	}
} else {
	if($q!="ALL")
	{
	 $sql="SELECT * FROM food where date BETWEEN '$fdate' and '$tdate' AND dept='$q' AND vendor_id='$v'";
	}
	else
	{
	$sql="SELECT * FROM food where date BETWEEN '$fdate' and '$tdate' AND vendor_id='$v'";
	//echo $sql;
	}	
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
<tr><th>ID</th><th>Dept</th><th>BilledTo</th><th>Request From</th><th>Cost</th><th>Date</th><th>Menu</th></tr>
<?php

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>"."<div style="."width:40;height:53;overflow:auto>".$row['id']."</div>"."</td>";
  echo "<td>"."<div style="."width:40;height:53;overflow:auto>".$row['dept']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['billedto']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['user']."</div>"."</td>";
  echo "<td>"."<div style="."width:60;height:53;overflow:auto>".$row['cost']."</div>"."</td>";
  echo "<td>"."<div style="."width:60;height:53;overflow:auto>".$row['date']."</div>"."</td>";
  echo "<td>"."<div style="."width:60;height:53;overflow:auto>".$row['menu']."</div>"."</td>";
  }
mysql_close($con);

?> 