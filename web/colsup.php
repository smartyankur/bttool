<?php
$q=$_GET["q"];
$upload_path = './support/';

include("config.php");
  
$sql="SELECT * FROM ticket where user='$q'";
$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0){
  die('Data Not Found');
}
?>
<table width="99%" border="0" cellspacing="0" cellpadding="0" bordercolor="orangered">
  <tr class="table_text">
    <td valign="top" align="left">
      <a href="supportexport.php?userinfo=<?php echo $q; ?>" >Export result</a>
    </td>                      
  </tr>
</table>
<?php
echo "</br>";
echo "<table width='80%' border='1' cellspacing='0' cellpadding='0'>";
?>
<tr>
  <th valign="top">Incident No.</th>
  <th valign="top">Notes</th>
  <th valign="top">Reported Date</th>
  <th valign="top">Requested By</th>
  <th valign="top">Email ID</th>
  <th valign="top">File Path</th>
</tr>
<?php
  while($row = mysql_fetch_array($result)){
    echo "<tr>";
    echo "<td width=\"5%\" align=\"center\">".$row['id']."</td>";
    echo "<td width=\"75%\">"."<div style="."height:53;overflow:auto>".$row['ticket']."</div>"."</td>";
    echo "<td width=\"10%\" align=\"center\">".$row['timestamp']."</td>";        
    echo "<td width=\"15%\" align=\"center\">".$row['requestedby']."</td>";    
    echo "<td width=\"15%\" align=\"center\">" . ((!empty($row['officialemail'])) ? $row['officialemail'] : "N/A") . "</td>";
	echo "<td>"."<div align=center style="."width:200;height:53;overflow:auto>".'<a href="'.htmlentities($upload_path).htmlentities($row['filepath']).'" title="Your File">'.$row['filepath'].'</a>'."</div>"."</td>";
    echo "<tr>";
  }
  echo "</table>";
  mysql_close($con);
?> 