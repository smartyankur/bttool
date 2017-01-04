<?php
$q=date('Y-m-d',strtotime($_GET["q"]));
$r=$_GET["r"]; //fm
$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
//echo "Hi    :".$q;

$sql="SELECT sum(hours) FROM utilization WHERE date = '".$q."' and fm='$r' and project !='FREE' and project != 'LEAVE'";
//echo $sql;

$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('Data Not Found');
}

//echo "---------------------------------------------------------------------------------------------------------------------";
echo "<table width='50%' border='1' cellspacing='0' cellpadding='0' bordercolor=\"orangered\">";
?>
<?php
while($row = mysql_fetch_array($result))
  {
  //echo "<td valign=\"middle\" class=\"table_text\">"."<div style="."width:50;height:53;overflow:auto>".htmlentities($row['sum(hours)'])."</div>"."</td>";
  $hrplanned=htmlentities($row['sum(hours)']);
  }

$sql1="SELECT count(DISTINCT TM) FROM utilization where fm='$r' and date='$q' and project!='LEAVE'";
$result1 = mysql_query($sql1);


while ($row1=mysql_fetch_array($result1))
  {
   $counttm=$row1['count(DISTINCT TM)'];
   if ($counttm==0) {echo "No Data Found"; exit();}
  }

$available=$counttm*8.5; 
echo "Planned Hours=".$hrplanned; echo "</br>";
echo "Available Hours=".$available; echo "</br>";

$utilization = $hrplanned * 100 / $available;
echo "Utilization =".$utilization."%";

mysql_close($con);
?>
</table>