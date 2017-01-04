<?php	
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

    $query = "select username from login where uniqueid='$user'";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
	{
			die('Data Not Found Please contact SEPG');
	}

    
    while($row = mysql_fetch_assoc($retval)) 
    { 
     echo "<h3>"."Hi ".$row['username']." ! Welcome To MOM Tool"."<h3>";
	 $username=$row['username'];
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

function submitresponse(str)
{
  //alert (str);
  var ptr = trim(document.getElementById(str).value);
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
xmlhttp.open("GET","updatestat.php?q="+str+ "&r=" + ptr,true);
xmlhttp.send();

}

function myPopup() {
var x= trim(document.forms["tstest"]["agenda"].value);
var y= trim(document.forms["tstest"]["participants"].value);
var e= trim(document.forms["tstest"]["MDate"].value);
var f= trim(document.forms["tstest"]["project"].value);
var g= trim(document.forms["tstest"]["discussionpoint"].value);
var h= trim(document.forms["tstest"]["loggeduser"].value);
var i= trim(document.forms["tstest"]["type"].value);
//alert(h);

if (f=="Select")
  {
  alert("Project must be selected");
  document.forms["tstest"]["project"].focus();
  return false;
  }

if (x=="")
  {
  alert("Agenda must be filled");
  document.forms["tstest"]["agenda"].focus();
  return false;
  }

if (y=="")
  {
  alert("Participants list must be filled");
  document.forms["tstest"]["participants"].focus();
  return false;
  }

if (g=="")
  {
  alert("Discussion point must be filled");
  document.forms["tstest"]["discussionpoint"].focus();
  return false;
  }

if (i=="select")
  {
  alert(" Meeting Type must be filled");
  document.forms["tstest"]["type"].focus();
  return false;
  }

if (e=="")
  {
  alert("Meeting date must be chosen");
  document.forms["tstest"]["MDate"].focus();
  return false;
  }
//window.open( "http://www.google.com/" )
x= encodeURIComponent(x);
y= encodeURIComponent(y);
g= encodeURIComponent(g);
newwindow=window.open("window-child.php?param1="+ x + "&param2="+ y+ "&param3="+ e+ "&param4="+ f+ "&param5="+ g+ "&param6="+ h+ "&param7="+ i,"Ratting","scrollbars=1,width=550,height=170,0,status=0,");
//http://www.gamedev.net/community/forums/post.asp?method=reply&topic_id=419614
//alert ("Hi");
if (window.focus) {newwindow.focus()}
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
xmlhttp.open("GET","getall.php?q="+str,true);
xmlhttp.send();
}

function changeai(str)
{
//alert(str);
newwindow=window.open("chai.php?param="+str,"Ratting","scrollbars=1,width=550,height=170,0,status=0,");
if (window.focus) {newwindow.focus()}
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
</head>
<body background="bg.gif">
<h2>MOM Tool</h2>
<h6><div id="ResHint"><b></b></div></h6>
<h4>* Mandatory Fields</h4>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest">

<TABLE>
<TR>
<TD>Project Name</TD>
<TD>
    <?php
	$query = "select DISTINCT projectname from projectmaster where projectmanager= '$username' or accountmanager= '$username' or buhead='$username' or practicehead='$username' or sepghead='$username' or sepglead='$username' or md='$username' or ceo = '$username' or fmfour='$username' or fmthree='$username' or fmtwo='$username' or fmone='$username' or lead='$username'";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Project Data Not Found; Contact SEPG');
		}

    echo "<select name=\"project\">"; 
    echo "<option size =30 selected>Select</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
    echo "<option>$row[projectname]</option>"; 
    } 
    } 
    else 
	{
     echo "<option>No Names Present</option>";  
    } 
    ?>
    </TD>
</TR>

<TR>
<TD>Agenda*</TD>
<TD><textarea name="agenda" rows="4" cols="30" id="agenda"></textarea></TD>
</TR>

<TR>
<TD>Main Participants*</TD>
<TD><textarea name="participants" rows="4" cols="30" id="participant"></textarea></TD>
</TR>

<TR>
<TD>Meeting Type*</TD>
<TD><select name="type" size="1">
<option value="select">Select</option>
<option value="kickoff">Kickoff</option>
<option value="clientmeeting">Clientmeeting</option>
<option value="progress">Project records</option>
<option value="milestone">Milestonesreview</option>
<option value="cmmi">Process Audit</option>
<option value="rca">RCA</option>
</select></TD>
</TR>

<TR>
<TD>Meeting Title*</TD>
<TD><input type="Text" id="discussionpoint" maxlength="20" size="20" name="discussionpoint"></TD>
</TR>

<TR>
<TD>Meeting Date*</TD>
<TD><input type="Text" readonly="readonly" id="MDate" value="" maxlength="20" size="9" name="MDate">
<a href="javascript:NewCal('MDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>
</TABLE>
<?php
echo "<input type ='hidden' name='loggeduser' value='$username'>";
?>
<input type="button" value="Log Out" onclick="location.href='logout.php';">
<input type="button" onClick="myPopup()" value="Add Action Items">
<input type="button" value="Show All AIs" onclick="showAll()">
</form>
<br />
<div id="txtHint"><b>MOM records will appear here.</b></div>

</body>
</html> 