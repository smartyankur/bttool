<?php
error_reporting(0);
$q=$_GET["q"];
$r=$_GET["r"];
$s=$_GET["s"];

include('config.php');

$q=strtotime($q);
$q = date( 'Y-m-d', $q );

$r=strtotime($r);
$r = date( 'Y-m-d', $r );

if($q>$r) {echo "Start Date can't be after end date"; exit();}

$sqlt="SELECT masterid,SDate,DDate,effort FROM accept";
$result = mysql_query($sqlt);
$count = mysql_num_rows($result);

if($count==0)
{
 //echo "Hi";
 echo "No Data Found"; exit();
}
else
{
 //echo "Count ".$count;
}

echo "<table width='100%' border='1' cellspacing='0' cellpadding='0' bordercolor=\"orangered\">";
?>
<tr class="table_text"><th>Project</th><th>Task</th><th>Start Date</th><th>End Date</th><th>Effort (QC)</th></tr>
<?php
while($row = mysql_fetch_array($result))
  {
  $TDate = $row['SDate'];
  $UDate = $row['DDate'];
  
  if($s=="SDate"){$CDate=$row['SDate'];} else {$CDate=$row['DDate'];}
  $CDate=strtotime($CDate);
  $CDate=date( 'Y-m-d', $CDate );
  
  $mid=$row['masterid'];
  $effq="select project,task from projecttask where id='$mid'";
  $retq = mysql_query( $effq, $con );
  $rowq = mysql_fetch_assoc($retq);

  if($CDate>=$q && $CDate<=$r)
	  { 
       echo "<tr class=\"table_text\">";
       echo "<td class=\"table_text\">"."<div style="."width:100;height:53;overflow:auto>".$rowq['project']."</div>"."</td>";
	   echo "<td class=\"table_text\">"."<div style="."width:100;height:53;overflow:auto>".$rowq['task']."</div>"."</td>";
       echo "<td class=\"table_text\">"."<div style="."width:80;height:53;overflow:auto>".$TDate."</div>"."</td>";
       echo "<td class=\"table_text\">"."<div style="."width:80;height:53;overflow:auto>".$UDate."</div>"."</td>";
       echo "<td class=\"table_text\">"."<div style="."width:30;height:53;overflow:auto>".$row['effort']."</div>"."</td>"; 
      } 
  }
//echo "By ".$s;
mysql_close($con);
?> 