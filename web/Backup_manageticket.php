<?php
include 'datediff.php';
error_reporting(0);
$q=$_GET["q"];
//echo "Project :".$q;
$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);

$sql="SELECT * FROM ticket";
$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('Data Not Found');
}

//echo "---------------------------------------------------------------------------------------------------------------------";
echo "<table width='80%' border='1' cellspacing='0' cellpadding='0' bordercolor=\"orangered\">";
?>
<tr class="table_text"><th>Sr No</th><th>Client</th><th>Assignee</th><th>Ticket</th><th>Priority</th><th>Submit Date</th><th>Pending Days</th><th>Status</th><th>Status Reason</th><th>Requested By</th><th>Last Modified Date</th><th>Last Modified By</th></tr>
<?php
$ADate = date('Y-m-d', time());
//$ADate=strtotime($ADate);

while($row = mysql_fetch_array($result))
  {
  $times=$row['timestamp'];
  $times=strtotime($times);
  $times=date('Y-m-d', $times);
  
  //$diff=abs($ADate-$times);
  //$diff=$diff/(60 * 60 * 24);

  $diff=getWorkingDays($times,$ADate,$holidays);

  echo "<tr>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:50;height:100;overflow:auto>".$row['id']."</div>"."</td>"; 
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:100;overflow:auto>".$row['user']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:50;height:100;overflow:auto>".$row['assignee']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:200;height:100;overflow:auto>".$row['ticket']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:50;height:100;overflow:auto>".$row['priority']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:100;overflow:auto>".$row['timestamp']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:100;overflow:auto>".round($diff,2)."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:100;overflow:auto>".$row['status']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:100;overflow:auto>".$row['statusreason']."</div>"."</td>"; 
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:100;overflow:auto>".$row['requestedby']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:100;overflow:auto>".$row['lastmodifiedon']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:100;overflow:auto>".$row['lastmodifiedby']."</div>"."</td>"; 
  echo "</tr>";
  }
mysql_close($con);
?> 