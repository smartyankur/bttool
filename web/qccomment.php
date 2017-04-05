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
       echo "<h3>"."Hi ".$row['username']." ! Welcome To QC Team Response Interface."."</h3>";
	 $username=$row['username'];
    } 	
	?>

<html>
<head>
<link href="css/ajaxloader.css" rel="stylesheet" type="text/css" media="screen" />
<script src="js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.loaderParent').hide();
	$('.loader').hide();	
});
function submitresponse(str)
{
 
  rstr="round"+str;
  
  var ptr = trim(document.getElementById(str).value);
  
  var auditee=document.forms["tstest"]["auditee"].value;
 
  var round= trim(document.getElementById(rstr).value);
 
if (ptr=="")
{
 alert ("The response box is empty");
 
 return false;
}

if (round=="Select")
{
 alert ("Please select the round");
 
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
xmlhttp.open("GET","qcresponse.php?q="+str+ "&r=" + ptr+ "&s=" + auditee+ "&t=" + round,true);
xmlhttp.send();
}

function showAll()
{
str=document.forms["tstest"]["project"].value;
auditee=document.forms["tstest"]["auditee"].value;
str= encodeURIComponent(str);
pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
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
		$('.loaderParent').hide();
		$('.loader').hide();
		document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
//str= encodeURIComponent(str);
$('.loader').show();
$('.loaderParent').show();
xmlhttp.open("GET","getbugs.php?q="+str+"&pro_id="+pro_id+"&r=" + auditee,true);
xmlhttp.send();
}

function getfm()
{
 document.getElementById("txtHint").innerHTML="";
 str=document.forms["tstest"]["project"].value;
 pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');

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
xmlhttp.open("GET","getfminfo.php?q="+str+"&pro_id="+pro_id,true);
xmlhttp.send();

}

function showmailwin()
{
 //alert(123);

 var project = trim(document.getElementById('project').value);
 if(project=="Select") {alert("Please select the project"); return false;}
 project=encodeURIComponent(project);
 mywindow=window.open ("getidqc.php?pro="+project,"Ratting","scrollbars=1,width=550,height=170,0,status=0,");
 if (window.focus) {mywindow.focus()}
}

function changeemail()
{
 var project = trim(document.getElementById('project').value);
 if(project=="Select") {alert("Please select the project"); return false;}
 mywindow=window.open ("changepmmail.php?id="+project,"Ratting","scrollbars=1,width=550,height=170,0,status=0,");
 if (window.focus) {mywindow.focus()}
}

function changefms()
{
 //alert(123);
 var project = trim(document.getElementById('project').value);
 if(project=="Select") {alert("Please select the project"); return false;}
 mywindow=window.open ("changepmfm.php?id="+project,"Ratting","scrollbars=1,width=550,height=170,0,status=0,");
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
</style>
</head>
<body>
<form name="tstest">
<div id="ResHint"><b></b></div>
<br>
<TABLE>
<TR>
	<TD>Project Name</TD>
	<TD>
    <?php
	$query = "select DISTINCT projectname, pindatabaseid from projectmaster where projectmanager= '$username' or accountmanager= '$username' or buhead='$username' or practicehead='$username' or sepghead='$username' or sepglead='$username' or md='$username' or ceo = '$username' or fmfour='$username' or fmthree='$username' or fmtwo='$username' or fmone='$username' or lead='$username' or tester1='$username' or tester2='$username' or tester3='$username' or tester4='$username' or tester5='$username' or tester6='$username' or tester7='$username' or tester8='$username' order by projectname ASC";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found');
		}

    echo "<select name=\"project\" id=\"project\"  onchange=\"getfm()\">"; 
    echo "<option size =30 selected value=\"Select\">Select</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
    echo "<option ref='$row[pindatabaseid]'>$row[projectname]</option>"; 
    } 
 
    } 
    else {
    echo "<option>No Names Present</option>";  
    } 
    ?>
    </TD>
</TR>

<TR>
<td>FM Details</td><td><div name="fmHint" id="fmHint"></div></td>
</TR>

</TABLE>
<br>
<?php
echo "<input type ='hidden' name='auditee' value='$username'>";
?>
<input type="button" class="button" value="Log Out" onclick="location.href='logout.php';">
<input type="button" class="button" value="Show All Issues" onclick="showAll()">
</form>
<div id="txtHint"><b>Bugs logged by QC will appear here.</b></div>
<?php
mysql_close($con);
?>
<div class="loaderParent"></div>
	<div class="loader">
		<span></span>
		<span></span>
		<span></span>
	</div>
</body>
</html> 