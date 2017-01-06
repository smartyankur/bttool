<?php	
    error_reporting(0);
	session_start();
	include("class.phpmailer.php");
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location:index.php");
    }
	
    $user=$_SESSION['login'];

    include('config.php');

    $query = "select username,email from login where uniqueid='$user'";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
	{
			die('Data Not Found Please contact SEPG');
	}

    
    while($row = mysql_fetch_assoc($retval)) 
    { 
     echo "<br>";
	 echo "<br>";
	 echo "<h3>"."Hi ".$row['username']." ! Close QC Task Interface"."</h3>";
	 $username=$row['username'];
	 $email=$row['email'];
    } 	

?>
<html>
<head>
<style type="text/css">
body
{
background:url('qcr.jpg') no-repeat;
}
.button
{
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
</style>
<script type="text/javascript">
window.onunload = unloadPage;
function unloadPage()
{
 //alert("unload event detected!");
 newwindow.close();
 //chwindow.close();
}

function verify()
{
 var numericExpression = /^[0-9]+$/;
 var sent = trim(document.getElementById('sent').value);
 var effort = trim(document.getElementById('effort').value);
 var remark = trim(document.getElementById('remark').value);
 var bugcount = trim(document.getElementById('bugcount').value);
  
 if(sent == "select"){alert("Please mention status"); return false;}
 if(effort == ""){alert("Please mention effort"); return false;}
 if(bugcount == ""){alert("Please provide bugcount"); return false;}
 if(remark == ""){alert("Please provide remark"); return false;}

 if(!effort.match(numericExpression))
  {
  alert("Effort Should be Numeric");
  return false;
  }

 if(!bugcount.match(numericExpression))
  {
  alert("Bugcount Should be Numeric");
  return false;
  }
}

function trim(s)
{
	return rtrim(ltrim(s));
}

function ltrim(s)
{
	var l=0;
	while(l < s.length && s[l] == ' ')
	{	l++; }
	return s.substring(l, s.length);
}

function rtrim(s)
{
	var r=s.length -1;
	while(r > 0 && s[r] == ' ')
	{	r-=1;	}
	return s.substring(0, r+1);
}

</script>
<style type="text/css">
body
{
 background:url('qcr.jpg') no-repeat;
}
</style>
</head>
<body>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" method="post" onsubmit="return verify()" action="closeqctask.php">
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
 $sent = $_POST['sent'];
 $effort = $_POST['effort'];
 $bugcount = $_POST['bugcount'];
 $remark = $_POST['remark'];
 $loggeduser = $_POST['loggeduser'];
 $id = $_POST['id'];
 $currentdate = date('Y-m-d H:i:s', time());
 $cstat="closed";

 $cquery="update qcplan set actualeffort='$effort',noofissues='$bugcount',remarks='$remark',whochangedstatus='$loggeduser',whenchanged='$currentdate',senttodev='$sent',status='$cstat' where id='$id'";
 
 if (mysql_query($cquery))
       {
        die("Task Closed"); 
       } 

 else
       {
        die (mysql_error());
       }
}

$id=$_REQUEST["q"];
$auditee=$_REQUEST["r"];
$mid=$_REQUEST["s"];

$qrs="select status from projecttask where id='".$mid."'";
$rets = mysql_query( $qrs, $con );
$rows = mysql_fetch_assoc($rets);
$stats=$rows['status'];
//echo "Status :".$stats;
if($stats<>"accepted")
{
 die("Status is not appropriate for closing");
}

$qr="select status from qcplan where id='".$id."'";
$ret=mysql_query( $qr, $con );
$row=mysql_fetch_assoc($ret);
$stat=$row['status'];

if($stat=="closed")
{
 die("Already Closed");
}
?>
<TABLE>
<TR>
<TD>Issues Sent To Dev Team</TD>
<TD><select name="sent" size="1" id="sent">
<option value="select" selected>Select</option>
<option value="Y">Yes</option>
<option value="N">No</option>
</select></TD>
</TR>

<TR>
<TD>Actual Effort (Hours)</TD>
<TD><input type="Text" id="effort" maxlength="5" size="5" name="effort"></TD>
</TR>

<TR>
<TD>No of Issues found</TD>
<TD><input type="Text" id="bugcount" maxlength="5" size="5" name="bugcount"></TD>
</TR>

<TR>
<TD>Remarks</TD>
<TD><textarea name="remark" rows="4" cols="30" id="remark"></textarea></TD>
</TR>

</TABLE>
<?php
echo "<input type ='hidden' name='loggeduser' value='$auditee'>";
echo "<input type ='hidden' name='id' value='$id'>";
?>
<input type="submit" value="Close" class="button">
</form>
</body>
</html> 