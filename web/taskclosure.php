<?php	
	error_reporting(0);
	session_start();
	include("config.php");

	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location:index.php");
    }
	$user=$_SESSION['login'];
	

    $query = "select username from login where uniqueid='$user'";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found Please contact SEPG');
		}

    
    while($row = mysql_fetch_assoc($retval)) 
    { 
     echo "</br>";
     echo "</br>";
	 echo "</br>";
	 echo "<h3>"."Hi ".$row['username']." ! Welcome To QC Task Closure Interface"."</h3>";
	 $username=$row['username'];
    } 	
?>

<html>
<head>
<script type="text/javascript">

function showAll()
{
str=document.forms["tstest"]["project"].value;
auditee=document.forms["tstest"]["loggeduser"].value;

if (str=="Select")
{
 alert("Please select the project");
 return; 
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
str= encodeURIComponent(str);
xmlhttp.open("GET","getqctasks.php?q="+str+ "&r=" + auditee,true);
xmlhttp.send();
}

function closetask(id,mid)
{
 id=id;
 mid=mid;
 auditee=document.forms["tstest"]["loggeduser"].value;
 
 mywindow=window.open ("closeqctask.php?q="+id+ "&r=" + auditee+ "&s=" + mid,"Ratting","scrollbars=1,width=550,height=300,0,status=0,");
 if (window.focus) {mywindow.focus()}
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
</head>
<body>
<form name="tstest">
<br>
<TABLE>
<TR>
	<TD>Project Name</TD>
	<TD>
    <?php
	$query = "select DISTINCT project from qcplan where qc='$username'";
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found');
		}

    echo "<select name=\"project\" id=\"project\">"; 
    echo "<option size =30 selected value=\"Select\">Select</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
    echo "<option>$row[project]</option>"; 
    } 
 
    } 
    else {
    echo "<option>No Names Present</option>";  
    } 
    ?>
    </TD>
</TR>

</TABLE>
<br>
<?php
echo "<input type ='hidden' name='loggeduser' value='$username'>";
?>
<input type="button" value="Log Out" onclick="location.href='logout.php';">
<input type="button" value="Show All Tasks" onclick="showAll()">
</form>
<div id="txtHint"><b>Tasks Assigned Will Appear Here...</b></div>
<?php
mysql_close($con);
?>
</body>
</html> 