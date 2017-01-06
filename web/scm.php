<?php	
	error_reporting(0);
	session_start();
	
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location:index.php");
    }
	
    $user=$_SESSION['login'];

    include('config.php');

    $query = "select username from login where uniqueid='$user'";
    
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
       echo "<h3>"."Hi ".$row['username']." ! Log SCM Findings at Project Level"."</h3>";
	 $username=$row['username'];
    } 	
	?>
<html>
<head>
<script type="text/javascript">

function submitresponse(str)
{
//alert (str);
 
var ptr = document.getElementById(str).value;
//alert (ptr);

if (ptr=="select")
{
 alert ("The status must be selected");
 //document.getElementById(str).focus();
 return false;
}

if (str=="")
  {
  document.getElementById("ResHint").innerHTML="";
  return;
  }

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
    document.getElementById("ResHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","updatescmstat.php?q="+str+ "&r=" + ptr,true);
xmlhttp.send();

}

function submitall()
{
//alert (123);

var project = trim(document.getElementById('project').value);
//alert(project)

if(project=="Select")
  {
  alert("Project should be specified");
  return false;
  }

var finding = trim(document.getElementById('finding').value);
if(finding=="")
  {
  alert("Finding should be selected");
  return false;
  }

var targetdate = trim(document.getElementById('TDate').value);
if(targetdate=="")
  {
  alert("Target Date should be selected");
  return false;
  }

var lutr = document.getElementById('luser').value;

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
    document.getElementById("ResHint").innerHTML=xmlhttp.responseText;
    }
  }
finding=encodeURIComponent(finding)
project=encodeURIComponent(project);
xmlhttp.open("GET","updatescm.php?a="+project+ "&b=" + finding+ "&c=" + targetdate+ "&d=" + lutr,true);
xmlhttp.send();
}


function showAll()
{
//newwindow.close();
str=document.forms["tstest"]["project"].value;
//alert (str);

if (str=="Select")
  {
  alert("Project must be selected");
  document.forms["tstest"]["project"].focus();
  return false;
  }

if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
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
xmlhttp.open("GET","getscminfo.php?q="+str,true);
xmlhttp.send();
}

function ShowAllFindings()
{

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
//str=encodeURIComponent(str);
xmlhttp.open("GET","getallscminfo.php",true);
xmlhttp.send();
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

function getfm()
{
 str=document.forms["tstest"]["project"].value;
 //alert(str);
 
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
    document.getElementById("fmHint").innerHTML=xmlhttp.responseText;
    }
  }
str=encodeURIComponent(str);
xmlhttp.open("GET","getfminfo.php?q="+str,true);
xmlhttp.send();
}

function showid()
{
var id = trim(document.getElementById('idno').value);
//alert(id);

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
id=encodeURIComponent(id);
xmlhttp.open("GET","getidinfo.php?q="+id,true);
xmlhttp.send();

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
<h4>Enter SCM Action Item</h4>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" action="submit.php" onsubmit="return validateForm()" method="post">
<div id="ResHint"></div>
<TABLE>
<TR>
	<TD>Project Name</TD>
	<td>
    <?php
	$con = mysql_connect("localhost","root","password");

    if (!$con)
      {
        die('Could not connect: ' . mysql_error());
      }

	mysql_select_db("audit") or die(mysql_error());
    $query = "select DISTINCT projectname from projectmaster where projectmanager= '$username' or accountmanager= '$username' or buhead='$username' or practicehead='$username' or sepghead='$username' or sepglead='$username' or md='$username' or ceo = '$username' or fmfour='$username' or fmthree='$username' or fmtwo='$username' or fmone='$username' or lead='$username' or scm='$username' or scmtwo='$username'";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found');
		}

    echo "<select name=\"project\" id=\"project\" onchange=\"getfm()\">"; 
    echo "<option size =30 selected value=\"Select\">Select</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    {
	 if(strlen($row[projectname])<>0)
		{		 
         echo "<option>$row[projectname]</option>"; 
        }
	} 
 
    } 
    else {
    echo "<option>No Names Present</option>";  
    } 
    ?>
    </td>
</TR>

<TR>
<td>FM Details</td><td><div name="fmHint" id="fmHint"><?php echo $fmdetails;?></div></td>
</TR>

<TR>
<TD>Audit Finding</TD>
<TD><textarea name="finding" id="finding" rows="6" cols="30"></textarea></TD>
</TR>

<TR>
<TD>Target Closure Date</TD>
<TD><input type="Text" id="TDate" value="" maxlength="20" size="9" name="TDate" readonly="readonly">
<a href="javascript:NewCal('TDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>

</TABLE>
<table border="1">
<input type="button" class="button" value="Submit" onclick="submitall()">
<input type="button" class="button" value="Log Out" onclick="location.href='logout.php';">
<input type="button" class="button" value="Show Projectwise Findings" onclick="showAll()">
<input type="button" class="button" value="Show Findings of All Projects" onclick="ShowAllFindings()">To see a particular finding give ID here<input type=text maxlength=3 size=1 name="idno" id="idno"><input type="button" class="button" value="Show row related to this ID" onclick="showid()">
<input type ="hidden" name="luser" id="luser" value="<?php echo $username;?>">
<div id="txtHint"></div>
<br>
<br>
</form>
</body>
</html> 