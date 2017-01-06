<?php
//$q=$_GET["q"];

include('config.php');
//echo "Hi    :".$q;

$sql="SELECT * FROM pip";
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
<tr><th>From</th><th>Practice</th><th>Proposal</th><th>Date</th><th>Accepted</th><th>Aging</th><th>Status/Comments</th><th>See History</th><th>Implemented</th></tr>
<?php
while($row = mysql_fetch_array($result))
  {
  //$timestamp = date("Y-m-d",strtotime($row['date']+3));
  $date = strtotime(date("Y-m-d", strtotime($row['date'])). " +7 day");
  $timestamp = date("Y-m-d",$date);
  $currentdate= date("Y-m-d");

  if($timestamp<$currentdate){$diff=(strtotime($currentdate)-strtotime($timestamp))/60/60/24;}
  else {$diff=0;}

  $rquery="select status,implemented from piphistory where pipid='".$row['pipid']."'";
  $rresult=mysql_query($rquery);
  while($rrow = mysql_fetch_array($rresult)){$rstatus=$rrow['status'];$implemented=$rrow['implemented'];} 

  echo "<tr>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['name']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['practice']."</div>"."</td>"; 
  echo "<td>"."<div style="."width:300;height:53;overflow:auto>".$row['proposal']."</div>"."</td>";
  echo "<td>"."<div style="."width:90;height:53;overflow:auto>".$row['date']."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['accepted']."</div>"."</td>";
  echo "<td>"."<div style="."width:50;height:53;overflow:auto>".$diff."</div>"."</td>";
  echo "<td>"."<div style="."width:200;height:53;overflow:auto>".$rstatus."</div>"."</td>";
  //echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['owner']."</div>"."</td>";
  //echo "<td>".$row['momid']."</td>";
?>
  <TD><input type="button" value="See History" onclick="showhistory(<?php echo $row['pipid']; ?>)"></TD>
<?php
  echo "<td>"."<div style="."width:20;height:53;overflow:auto>".$implemented."</div>"."</td>"; 
  echo "</tr>";
  //echo "--------------------------------------------------------------------------------------------------------------------";
  }
echo "</table>";
mysql_close($con);
?> 