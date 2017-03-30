<html>
<head>
<title>Project Report</title>
<?php	
error_reporting(0);
session_start();

include("class.phpmailer.php");  

if(!(isset($_SESSION['login']) && $_SESSION['login'] != '')){
  header("Location:index.php");
}
$user=$_SESSION['login'];    

include("config.php");
$query  = "select * from login where uniqueid='$user'";
$retval = mysql_query($query, $con);
$count  = mysql_num_rows($retval);

if($count==0){
  die('Data Not Found Please contact SEPG');
}

while($row = mysql_fetch_assoc($retval)){ 
  echo "<br>";
  echo "<br>"; 
  echo "<h4>"."Hi ".$row['username']." ! Welcome to SB Reviewe Document"."</h4>";
  $username = $row['username'];
  $email    = $row['email'];    
} 	


?>

<style>
div.ex{
  height:250px;
  width:400px;
  background-color:white
}

textarea.hide{
  visibility:none;
  display:none;
}

body{
  background:url('qcr.jpg') no-repeat;
}

.button{
  background-color: #F7941C;
  border-bottom:#F7941C;
  border-left:#F7941C;
  border-right:#F7941C;
  border-top:#F7941C;
  color:black;
  font-family:Tahoma
  box-shadow:2px 2px 0 0 #014D06;
  border-radius:10px;
  border:1px outset #b37d00;
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
<script type="text/javascript" src="js/jquery.js"></script>
<script language="JavaScript" src="datetimepicker.js"></script>
<script>
function displayRecords(numRecords = 10, pageNum = 1){
	var project = trim(document.getElementById('project').value);
	var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
	var fdate = trim(document.getElementById('FDate').value);
	if(project != "Select" ){
		$.ajax({
			type: "GET",
			url: "project_report_chd.php",
			data: "id="+pro_id,
			cache: false,
			beforeSend: function() {
				$('.loader').show();
				$('.loaderParent').show();
			},
			success: function(html) {
				$("#txtHint").html(html);
				//$('.loader').html('');
				$('.loader').hide();
				$('.loaderParent').hide();
			}
		});
		
	}else if(fdate != "") {
		$.ajax({
			type: "GET",
			url: "project_report_chd.php",
			data: "fdate="+fdate,
			cache: false,
			beforeSend: function() {
				$('.loader').show();
				$('.loaderParent').show();
			},
			success: function(html) {
				$("#txtHint").html(html);
				//$('.loader').html('');
				$('.loader').hide();
				$('.loaderParent').hide();
			}
		});
	}else{
		alert('please select project name or from date');
		return;  
	}
}
function showAll(){
 displayRecords(10,1);
}


function changeDisplayRowCount(numRecords) {
	$('.loader').show();
	$('.loaderParent').show();
	displayRecords(numRecords,1);
}

function export12(){
	var pro_id = null;
	if($('#project').val() != '') {
		pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
	}
	window.open('export_project_report.php?q='+$('#project').val()+'&pro_id='+pro_id);
	
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

<body>

<form name="tstest" id="tstest" method="post" action="" onsubmit="return test()" enctype="multipart/form-data">
<TABLE cellpading="0" cellspacing="0" class="table_text">
<TR>
  <TD align="left"><font color='red'>* <b>Mandatory Fields</b></font></TD>
  <TD><br /><br /></TD>
</TR>

<TR>
	<TD>Project Name <font color='red'>*</font></TD>
	<td>
    <select name="project" id="project"> 
      <option size="30" selected>Select</option>  
<?php
  $selectProject = "select DISTINCT projectname, pindatabaseid from projectmaster where projectmanager='$username' or accountmanager='$username' or buhead='$username' or practicehead='$username' or sepghead='$username' or sepglead='$username' or md='$username' or ceo='$username' or fmfour='$username' or fmthree='$username' or fmtwo='$username' or fmone='$username' or lead='$username' or tester1='$username' or tester2='$username' or tester3='$username' or tester4='$username' or tester5='$username' or tester6='$username' or tester7='$username' or tester8='$username'or dev1='$username' or dev2='$username' or dev3='$username' or dev4='$username' or dev5='$username' or dev6='$username' or dev7='$username' or dev8='$username' or dev9='$username' or dev10='$username' or dev11='$username' or dev12='$username' order by projectname ASC";
    
  $queryProject   = mysql_query($selectProject);
  $numrowsProject = mysql_num_rows($queryProject);

if(!empty($numrowsProject)){ 
  while($fetchProject = mysql_fetch_array($queryProject)){
    if(strlen($fetchProject['projectname'])<>0){
?>
    <option value="<?php echo urlencode($fetchProject['projectname']); ?>" <?php if($project==$fetchProject['projectname'])echo "selected"; ?> ref="<?php echo $fetchProject['pindatabaseid']; ?>"><?php echo $fetchProject['projectname']; ?></option> 
<?php 
    }
  } 
}else{
  echo "<option>No names present</option>";  
} 
?>
    </select>
  </td>
</TR>
<TR><td align="center">OR</td></TR>
<TR>
<TD>From Date <font color='red'>*</font></TD>
<TD><input type="text" name="FDate" id="FDate" value="" maxlength="20" size="19" readonly="readonly">
  <a href="javascript:NewCal('FDate','ddmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a> 
</TD>
</TR>
</TABLE>
<br>
<input type="button" class="button" value="Log Out" onclick="location.href='logout.php';">
<input type="button" class="button" value="Show All Fileinfo" onClick="showAll()">
<br>
<br>
<div id="ResHint"></div>
<div id="txtHint"></div>
</form>
</body>
</html> 
