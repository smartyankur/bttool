<html>
<head>
<title>Count Hold Issues details</title>
<?php	
	error_reporting(0);
	session_start();
	
	if(!(isset($_SESSION['login']) && $_SESSION['login'] != '')){
	 header ("Location:index.php");
  }
  $user = $_SESSION['login'];
  	
  include("config.php");
  
  echo "</br>";
  echo "</br>";
  echo "</br>";
  echo "</br>";    
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
  <table class="table_text" width="100%" cellspacing="0" cellpading="0" border="1">
    <tr>
      <td align="center" valign="top"><b>S. No.</b></td>
      <td align="center" valign="top"><b>Bug Cat</b></td>
      <td align="center" valign="top"><b>Severity</b></td>
      <td align="center" valign="top"><b>Module</b></td>
      <td align="center" valign="top"><b>Page No.</b></td>
      <td align="center" valign="top"><b>Bug Desc</b></td>
    </tr>
<?php
if( !empty($_REQUEST['pro_id']) && !empty($_REQUEST['rname']) ){
  $i=1;
  $selectHoldRounds = "SELECT * FROM qcuploadinfo WHERE project_id='".$_REQUEST['pro_id']."' AND round='".$_REQUEST['rname']."' AND bugstatus='hold' ORDER BY round ASC";
  $queryHoldRounds = mysql_query($selectHoldRounds);
  while($fetchHoldRounds = mysql_fetch_array($queryHoldRounds)){
    echo "<tr>";
    	echo "<td align=\"center\" valign=\"top\">".$i."</td>";
    	echo "<td valign=\"top\"><div style=\"width:75;height:53;overflow:auto\">".$fetchHoldRounds['bcat']."</div></td>";      
    	echo "<td valign=\"top\"><div style=\"width:75;height:53;overflow:auto\">".$fetchHoldRounds['severity']."</div></td>";
    	echo "<td valign=\"top\"><div style=\"width:75;height:53;overflow:auto\">".$fetchHoldRounds['module']."</div></td>";
    	echo "<td valign=\"top\" align='center'><div style=\"width:75;height:53;overflow:auto\">".$fetchHoldRounds['screen']."</div></td>";
    	echo "<td valign=\"top\" ><div style=\"width:440;height:53;overflow:auto\">".$fetchHoldRounds['bdr']."</div></td>";
    echo "</tr>";
    $i++;      
  }
}else{
    echo "<tr>";
    	echo "<td colspan='4' align='center' valign='middle'>No record found.</td>";
    echo "</tr>";
}
mysql_close($con);
?>
  </table>
  <br />
  <br />
  <br />
</body>
</html> 