<?php
//$q=$_GET["q"];

include("config.php");
//echo "Hi    :".$q;

$sql="SELECT id,reviewer,entrydate FROM lmsblob";
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
<tr><th>ID</th><th>Reviewer</th><th>Entry Date</th></tr>
<?php
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>"."<div style="."width:40;height:53;overflow:auto>".$row['id']."</div>"."</td>";
  echo "<td>"."<div style="."width:40;height:53;overflow:auto>".$row['reviewer']."</div>"."</td>";
  echo "</tr>";
  }
mysql_close($con);
?> 