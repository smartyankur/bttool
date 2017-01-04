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
	 echo "<h3>"."Hi ".$row['username']." ! Filter All Requests by Delivery Date"."</h3>";
     echo "<h5>"."* Send Request For Priortization"."</h5>";
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
window.onunload = unloadPage;

function showAll()
{
//newwindow.close();
str=document.forms["tstest"]["DDate"].value;
//alert (str);
if(str == ""){alert("Please mention develivery date"); return false;}

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
str=encodeURIComponent(str);
xmlhttp.open("GET","gettasks.php?q="+str,true);
xmlhttp.send();
}

function unloadPage()
{
 //alert("unload event detected!");
 newwindow.close();
 //chwindow.close();
}

function verify()
{
 
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
<TD>Planned Delivery Date</TD>
<TD><input type="Text" readonly="readonly" id="DDate" value="" maxlength="20" size="9" name="DDate">
<a href="javascript:NewCal('DDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>
</TABLE>
</br>
<input type="button" value="Show All Request" onclick="showAll()" class="button">
</form>
<div id="txtHint"></div>
</body>
</html> 