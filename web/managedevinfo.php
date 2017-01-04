<?php
$q=$_GET["q"];

include("config.php");

$sql="SELECT * FROM lmsblob where project='$q'";
$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('Data Not Found');
}

?>
<table width="99%" border="0" cellspacing="0" cellpadding="0" bordercolor="orangered">
  <tr class="table_text">
    <td valign="top" align="left">
      <a href="managedevexport.php?pname=<?php echo urlencode($q); ?>">Export result</a>
    </td>                      
  </tr>
</table>
<table width='100%' border='1' cellspacing='0' cellpadding='0' bordercolor='orangered'>
  <tr class="table_text">
    <th>Bug No</th>
    <th>Req ID</th>
    <th>Reviewer</th>
    <th>Developer</th>
    <th>Build</th>
    <th>Type</th>
    <th>Category</th>
    <th>Priority</th>
    <th>Severity</th>
    <th>Status</th>
    <th>Set Status</th>
    <th>Remarks</th>
    <th>Dev Reason</th>
    <th>Change Status</th>
    <th>QC Comment</th>
    <th>Dev Comment</th>
    <th>BugDesc</th>
    <th>Grab</th>
  </tr>
<?php
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:50;height:100;overflow:auto>".$row['id']."</div>"."</td>"; 
  echo "<td class=\"table_text\">"."<div align=center style="."width:50;height:100;overflow:auto>".$row['reqid']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:100;overflow:auto>".$row['reviewer']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:100;overflow:auto>".$row['dev']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:50;height:100;overflow:auto>".$row['build']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:100;overflow:auto>".$row['type']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:100;overflow:auto>".$row['btype']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:75;height:100;overflow:auto>".$row['priority']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:75;height:100;overflow:auto>".$row['severity']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:75;height:100;overflow:auto>".$row['status']."</div>"."</td>";
  ?>
  <TD><select id="<?php echo "bug".$row['id'];?>" size="1">
  <option value="select" selected>Select</option>
  <option value="fixed">Fixed</option>
  <option value="hold">Hold</option>
  <option value="ok as is">Ok As Is</option> 
  </select></TD>
  <TD><textarea name="<?php echo "txt".$row['id'];?>" rows="2" cols="10" id="<?php echo "txt".$row['id'];?>"></textarea></TD>
  <TD>
  <select id="<?php echo "devreason" . $row['id']; ?>" size="1">
    <option value="select" selected>Select</option>
    <option value="valid" <?php echo ($row['devreason']=="valid") ? " selected" : ""; ?>>Valid</option>
    <option value="invalid" <?php echo ($row['devreason']=="invalid") ? " selected" : ""; ?>>Invalid</option>
    <option value="product level" <?php echo ($row['devreason']=="product level") ? " selected" : ""; ?>>Product Level</option>
    <option value="to be fixed later" <?php echo ($row['devreason']=="to be fixed later") ? " selected" : ""; ?>>To Be Fixed Later</option>
  </select>
  </TD>  
  <TD><input type="button" class="button" value="Change" onclick="submitbugresponse(<?php echo $row['id'] ?>)"></TD>
  <?php
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:100;overflow:auto>".$row['qccomment']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:100;overflow:auto>".$row['devcomment']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:250;height:100;overflow:auto>".$row['bdr']."</div>"."</td>";
  echo "<td class=\"table_text\">"."<div align=center style="."width:350;height:100;overflow:auto>".$row['grab']."</div>"."</td>";
  echo "</tr>";
  }
mysql_close($con);
?>
</table>