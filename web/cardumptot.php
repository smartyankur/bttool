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

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
//echo "Hi    :".$q;
if($q!="ALL")
{
 $sql="SELECT SUM(cost) FROM cabbooking where date >= '$fdate' AND date <='$tdate' AND dept='$q'";
//echo $sql;
}
else
{
$sql="SELECT SUM(cost) FROM cabbooking where date >= '$fdate' AND date <='$tdate'";
//echo $sql;
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