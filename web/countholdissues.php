<html>
<head>
<title>Count Hold Issues</title>
<?php	
error_reporting(0);
session_start();
	
if(!(isset($_SESSION['login']) && $_SESSION['login'] != '')){
  header ("Location:index.php");
}
$user=$_SESSION['login'];    
  
include("config.php");  

$query  = "select username from login where uniqueid='$user'";
$retval = mysql_query($query, $con);
$count  = mysql_num_rows($retval);
	
if($count==0){
  die('Data Not Found Please contact SEPG');
}

while($row = mysql_fetch_assoc($retval)){ 
  echo "<br>";
  echo "<br>"; 
  echo "<h4>"."Hi ".$row['username']." ! Welcome to Count or Hold Issues"."</h4>";
  $username=$row['username'];
}

?>
<style>
div.ex{
  height:250px;
  width:400px;
  background-color:white
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
  border: 1px outset #b37d00 ;
}

.table_text{
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
<table width="99%" border="0" cellspacing="0" cellpadding="0" bordercolor="orangered" class="table_text">
  <tr class="table_text">
    <td valign="top" align="left"><input type="button" class="button" value="Log Out" onclick="location.href='logout.php';"></td>                      
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>                  
  </tr>        
</table>
<table width="99%" border="0" cellspacing="0" cellpadding="0" bordercolor="orangered">
  <tr class="table_text">
    <td valign="top" align="left">
      <a href="countholdissuesexport.php">Export result</a><br /><br />
    </td>                      
  </tr>
</table>
<form name="tstest" action="./funrev.php" method="post" enctype="multipart/form-data">  
<table width="80%" border="1" cellspacing="0" cellpadding="0" bordercolor="orangered" class="table_text">
  <tr class="table_text">
    <th valign="top">S. No.</th>
    <th valign="top">Project</th>    
    <th valign="top">Round name</th>                  
    <th valign="top">Count of Hold Issues</th>            
  </tr>
<?php
$i=1;    
$selectCounts = "SELECT `project_id`, `project`, `round`, COUNT(`round`) AS `roundcount` FROM `qcuploadinfo` WHERE `bugstatus`='hold' GROUP BY `project`, `round` ORDER BY `project` ASC";
$queryCounts = mysql_query($selectCounts);
while($fetchCounts = mysql_fetch_array($queryCounts)){    
  echo "<tr>";
  	echo "<td align=\"center\" valign=\"top\">".$i."</td>";
  	echo "<td valign=\"top\"><div style=\"height:53;overflow:auto\">".$fetchCounts['project']."</div></td>";      
  	echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['round']."</div></td>";     
  	echo "<td valign='top'><div style='width:100;height:53;overflow:auto'><a href=\"JavaScript:newPopup('countholdissuesdetails.php?pro_id=".$fetchCounts['project_id']."&rname=".$fetchCounts['round']."');\">".$fetchCounts['roundcount']."</a></div></td>";
  echo "</tr>";
  $i++;      
}
mysql_close($con);
?> 
</table>
<table width="99%" border="0" cellspacing="0" cellpadding="0" bordercolor="orangered" class="table_text">
  <tr>
    <td valign="top">&nbsp;</td>                  
  </tr>
  <tr class="table_text">
    <td valign="top" align="left"><input type="button" class="button" value="Log Out" onclick="location.href='logout.php';"></td>                      
  </tr>        
</table>
</form>
<script type="text/javascript">
function newPopup(url) {
	popupWindow = window.open(
		url,'popUpWindow','height=500,width=820,left=550,top=230,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no')
}
</script>
</body>
</html>