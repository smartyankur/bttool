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
       echo "<h3>"."Hi ".$row['username']." ! Welcome To NC Report Individual Response"."<h3>";
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
function submitresponse(str)
{
  
  var ptr = trim(document.getElementById(str).value);
  var auditee=document.forms["tstest"]["auditee"].value;
  

if (ptr=="")
{
 alert ("The response box is empty");
 document.getElementById(str).focus();
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
ptr= encodeURIComponent(ptr);
xmlhttp.open("GET","response.php?q="+str+ "&r=" + ptr+ "&s=" + auditee,true);
xmlhttp.send();
}

function showAll()
{
str=document.forms["tstest"]["project"].value;
var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
auditee=document.forms["tstest"]["auditee"].value;
str= encodeURIComponent(str);
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
		$('.loader').hide();
		$('.loaderParent').hide();
    }
  }
  $('.loader').show();
  $('.loaderParent').show();
xmlhttp.open("GET","getncaging.php?q="+str+"&pro_id="+pro_id+"&r="+auditee, true);
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
<h2>NC Report. Here You May Respond For Each NC Individually</h2>
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
    echo "<option size =30 selected value=\"Select\">Select</option>";
    
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

</TABLE>
<br>
<br>
<?php
echo "<input type ='hidden' name='auditee' value='$username'>";
?>
<input type="button" class="button" value="Log Out" onclick="location.href='logout.php';">
<input type="button" class="button" value="Show All Action Items" onclick="showAll()">
</form>
<div id="txtHint"><b>ActionItems will appear here.</b></div>
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