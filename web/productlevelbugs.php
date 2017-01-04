<html>
<head>
<title>Product Bugs</title>
<?php	
error_reporting(0);
session_start();

if(!(isset($_SESSION['login']) && $_SESSION['login'] != '')){
  header ("Location:index.php");
}
$user = $_SESSION['login'];
  
include("config.php");

$query = "select username from login where uniqueid='$user'";
$retval = mysql_query( $query, $con );
$count = mysql_num_rows($retval);

if($count==0){
  die('Data Not Found Please contact SEPG');
}

while($row = mysql_fetch_assoc($retval)){ 
  echo "</br>";
  echo "</br>";
  echo "</br>";
  echo "<h4>" . "Hi " . $row['username'] . " ! Welcome to Manage Ticket Interface" . "</h4>";
  $username = $row['username'];
}

$sql    = "SELECT * FROM lmsblob WHERE (btype='product' OR devcomment LIKE '%product%') ORDER BY project ASC";
$result = mysql_query($sql);
$count  = mysql_num_rows($result);

if($count==0){
  die('Data Not Found');
}

?>
<style>
div.ex{
  height:350px;
  width:600px;
  background-color:white;
}

textarea.hide{
  visibility:none;
  display:none;
}

body{
  background:url('qcr.jpg') no-repeat;
}

.button{
  background-color: #F7941C;
  border-bottom:#F7941C;
  border-left: #F7941C;
  border-right:#F7941C;
  border-top: #F7941C;
  color: black;
  font-family: Tahoma
  box-shadow:2px 2px 0 0 #014D06,;
  border-radius: 10px;
  border: 1px outset #b37d00;
}

.table_text {
	font-family: Calibri;
	font-size: 12px;
	font-style: normal;
	line-height: normal;
	font-weight: normal;
	font-variant: normal;
	color: #000000;
	text-indent: 10px;
	vertical-align: middle;
}
</style>
</head>

<body background="bg.gif">
<table width="99%" border="0" cellspacing="0" cellpadding="0" bordercolor="orangered">
  <tr class="table_text">
    <td valign="top" align="left">
      <a href="productlevelbugsexport.php">Export result</a>
    </td>                      
  </tr>
</table>
<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="orangered">
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
    <th>Sub Module</th>
    <th>Severity</th>
  	<th>Status</th>
  	<th>Set Status</th>
  	<th>Remarks</th>
  	<th>Change Status</th>
  	<th>Dev Comment</th>
  	<th>QC Comment</th>
  	<th>BugDesc</th>
  	<th>Grab</th>
  </tr>
<?php
while($row = mysql_fetch_array($result)){
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
    echo "<td class=\"table_text\">"."<div align=center style="."width:50;height:100;overflow:auto>".$row['module']."</div>"."</td>";
    echo "<td class=\"table_text\">"."<div align=center style="."width:50;height:100;overflow:auto>".$row['submodule']."</div>"."</td>";
    echo "<td class=\"table_text\">"."<div align=center style="."width:75;height:100;overflow:auto>".$row['severity']."</div>"."</td>";
    echo "<td class=\"table_text\">"."<div align=center style="."width:75;height:100;overflow:auto>".$row['status']."</div>"."</td>";
?>
  <TD>
    <select id="<?php echo "bug".$row['id']; ?>" size="1">
      <option value="select" selected>Select</option>
      <option value="closed">Closed</option>
      <option value="reopened">Reopened</option>
    </select>
  </TD>
  <TD><textarea name="<?php echo "txt".$row['id']; ?>" rows="2" cols="10" id="<?php echo "txt".$row['id']; ?>"></textarea></TD>
  <TD><input type="button" class="button" value="Change" onclick="submitbugresponse(<?php echo $row['id'] ?>)"></TD>
<?php
    echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:100;overflow:auto>".$row['devcomment']."</div>"."</td>";
    echo "<td class=\"table_text\">"."<div align=center style="."width:100;height:100;overflow:auto>".$row['qccomment']."</div>"."</td>";
    echo "<td class=\"table_text\">"."<div align=center style="."width:250;height:100;overflow:auto>".$row['bdr']."</div>"."</td>";
    echo "<td class=\"table_text\">"."<div align=center style="."width:350;height:100;overflow:auto>".$row['grab']."</div>"."</td>";
  echo "</tr>";
}

mysql_close($con);
?>
</table> 
<br>
<br>
<br>
</body>
</html>