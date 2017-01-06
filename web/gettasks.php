<?php
error_reporting(0);
$q=$_GET["q"];

include('config.php');

$q=strtotime($q);
$q = date( 'Y-m-d', $q );

$sql="SELECT id,DDate,forround FROM qcreq";
$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('Data Not Found');
}

//echo "---------------------------------------------------------------------------------------------------------------------";
echo "<table width='100%' border='1' cellspacing='0' cellpadding='0' bordercolor=\"orangered\">";
?>
<tr class="table_text"><th>ID</th><th>Project</th><th>Task</th><th>Delivery Date</th><th>For Round</th></tr>
<?php
while($row = mysql_fetch_array($result))
  {
  $DDate=strtotime($row['DDate']);
  $DDate=date( 'Y-m-d', $DDate );
  
  if($DDate==$q)
	  { 
       echo "<tr class=\"table_text\">";
       echo "<td class=\"table_text\">"."<div style="."width:30;height:53;overflow:auto>".$row['id']."</div>"."</td>";
       $qr="select project,task from projecttask where id='".$row['id']."'";
       $retval=mysql_query( $qr, $con );
       $rowtx=mysql_fetch_assoc($retval);
	   $project=$rowtx['project'];
       $task=$rowtx['task']; 
       echo "<td class=\"table_text\">"."<div style="."width:100;height:70;overflow:auto>".$project."</div>"."</td>";
       echo "<td class=\"table_text\">"."<div style="."width:200;height:53;overflow:auto>".$task."</div>"."</td>";
       echo "<td class=\"table_text\">"."<div style="."width:80;height:53;overflow:auto>".$row['DDate']."</div>"."</td>";
       echo "<td class=\"table_text\">"."<div style="."width:30;height:53;overflow:auto>".$row['forround']."</div>"."</td>"; 
      } 
  }
mysql_close($con);
?> 