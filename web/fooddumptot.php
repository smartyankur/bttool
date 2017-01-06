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

include('config.php');
//echo "Hi    :".$q;


if($v == "-1") {
	if($q!="ALL")
	{
	 $sql="SELECT SUM(cost) FROM food where date >= '$fdate' AND date <='$tdate' AND dept='$q'";
	//echo $sql;
	}
	else
	{
	$sql="SELECT SUM(cost) FROM food where date >= '$fdate' AND date <='$tdate'";
	//echo $sql;
	}
} else {
	if($q!="ALL")
	{
	 $sql="SELECT SUM(cost) FROM food where date >= '$fdate' AND date <='$tdate' AND dept='$q' AND vendor_id = '$v'";
	//echo $sql;
	}
	else
	{
	$sql="SELECT SUM(cost) FROM food where date >= '$fdate' AND date <='$tdate' AND vendor_id = '$v'";
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
while($row = mysql_fetch_array($result))
  {
  
  echo $row['SUM(cost)']."</div>"."</td>";
  
  }
mysql_close($con);

?> 