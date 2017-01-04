<html>
<head>
<title>Ticket log details</title>
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
      <td align="center" valign="top"><b>Modified Date/Time</b></td>
      <td align="center" valign="top"><b>Modified By</b></td>
      <td align="center" valign="top"><b>Summary</b></td>      
    </tr>
<?php
$selectLogInfo = "SELECT ttl.*, ticket.ticket, login.username FROM tbl_ticket_log AS ttl 
                           INNER JOIN ticket ON ttl.ticket_id = ticket.id 
                           INNER JOIN login ON ttl.modified_by = login.uid 
WHERE ttl.id = ".$_REQUEST['logid'];
$queryLogInfo = mysql_query($selectLogInfo);
$numrowsLogInfo = mysql_num_rows($queryLogInfo);
if( !empty($numrowsLogInfo) ){
$fetchLogInfo = mysql_fetch_array($queryLogInfo);
?>
    <tr>
      <td align='center'><?php echo ( !empty($fetchLogInfo['modify_time']) ) ? date("m/d/Y h:i A", $fetchLogInfo['modify_time']) : "N/A"; ?></td>
      <td align='center'><?php echo ( !empty($fetchLogInfo['username']) ) ? $fetchLogInfo['username'] : "N/A"; ?></td>
      <td align='center'><textarea rows="10" cols="70" maxlength="700" disable="true"><?php echo ( !empty($fetchLogInfo['summary']) ) ? $fetchLogInfo['summary'] : "Not modified"; ?></textarea></td>
    </tr>
<?php  
}
?>
    
  </table>
  <br />
  <br />
  <br />
</body>
</html> 