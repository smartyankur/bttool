<?php
//$q=$_GET["q"];

include("config.php");

$sql="SELECT * FROM lmsblobjuly5";
$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0){
  die('Data Not Found');
}

//echo "---------------------------------------------------------------------------------------------------------------------";
?>
<table width="99%" border="0" cellspacing="0" cellpadding="0" bordercolor="orangered">
  <tr class="table_text">
    <td valign="top" align="left">
      <a href="manageqcexport.php?pname=<?php echo urlencode($q); ?>">Export result</a>
    </td>                      
  </tr>
</table>
<table width='100%' border='1' cellspacing='0' cellpadding='0' bordercolor='orangered'>
<tr class="table_text">
  <th>Project</th>
  <th>Bug No</th>
  <th>Req ID</th>
  <th>Reviewer</th>
  <th>Developer</th>
  <th>Build</th>
  <th>Type</th>
  <th>Category</th>
  <th>Priority</th>
  <th>Module</th>
  <th>Submodule</th>
  <th>Severity</th>
  <th>Status</th>
  <th>Dev Comment</th>
  <th>QC Comment</th>
  <th>BugDesc</th>
  <th>Grab</th>
</tr>
<?php
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:50;height:100;overflow:auto>".$row['project']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:50;height:100;overflow:auto>".$row['id']."</div>"."</td>"; 
  echo "<td class=\"table_text\">"."<div align=center style="."width:50;height:100;overflow:auto>".$row['reqid']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:100;overflow:auto>".$row['reviewer']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:100;overflow:auto>".$row['dev']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:50;height:100;overflow:auto>".$row['build']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:100;overflow:auto>".$row['type']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:100;overflow:auto>".$row['btype']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:75;height:100;overflow:auto>".$row['priority']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:75;height:100;overflow:auto>".$row['module']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:75;height:100;overflow:auto>".$row['submodule']."</div>"."</td>"; 
  echo "<td class=\"table_text\">"."<div align=center style="."width:75;height:100;overflow:auto>".$row['severity']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:75;height:100;overflow:auto>".$row['status']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:100;overflow:auto>".$row['devcomment']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:100;overflow:auto>".$row['qccomment']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:250;height:100;overflow:auto>".$row['bdr']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:350;height:100;overflow:auto>".$row['grab']."</div>"."</td>";
  echo "</tr>";
  }
mysql_close($con);
?> 
</table>