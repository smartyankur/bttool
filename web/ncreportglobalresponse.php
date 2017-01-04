<?php	
	session_start();
	
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location:index.php");
    }
	$user=$_SESSION['login'];
	include("config.php");

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
       echo "<h3>"."Hi ".$row['username']." ! Welcome To NC Report Global Response"."<h3>";
	 $username=$row['username'];
    } 	
	?>
<html>
<head>
<link href="css/ajaxloader.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="js/jquery.js"></script>
<script>
$(document).ready(function(){
	$('.loaderParent').hide();
	$('.loader').hide();
});
</script>
<script type="text/javascript">
function showAll()
{
 var ttr = trim(document.getElementById('project').value);
 var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
 var utr = trim(document.getElementById('DDate').value);

if (ttr=="Select")
{
 alert ("Please Select Project");
 return false;
}

if (utr=="")
{
 alert ("Please Provide Date");
 return false;
}

//if (str=="")
  //{
  //document.getElementById("txtHint").innerHTML="";
  //return;
  //}

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
		$('.loader').hide();
		$('.loaderParent').hide();
    }
  }
ttr= encodeURIComponent(ttr);
$('.loader').show();
$('.loaderParent').show();
xmlhttp.open("GET","globaldump.php?q="+ttr+"&pro_id="+pro_id+"&r="+utr, true);
xmlhttp.send();
}


function submitresponse()
{
  
  var ptr = trim(document.getElementById('project').value);
  var str = trim(document.getElementById('DDate').value);
  var rtr = trim(document.getElementById('response').value);
  var auditee=document.forms["tstest"]["auditee"].value;
  var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');

  
  

if (ptr=="Select")
{
 alert ("Please Select Project");
 return false;
}

if (rtr=="")
{
 alert ("Please Provide Response");
 document.getElementById('response').focus();
 return false;
}

if (str=="")
  {
  alert ("Please Provide Discussion Date");
  document.getElementById('DDate').focus();
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
rtr= encodeURIComponent(rtr);
ptr= encodeURIComponent(ptr);
xmlhttp.open("GET","responseglobal.php?q="+str+"&pro_id="+pro_id+"&r="+ptr+"&s="+rtr+"&t="+auditee, true);
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
<h2>NC Report. Here You May Give One Single Response For A Set Of NCs</h2>
<h5>Select project name and discussion(communication) date to show all action items. You can fill and submit the response for all of them</h5>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest">
<div id="ResHint"><b></b></div>
<br>
<TABLE>
<TR>
	<TD>Project Name</TD>
	<TD>
    <?php
	$query = "select DISTINCT projectname, pindatabaseid from projectmaster where projectmanager= '$username' or accountmanager= '$username' or buhead='$username' or practicehead='$username' or sepghead='$username' or sepglead='$username' or md='$username' or ceo = '$username' or fmfour='$username' or fmthree='$username' or fmtwo='$username' or fmone='$username' or lead='$username'";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('No projects found; Need to feed the master table; buzz SEPG');
		}

    echo "<select id=\"project\">"; 
    echo "<option size =30 selected>Select</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
    echo "<option ref='".$row['pindatabaseid']."'>$row[projectname]</option>"; 
    } 
 
    } 
    else {
    echo "<option>No Names Present</option>";  
    } 
    ?>
    </TD>
</TR>
<TR>
<TD>Discussion Date</TD>
<TD><input type="Text" id="DDate" value="" maxlength="20" size="9" name="DDate" readonly="readonly">
<a href="javascript:NewCal('DDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>
<TR>
<TD>Auditee Response</TD>
<TD><textarea id="response" rows="6" cols="30" maxlength="222"></textarea></TD>
</TR>
</TABLE>
<?php
echo "<input type ='hidden' name='auditee' value='$username'>";
?>
<br>
<input type="button" class="button" value="Log Out" onclick="location.href='logout.php';">
<input type="button" class="button" value="Show All Action Items" onclick="showAll()">
<input type="button" class="button" value="Submit the Response" onclick="submitresponse()">
</form>
<br />
<div id="txtHint"><b>ActionItems Discussed On The Selected Date will appear here.</b></div>
<div class="loaderParent"></div>
	<div class="loader">
		<span></span>
		<span></span>
		<span></span>
	</div>
<?php
mysql_close($con);
?>
</body>
</html> 