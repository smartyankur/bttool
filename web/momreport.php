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
     echo "<h3>"."Hi ".$row['username']." ! Welcome To MOM Reporting Tool"."<h3>";
	 $username=$row['username'];
    } 	
?>
<html>
<head>
<?php
	
    $mquery = "select DISTINCT meetingdate from mommaster";
    $mretval = mysql_query( $mquery, $con );
    $mcount = mysql_num_rows($mretval);
	
	if($mcount==0)
		{
			?>
			<input type="button" value="Main Menu" onclick="location.href='index.php?ruser=<?php echo $user;?>';">
			<?php
			die('It Seems No Meeting Data Found; Contact SEPG');
		}
	?>
<h5> When we choose PROJECT; the selection criteria is only PROJECT. When we choose MEETING DATE the selection criteria is all the four parameters.The criteria are <u>ANDED</u> in downward direction.</h5>
<script type="text/javascript">

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

function showAll()
{
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

function showAllTwo()
{
str=document.forms["tstest"]["project"].value;
type=document.forms["tstest"]["type"].value;
//alert (str);

if (type=="select")
  {
  alert("Type must be selected");
  document.forms["tstest"]["type"].focus();
  return false;
  }

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
xmlhttp.open("GET","getalltwo.php?q="+str + "&r=" + type,true);
xmlhttp.send();
}

function showAllThree()
{
str=document.forms["tstest"]["project"].value;
type=document.forms["tstest"]["type"].value;
status=document.forms["tstest"]["status"].value;
//alert (str);

if (status=="select")
  {
  alert("Status must be selected");
  document.forms["tstest"]["type"].focus();
  return false;
  }

if (type=="select")
  {
  alert("Type must be selected");
  document.forms["tstest"]["type"].focus();
  return false;
  }

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
xmlhttp.open("GET","getallthree.php?q="+str + "&r=" + type + "&s=" + status,true);
xmlhttp.send();
}

function showAllFour()
{
str=document.forms["tstest"]["project"].value;
type=document.forms["tstest"]["type"].value;
status=document.forms["tstest"]["status"].value;
mdate=document.forms["tstest"]["MDate"].value;
//alert(str);
//alert(type);
//alert(status);
//alert(mdate);

if (str=="Select")
  {
  alert("Project must be selected");
  //document.forms["tstest"]["project"].focus();
  return false;
  }

if (type=="select")
  {
  alert("Type must be selected");
  //document.forms["tstest"]["type"].focus();
  return false;
  }

if (status=="select")
  {
  alert("Status must be selected");
  //document.forms["tstest"]["status"].focus();
  return false;
  }


if (mdate=="select")
  {
  alert("Meeting Date must be selected");
  //document.forms["tstest"]["MDate"].focus();
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
xmlhttp.open("GET","getallfour.php?q="+str + "&r=" + type + "&s=" + status+ "&t=" + mdate,true);
xmlhttp.send();
}

function showAllFive()
{
str=document.forms["tstest"]["project"].value;
type=document.forms["tstest"]["type"].value;
status=document.forms["tstest"]["status"].value;
mdate=document.forms["tstest"]["MDate"].value;
strng=trim(document.forms["tstest"]["SID"].value);
//alert(strng);
//alert(type);
//alert(status);
//alert(mdate);

if (str=="Select")
  {
  alert("Project must be selected");
  //document.forms["tstest"]["project"].focus();
  return false;
  }

if (type=="select")
  {
  alert("Type must be selected");
  //document.forms["tstest"]["type"].focus();
  return false;
  }

if (status=="select")
  {
  alert("Status must be selected");
  //document.forms["tstest"]["status"].focus();
  return false;
  }


if (mdate=="select")
  {
  alert("Meeting Date must be selected");
  //document.forms["tstest"]["MDate"].focus();
  return false;
  }

if(strng=="")
{
 alert("Please provide string in the text box");
 document.forms["tstest"]["SID"].focus();
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
xmlhttp.open("GET","getallfive.php?q="+str + "&r=" + type + "&s=" + status+ "&t=" + mdate+ "&u=" + strng,true);
xmlhttp.send();
}

function showAllSix()
{
str=document.forms["tstest"]["project"].value;
type=document.forms["tstest"]["type"].value;
status=document.forms["tstest"]["status"].value;
mdate=document.forms["tstest"]["MDate"].value;
stitle=trim(document.forms["tstest"]["MID"].value);
//alert(stitle);
//alert(type);
//alert(status);
//alert(mdate);

if (str=="Select")
  {
  alert("Project must be selected");
  //document.forms["tstest"]["project"].focus();
  return false;
  }

if (type=="select")
  {
  alert("Type must be selected");
  //document.forms["tstest"]["type"].focus();
  return false;
  }

if (status=="select")
  {
  alert("Status must be selected");
  //document.forms["tstest"]["status"].focus();
  return false;
  }


if (mdate=="select")
  {
  alert("Meeting Date must be selected");
  //document.forms["tstest"]["MDate"].focus();
  return false;
  }

if(stitle=="")
{
 alert("Please provide meeting title in the text box");
 document.forms["tstest"]["MID"].focus();
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
xmlhttp.open("GET","getallsix.php?q="+str + "&r=" + type + "&s=" + status+ "&t=" + mdate+ "&v=" + stitle,true);
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

</script>
</head>
<body background="bg.gif">
<h2>MOM Tool</h2>
<h6><div id="ResHint"><b></b></div></h6>
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

    echo "<select name=\"project\" onChange=\"showAll()\">"; 
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
<TD>Meeting Type</TD>
<TD><select name="type" size="1" onChange="showAllTwo()">
<option value="select" selected>Select</option>
<option value="kickoff">Kickoff</option>
<option value="clientmeeting">Clientmeeting</option>
<option value="progress">Project records</option>
<option value="milestone">Milestonesreview</option>
<option value="cmmi">Process Audit</option>
<option value="rca">RCA</option>
</select></TD>
</TR>

<TR>
<TD>Status</TD>
<TD><select name="status" size="1" onChange="showAllThree()">
<option value="select" selected>Select</option>
<option value="open">open</option>
<option value="close">close</option>
<option value="all">all</option>
<option value="wip">work in progress</option>
</select></TD>
</TR>
    <?php
	$query = "select DISTINCT meetingdate from mommaster";
    $retval = mysql_query( $query, $con );
    echo "<TR>";
	echo "<TD>"."Meeting Date"."</TD>";
	echo "<TD>";
	echo "<select name=\"MDate\" onChange=\"showAllFour()\">"; 
    echo "<option size =30 selected>Select</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
    echo "<option>$row[meetingdate]</option>"; 
    } 
    } 
    else 
	{
     echo "<option>No Meeting Dates Present</option>";  
    } 
    ?>
    </TD>
</TR>
<TR>
<TD>Unique Participant</TD>
<TD><input type="text" id="SID" maxlength="30" size="30" name="string"><input type="button" value="Search String" onclick="showAllFive()"></TD>
</TR>
<TR>
<TD>Unique Meeting Title</TD>
<TD><input type="text" id="MID" maxlength="30" size="30" name="MID"><input type="button" value="Search String" onclick="showAllSix()"></TD>
</TR>
</TABLE>
<?php
echo "<input type ='hidden' name='loggeduser' value='$username'>";
?>
<input type="button" value="Log Out" onclick="location.href='logout.php';">
</form>
<br />
<div id="txtHint"><b>MOM records will appear here.</b></div>

</body>
</html> 