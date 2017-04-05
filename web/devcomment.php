<?php	
session_start();
	
if(!(isset($_SESSION['login']) && $_SESSION['login'] != '')){
  header("Location:index.php");
}
$user = $_SESSION['login'];
    	
include("config.php");

$query = "select username from login where uniqueid='$user'";
$retval = mysql_query( $query, $con );
$count = mysql_num_rows($retval);
	
if($count==0){
	die('Data Not Found Please contact SEPG');
}

    
while($row = mysql_fetch_assoc($retval)){ 
  echo "<br>";
  echo "<br>";
  echo "<h3>"."Hi ".$row['username']." ! Welcome To Dev Team Response Interface."."</h3>";
  $username=$row['username'];
} 	
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="css/ajaxloader.css" rel="stylesheet" type="text/css" media="screen" />
<script src="js/jquery.js"></script>
<script src="js/jquery.selectboxes.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.loaderParent').hide();
	$('.loader').hide();	
});

function submitresponse(str)
{
  
  rstr="stat"+str;
 
  var ptr = trim(document.getElementById(str).value);
  
  var auditee=document.forms["tstest"]["auditee"].value;
  
  var stat= trim(document.getElementById(rstr).value);
  

if (ptr=="")
{
 alert ("The response box is empty");
 //document.getElementById(str).focus();
 return false;
}

if (stat=="Select")
{
 alert ("The Status Should be selected");
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
ptr= encodeURIComponent(ptr);
xmlhttp.open("GET","devresponse.php?q="+str+ "&r=" + ptr+ "&s=" + auditee+ "&t=" + stat,true);
xmlhttp.send();

}
function showAll(){
  displayRecords(10,1);
}

function displayRecords(numRecords, pageNum) {
	  var issuetype = 'any'; 
	  str       = document.forms["tstest"]["project"].value;
	  auditee   = document.forms["tstest"]["auditee"].value;
	  issuetype = document.forms["tstest"]["bugStatus"].value;  
	  pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
	  chd = document.forms["tstest"]["course"].value;
	  str = encodeURIComponent(str);
	  if(str=="Select"){
		alert("Please select the project");
		return; 
	  }

	  if(str==""){
		document.getElementById("txtHint").innerHTML="";
		return;
	  }
	
	$.ajax({
		type: "GET",
		url: "getbugsdev.php",
		data: "show=" + numRecords + "&pagenum=" + pageNum+"&issuetype="+issuetype+"&q="+str+"&pro_id="+pro_id+"&r=" + auditee+"&chd_id="+chd,
		cache: false,
		beforeSend: function() {
			$('.loader').show();
			$('.loaderParent').show();
			//$('.loader').html('<img src="pagination/loader.gif" alt="" width="24" height="24" style="padding-left: 400px; margin-top:10px;" >');
		},
		success: function(html) {
			$("#txtHint").html(html);
			//$('.loader').html('');
			$('.loader').hide();
			$('.loaderParent').hide();
		}
	});
}


function changeDisplayRowCount(numRecords) {
	$('.loader').show();
	$('.loaderParent').show();
	displayRecords(numRecords, 1);
}

function export123(){
	if($('#project').val() != '') {
		var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
		var chd = document.forms["tstest"]["course"].value;
		//var issuetype = 'any'; 
		issuetype = document.forms["tstest"]["bugStatus"].value;
	    window.open('exportbugs.php?mode=devbug&q='+$('#project').val()+'&pro_id='+pro_id+'&chd_id='+chd+'&issuetype='+issuetype);
	} else {
		alert('Please select project');
	}
}

function populateInfo(){
  var project = document.forms["tstest"]["project"].value;
  var pro_id = (document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref')) ? document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref') : 'null';
	if(project != '' && project != undefined && project != "Select" ) {
	  
	  $("#course").removeOption(/./);
	  $('#course').ajaxAddOption(
	    'getCourseInfo.php?q='+project+'&pro_id='+pro_id,
	    {},
		false,
		function(){
			$(this).selectOptions('');
		}
	  );
  }
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

function sendCompletionOfFixesMail()
{
 var project = trim(document.getElementById('project').value);
 pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
 var course = trim(document.getElementById('course').value);
 if(project=="Select") {alert("Please select the project"); return false;}
 project=encodeURIComponent(project);
 if(course=="") {alert("Course Required"); return false;}
 mywindow=window.open ("fixesmail.php?pro="+project+"&pro_id="+pro_id+"&chd="+course,"Ratting","scrollbars=1,width=600,height=600,0,status=0,");
 if (window.focus) {mywindow.focus()}
}

function changeemail()
{
 var project = trim(document.getElementById('project').value);
 if(project=="Select") {alert("Please select the project"); return false;}
 mywindow=window.open ("changefmemail.php?id="+project,"Ratting","scrollbars=1,width=550,height=170,0,status=0,");
 if (window.focus) {mywindow.focus()}
}

function changefms()
{
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
<body onload="populateInfo();">
<form name="tstest">
<div id="ResHint"><b></b></div>
<br>
<TABLE>
<TR>
	<TD>Project Name</TD>
	<TD>
    <?php
      $query = "select DISTINCT projectname, pindatabaseid from projectmaster where projectmanager= '$username' or accountmanager= '$username' or buhead='$username' or practicehead='$username' or sepghead='$username' or sepglead='$username' or md='$username' or ceo = '$username' or fmfour='$username' or fmthree='$username' or fmtwo='$username' or fmone='$username' or lead='$username' or dev1='$username' or dev2='$username' or dev3='$username' or dev4='$username' or dev5='$username' or dev6='$username' or dev7='$username' or dev8='$username' or dev9='$username' or dev10='$username' or dev11='$username' or dev12='$username' order by projectname ASC";
    
      $retval = mysql_query( $query, $con );
      $count = mysql_num_rows($retval);
      
      if($count==0){
        die('Data Not Found');
      }
      
      echo "<select name=\"project\" id=\"project\" onchange=\"getfm(); populateInfo()\">"; 
      echo "<option size =30 selected value=\"Select\">Select</option>";
    
    	if(mysql_num_rows($retval)){ 
        while($row = mysql_fetch_assoc($retval)){ 
          echo "<option ref='$row[pindatabaseid]'>$row[projectname]</option>"; 
        } 
      }else{
        echo "<option>No Names Present</option>";  
      } 
    ?>
    </TD>
</TR>

<TR>
<TD>Course</TD>
<TD>
<select name="course" size="1" id="course">
<option value="select" selected>Select</option>
</select>
</TD>
</TR>

<TR>
  <TD>Bug Status</TD>
  <TD>
    <select name="bugStatus" id="bugStatus"> 
      <option>hold</option>
      <option>open</option>
      <option>closed</option>
      <option>ok as is</option>
      <option>reopened</option>
      <option>fixed</option>
	  <option value="any">All</option>
    </select>
  </TD>
</TR>

<TR>
  <td>FM Details</td>
  <td><div name="fmHint" id="fmHint"></div></td>
</TR>

</TABLE>
<br>
<?php
echo "<input type ='hidden' name='auditee' value='$username'>";
?>
<input type="button" class="button" value="Log Out" onclick="location.href='logout.php';">
<input type="button" class="button" value="Show Issues" onclick="showAll()">
<input type="button" class="button" value="Send Completion of Fixes Mail" onclick="sendCompletionOfFixesMail()">
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