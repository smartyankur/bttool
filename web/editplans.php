<?php	
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
	 echo "<h3>"."Hi ".$row['username']." ! Edit Plans..."."</h3>";
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
<script type="text/javascript">

function send()
{
//newwindow.close();
var DDate=trim(document.getElementById('DDate').value);
var SDate=trim(document.getElementById('SDate').value);
var user=trim(document.getElementById('loggeduser').value);
var del=trim(document.getElementById('deldate').value);
var rec=trim(document.getElementById('recdate').value);
var id=trim(document.getElementById('id').value);
var mid=trim(document.getElementById('mid').value);
var effort=trim(document.getElementById('effort').value);

if(SDate == ""){alert("Please mention new start date"); return false;}
if(DDate == ""){alert("Please mention new end date"); return false;}
if(effort == ""){alert("Please mention effort"); return false;}

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
	}
  }
xmlhttp.open("GET","updateplans.php?q="+SDate+ "&r=" + DDate+ "&s=" + user+ "&t=" + del+ "&u=" + id+ "&v=" + effort+ "&w=" + rec+ "&x=" + mid,true);
xmlhttp.send();
}

window.onunload = unloadPage;
function unloadPage()
{
 newwindow.close();
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
<?php
$id=$_REQUEST["id"];
$mid=$_REQUEST["mid"];

$cquery="select * from accept where masterid='$mid' and indx='$id'";
//echo $cquery;
$cresult=mysql_query($cquery) or die (mysql_error());
$count = mysql_num_rows($cresult);

If($count==0){
die("No Plan To Edit....");
}

$rowst=mysql_fetch_assoc($cresult);
$effort=$rowst['effort'];
$SDatex=$rowst['SDate'];
$DDatex=$rowst['DDate'];

$SDatex=strtotime($SDatex);
$SDatex = date( 'd-M-Y H:i:s', $SDatex );

$DDatex=strtotime($DDatex);
$DDatex = date( 'd-M-Y H:i:s', $DDatex );

$sel="select ADate,DDate from qcreq where id='$mid' and indx='$id'";
$ret=mysql_query( $sel, $con );
$rows=mysql_fetch_assoc($ret);
$Deld=$rows['DDate'];
$Received=$rows['ADate'];
echo "Delivery Date :".$Deld." Received On :".$Received;
?>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest">
<TABLE>
<TR>
<TD>From</TD>
<TD><input type="Text" readonly="readonly" id="SDate" value="<?php echo $SDatex;?>" maxlength="20" size="17" name="SDate">
<a href="javascript:NewCal('SDate','ddmmmyyyy',true,24)"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
<TD>To</TD>
<TD><input type="Text" readonly="readonly" id="DDate" value="<?php echo $DDatex;?>" maxlength="20" size="17" name="DDate">
<a href="javascript:NewCal('DDate','ddmmmyyyy',true,24)"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>
<TR>
<TD>Total Planned Test-Effort (QC)</TD>
<TD><input type="Text" id="effort" maxlength="5" size="5" name="effort" value="<?php echo $effort;?>">Hours</TD>
</TR>
</TABLE>
</br>
<?php
echo "<input type ='hidden' name='loggeduser' id='loggeduser' value='$username'>";
echo "<input type ='hidden' name='deldate' id='deldate' value='$Deld'>";
echo "<input type ='hidden' name='recdate' id='recdate' value='$Received'>";
echo "<input type ='hidden' name='id' id='id' value='$id'>";
echo "<input type ='hidden' name='mid' id='mid' value='$mid'>";
?>
<input type="button" value="Update Plans" onclick="send()" class="button">
</form>
<div id="txtHint"></div>
</body>
</html> 