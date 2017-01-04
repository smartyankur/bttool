<?php	
    error_reporting(0);
	session_start();
	include("class.phpmailer.php");
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
	 echo "<h3>"."Hi ".$row['username']." ! Filter Plans..."."</h3>";
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

function showAll()
{
//newwindow.close();
var DDate=trim(document.getElementById('DDate').value);
var SDate=trim(document.getElementById('SDate').value);
var by=trim(document.getElementById('by').value);

if(SDate == ""){alert("Please mention start date"); return false;}
if(DDate == ""){alert("Please mention end date"); return false;}
if(by == "select") {alert("Please mention filter criteria"); return false;}

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
xmlhttp.open("GET","getplans.php?q="+SDate+ "&r=" + DDate+ "&s=" + by,true);
xmlhttp.send();
}

window.onunload = unloadPage;
function unloadPage()
{
 //alert("unload event detected!");
 newwindow.close();
 //chwindow.close();
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
<form name="tstest">
<TABLE>
<TR>
<TD>From</TD>
<TD><input type="Text" readonly="readonly" id="SDate" value="" maxlength="20" size="9" name="SDate">
<a href="javascript:NewCal('SDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
<TD>To</TD>
<TD><input type="Text" readonly="readonly" id="DDate" value="" maxlength="20" size="9" name="DDate">
<a href="javascript:NewCal('DDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>
<TR>
<TD>Filter By</TD><TD><select name="by" size="1" id="by">
<option value="select" selected>Select</option>
<option value="SDate">SDate</option>
<option value="EDate">EDate</option>
</select></TD>
</TR>
</TABLE>
</br>
<input type="button" value="Show All Plans" onclick="showAll()" class="button">
</form>
<div id="txtHint"></div>
</body>
</html> 