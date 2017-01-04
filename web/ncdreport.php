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
       echo "<h3>"."Hi ".$row['username']." ! Welcome To NC Density (No Of NCs per Personhour) Report"."<h3>";
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
var decimalExpression = /^[0-9. ]+$/;
str=trim(document.forms["tstest"]["project"].value);
efrt=trim(document.forms["tstest"]["effort"].value);
var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');

if (str=="Select")
 {
  alert ("Please Select A Project");
  document.forms["tstest"]["project"].focus();
  return false;
 }

if (efrt=="")
 {
  alert ("Please Provide Effort.");
  document.forms["tstest"]["effort"].focus();
  return false;
 }

if(!efrt.match(decimalExpression))
  {
  alert("Effort should be Numeric or Decimal");
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
		$('.loader').hide();
		$('.loaderParent').hide();
    }
 }
$('.loader').show();
$('.loaderParent').show();
xmlhttp.open("GET","getncden.php?q="+str+"&pro_id="+pro_id+"&r="+efrt, true);
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
<h2>NC Density Report. Here You Would Find Open NCs per PH of effort.</h2>
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
			die('Data Not Found');
		}

    echo "<select name=\"project\">"; 
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
<TD>Actual Effort</TD>
<TD><input type="text" name="effort" id="effort" size="9"></TD>
</TR>

</TABLE>
<br>
<br>
<input type="button" class="button" value="Log Out" onclick="location.href='logout.php';">
<input type="button" class="button" value="Show NC Density" onclick="showAll()">
</form>
<br />
<div id="txtHint"><b>Density will appear here.</b></div>
<div class="loaderParent"></div>
	<div class="loader">
		<span></span>
		<span></span>
		<span></span>
	</div>
</body>
</html> 