<?php	
	error_reporting(0);
	session_start();
	
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location:index.php");
    }
	
	$con = mysql_connect("localhost","root","password");
    $user=$_SESSION['login'];

    if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }

	mysql_select_db("audit") or die(mysql_error());

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
	 echo "<h3>"."Hi ".$row['username']." ! Welcome To Task Acceptance Interface"."</h3>";
	 $username=$row['username'];
	 $email=$row['email'];
    } 	
?>
<html>
<head>
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
 var decimalExpression = /^[0-9.]+$/;
 var SDate = trim(document.getElementById('SDate').value);
 var EDate = trim(document.getElementById('EDate').value);
 var effort = trim(document.getElementById('effort').value); 
 
 if(SDate == ""){alert("Please mention start Date"); return false;}
 if(EDate == ""){alert("Please mention end Date"); return false;}
 if(effort == ""){alert("Please mention effort"); return false;}
 
 if(!effort.match(decimalExpression))
  {
	alert("Effort Should be Purely Decimal");
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
</head>
<body>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" method="post" onsubmit="return verify()" action="acceptsubmit.php">
<?php
$id=$_REQUEST["id"];
$status=$_REQUEST["stat"];
$masterid=$_REQUEST["mid"];

$qrs="select status from projecttask where id='".$masterid."'";
$rets = mysql_query( $qrs, $con );
$rows = mysql_fetch_assoc($rets);
$stats=$rows['status'];

if($stats<>"sent to qc")
{
 die("Status is not appropriate for planning");
}

$rquery = "select * from reject where masterid='".$masterid."' and indx='".$id."'";
$rresult = mysql_query($rquery, $con);
$rcount = mysql_num_rows($rresult);

if($rcount>0)
	{
	 die('This has already been rejected');
	}

$qr="select forround,whosent,sendermail,ADate,DDate from qcreq where id='".$masterid."' and indx='".$id."'";
$retval = mysql_query( $qr, $con );
while($row = mysql_fetch_assoc($retval)) 
 {
  $round=$row['forround'];
  $whosent=$row['whosent'];
  $sendermail=$row['sendermail'];
  $Deld=$row['DDate'];
  $Received=$row['ADate'];
 } 
echo "Request for round :".$round." Delivery Date".$Deld." Received On :".$Received;
?>
<TABLE>
<TR>
<TD>Planned Start Date</TD>
<TD><input type="Text" readonly="readonly" id="SDate" value="" maxlength="20" size="17" name="SDate">
<a href="javascript:NewCal('SDate','ddmmmyyyy',true,24)"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>
<TR>
<TD>Planned End Date</TD>
<TD><input type="Text" readonly="readonly" id="EDate" value="" maxlength="20" size="17" name="EDate">
<a href="javascript:NewCal('EDate','ddmmmyyyy',true,24)"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>
<TR>
<TD>Total Planned Test-Effort (QC)</TD>
<TD><input type="Text" id="effort" maxlength="5" size="5" name="effort" value="<?php echo $effort;?>">Hours</TD>
</TR>
</TABLE>
<?php
echo "<input type ='hidden' name='loggeduser' value='$username'>";
echo "<input type ='hidden' name='email' value='$email'>";
echo "<input type ='hidden' name='masterid' value='$masterid'>";
echo "<input type ='hidden' name='id' value='$id'>";
echo "<input type ='hidden' name='status' value='$status'>";
echo "<input type ='hidden' name='round' value='$round'>";
echo "<input type ='hidden' name='whosent' value='$whosent'>";
echo "<input type ='hidden' name='sendermail' value='$sendermail'>";
?>
<input type="submit" class="button" value="Accept">
</form>
<br/>
</body>
</html> 