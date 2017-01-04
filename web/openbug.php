<html>
<head>
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

    $query = "select username from login where uniqueid='$user'";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found Please contact SEPG');
		}

    
    while($row = mysql_fetch_assoc($retval)) 
    { 
     echo "<h4>"."Hi ".$row['username']." ! Welcome To BUG Reporting Tool"."</h4>";
	 $username=$row['username'];
    } 	
?>
</head>
<body background="bg.gif">
<?php
$con = mysql_connect("localhost","root","password");

    if (!$con)
      {
        die('Could not connect: ' . mysql_error());
      }

	mysql_select_db("audit") or die(mysql_error());
?>
<script type="text/javascript">
function submitresponse(str)
{
//alert(str);
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
xmlhttp.open("GET","updaterstat.php?q="+str+ "&r=" + ptr,true);
xmlhttp.send();
}

function deleter(str)
{
//alert(str);

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
xmlhttp.open("GET","deleterstat.php?q="+str,true);
xmlhttp.send();
}

function saverec()
{
 var numericExpression = /^[0-9]+$/;
 var alphaExp = /^[a-zA-Z /s]*$/;
 var alphanumericExp = /^[0-9a-zA-Z._, /s]*$/;
 var project = trim(document.getElementById('project').value);
 var phase = trim(document.getElementById('phase').value);
 var reviewer = trim(document.getElementById('reviewer').value);
 var module = trim(document.getElementById('module').value);
 var topic = trim(document.getElementById('topic').value);
 var pagenumber = trim(document.getElementById('pagenumber').value);
 var bdr = trim(document.getElementById('bdr').value);
 
 if(project=="Select")
  {
  alert("Project must be selected");
  return false;
  }

 if(phase=="select")
  {
  alert("Phase must be selected");
  return false;
  }
  
 if(reviewer=="")
  {
  alert("Reviewer name should be provided");
  return false;
  }
 
 if(module=="select")
  {
  alert("Module should be selected");
  return false;
  }

 if(topic=="select")
  {
  alert("Topic should be selected");
  return false;
  }

 if(pagenumber=="")
  {
  alert("Pagenumber should be provided");
  return false;
  }

  if(bdr=="")
  {
  alert("Bug description should be provided");
  return false;
  }

  if(!pagenumber.match(numericExpression))
	{
	alert("Page Number Should be Numeric");
	return false;
    }
	
//  fun(trim(document.getElementById('reviewer').value));       
   //if ( /^[a-zA-Z\s]*$/.test(trim(document.getElementById('reviewer').value))) {
   
  if(!reviewer.match(alphaExp))  
	{
	alert("Reviewer Name Should be purely alphabetic.");
	return false;
    }

  if(!bdr.match(alphanumericExp))
	{
	alert("Please avoid all special characters. Description can take only alphabets and numbers.");
	return false;
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
project=encodeURIComponent(project);
phase=encodeURIComponent(phase);
reviewer=encodeURIComponent(reviewer);
module=encodeURIComponent(module);
topic=encodeURIComponent(topic);
pagenumber=encodeURIComponent(pagenumber);
bdr=encodeURIComponent(bdr);

xmlhttp.open("GET","savebug.php?q="+project+ "&r=" + phase+ "&s=" + reviewer+ "&t=" + module+ "&u=" + topic+ "&v=" + pagenumber+ "&w=" + bdr,true);
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
xmlhttp.open("GET","getallbug.php?q="+str,true);
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
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" action="openbug.php" onsubmit="return verify()" method="post">
<div style="color: red;" id="ResHint"></div>
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
    $query = "select projectname from projectmaster";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found');
		}

    echo "<select name=\"project\" id=\"project\">"; 
    echo "<option size =30 selected>Select</option>";
    
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
<TD>Phase</TD><TD><select name="phase" size="1" id="phase">
<option value="select" selected>Select</option>
<option value="alpha">Alpha</option>
<option value="beta">Beta</option>
<option value="gold">Gold</option>
</select></TD>
</TR>
<TR>
<TD>Reviewer</TD>
<TD><input type=text maxlength=20 size=20 name="reviewer" id="reviewer"></TD>
</TR>

<TR>
<TD>Module#</TD>
<TD><select name="module" size="1" id="module">
<option value="select">Select</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
</select></TD>
</TR>

<TR>
<TD>Topic #</TD>
<TD><select name="topic" size="1" id="topic">
<option value="select">Select</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
</select></TD>
</TR>

<TR>
<TD>Page  #</TD>
<TD><input type=text maxlength=3 size=1 name="pagenumber" id="pagenumber"></TD>
</TR>

<TR>
<TD>Bug Description</TD>
<TD><textarea name="bdr" rows="4" cols="30" id="bdr">This box can take alphabets,numbers,  space,underscore and coma.</textarea></TD>
</TR>

</TABLE>
<?php
echo "<input type ='hidden' name='user' value='$user'>";
?>
<input type="button" value="Save" onclick="saverec()">
<input type="button" value="Log Out" onclick="location.href='logout.php';">
<input type="button" value="Show All Records" onclick="showAll()">
<?php
echo "<input type ='hidden' name='adminuser' value='$user'>";
?>
<br>
<br>
<?php
if($msg<>"")
{
  $result = mysql_query("SELECT id FROM bugreport where descr='".$msg."'");
  $row = mysql_fetch_array($result);
  echo "Last record created with id :".$row['id']." and description :".$msg;
}
?>
<br>
<div id="txtHint"><b>Records will appear here.</b></div>
</form>
</body>
</html> 