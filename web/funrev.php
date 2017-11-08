<html>
<head>
<link href="css/ajaxloader.css" rel="stylesheet" type="text/css" media="screen" />
<?php	
error_reporting(0);
session_start();
	
if(!(isset($_SESSION['login']) && $_SESSION['login'] != '')){
  header ("Location:index.php");
}
$user=$_SESSION['login'];    
  
include("config.php");  

$query  = "select username from login where uniqueid='$user'";
$retval = mysql_query( $query, $con );
$count  = mysql_num_rows($retval);
	
if($count==0){
  die('Data Not Found Please contact SEPG');
}

while($row = mysql_fetch_assoc($retval)){ 
  echo "<br>";
  echo "<br>"; 
  echo "<h4>"."Hi ".$row['username']." ! Welcome to Functional Review Interface"."</h4>";
  $username=$row['username'];
}

$id = !empty($_GET['id']) ? $_GET['id'] : '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $reviewer = mysql_real_escape_string($_POST["reviewer"]);
  $project  = mysql_real_escape_string($_POST["project"]);
  $project_id = $_POST["pro_id"];
  $phase    = mysql_real_escape_string($_POST["phase"]);
  $module = mysql_real_escape_string($_POST['module']);
  $screen = mysql_real_escape_string($_POST['screen']);
  $reviewee = mysql_real_escape_string($_POST["reviewee"]);
  $bcat     = mysql_real_escape_string($_POST["bcat"]);
  $severity = mysql_real_escape_string($_POST["severity"]);
  $subcat   = $_POST["subcat"];
  $a        = mysql_real_escape_string($_POST["bdr"]);
  $b        = mysql_real_escape_string($_POST["container"]);
  $cdate    = time();
  $fr_id = isset($_POST['id']) ? $_POST['id'] : '';
  if($fr_id) {
		$query = "UPDATE blobt set reviewer='".$reviewer."', project_id='".$project_id."', project='".$project."', phase='".$phase."', cat='".$bcat."', subcat='".$subcat."', desc1='".$a."', grab='".$b."', severity='".$severity."', module='".$module."', screen='".$screen."' where id='".$fr_id."'";
  } else {
		$query = "INSERT INTO blobt(reviewer, project_id, project, phase, reviewee, cat, subcat, desc1, grab, creationDate, comment, severity, module, screen) values('".$reviewer."', '".$project_id."', '".$project."', '".$phase."', '".$reviewee."', '".$bcat."', '".$subcat."', '".$a."', '".$b."', '".$cdate."','', '".$severity."', '".$module."', '".$screen."')";
  }
  if(mysql_query($query)){
		if($fr_id) {
			$message="Record has been edited for project ".$project." and "."issue : ".$a.", please click on the Show All Fileinfo to read the entry.";
		} else {
			$message="Record has been created for project ".$project." and "."issue : ".$a.", please click on the Show All Fileinfo to read the entry.";
		}
		header ("Location: funrev.php?proj=".urlencode($project)."&phase=".urlencode($phase)."&reviewee=".urlencode($reviewee)."&msg=".urlencode($message));
  } else {
		die(mysql_error());
  }	
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
  border-left: #F7941C;
  border-right:#F7941C;
  border-top: #F7941C;
  color: black;
  font-family: Tahoma
  box-shadow:2px 2px 0 0 #014D06,;
  border-radius: 10px;
  border: 1px outset #b37d00 ;
}

.table_text{
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
<script src="js/jquery.js"></script>
<script>
$(document).ready(function(){
	$('.loaderParent').hide();
	$('.loader').hide();
});
</script>

</head>

<body>
<?php 
	if($id) {
		$query = "select * from blobt where id = ".$id;
		$retval = mysql_query($query, $con);
		$row = mysql_fetch_assoc($retval); 
	}
?>
<form name="tstest" action="./funrev.php" method="post" enctype="multipart/form-data">
<table>

<tr>
	<td>Project Name</td>
	<td>
    <?php
    $proj = $row['project'] ? $row['project'] : $_REQUEST["proj"];
	$phase = $row['phase'] ? $row['phase'] : $_REQUEST["phase"];
	$reviewee = $row['reviewee'] ? $row['reviewee'] : $_REQUEST["reviewee"];
	$description = $row['desc1'] ? $row['desc1'] : $_REQUEST["bdr"];
    $module = $row['module'] ? $row['module'] : $_REQUEST["module"];
	$screen = $row['screen'] ? $row['screen'] : $_REQUEST["screen"];
	$cat = $row['cat'] ? $row['cat'] : $_REQUEST["bcat"];
	$subcat = $row['subcat'] ? $row['subcat'] : $_REQUEST["subcat"];
	$severity = $row['severity'] ? $row['severity'] : $_REQUEST["severity"];
	$grab = $row['grab'] ? $row['grab'] : $_REQUEST['container'];
	$message = $_REQUEST['msg'];
	$query = "select DISTINCT projectname, pindatabaseid from projectmaster where projectmanager= '$username' or accountmanager= '$username' or buhead='$username' or practicehead='$username' or sepghead='$username' or sepglead='$username' or md='$username' or ceo = '$username' or fmfour='$username' or fmthree='$username' or fmtwo='$username' or fmone='$username' or lead='$username' or tester1='$username' or tester2='$username' or tester3='$username' or tester4='$username' or tester5='$username' or tester6='$username' or tester7='$username' or tester8='$username'or dev1='$username' or dev2='$username' or dev3='$username' or dev4='$username' or dev5='$username' or dev6='$username' or dev7='$username' or dev8='$username' or dev9='$username' or dev10='$username' or dev11='$username' or dev12='$username' order by projectname ASC";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	//$m=$_REQUEST["project"];
	
	if($count==0)
		{
			die('Data Not Found');
		}

    echo "<select name=\"project\" id=\"project\" onchange=\"getinfo();\">"; 
    echo "<option size =30 selected>Select</option>";
    if(mysql_num_rows($retval)) 
    { 
		while($row = mysql_fetch_assoc($retval)) 
		{
		 if(strlen($row['projectname'])<>0)
			{
			 ?>
			 <option <?php if($proj==$row['projectname'])echo " selected";?> ref="<?php echo $row['pindatabaseid'] ?>" ><?php echo $row['projectname'];?></option> 
			 <?php 
			}
		} 
 
    } 
    else {
		echo "<option>No Names Present</option>";  
    } 
    ?>
    </td>
	<input type="hidden" name="pro_id" id="pro_id_hidden" value="" />
	<input type="hidden" name="id" value="<?php echo $id?>" />
	
</tr>

<tr>
  <td>Phase</td>
  <td>
    <select name="phase" size="1" id="phase">
      <option value="Select" selected>Select</option>
      <option value="alpha" <?php if($phase=="alpha")echo " selected";?>>Alpha</option>
      <option value="beta" <?php if($phase=="beta")echo " selected";?>>Beta</option>
      <option value="gold" <?php if($phase=="gold")echo " selected";?>>Gold</option>
      <option value="POC" <?php if($phase=="POC")echo " selected";?>>POC</option>
    </select> &nbsp; &nbsp;
	<span id="phase_hint"></span>
  </td>
</tr>
<tr>
<td>Module Name</td>
<td><input type=text size=42 name="module" id="module" value="<?php echo $module;?>"></td>
</tr>
<tr>
<td>Screen Details</td>
<td><input type=text size=42 name="screen" id="screen" value="<?php echo $screen;?>"></td>
</tr>
<tr>
<td>Reviewee</td>
<td>
    <?php
	$query = "select DISTINCT username from login where role REGEXP 'ID|Media|Tech' AND dept='Content' order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}

    echo "<select name=\"reviewee\" id=\"reviewee\">"; 
    echo "<option size =30 selected value=\"Select\">Select</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
     
	 if(strlen($row[username])<>0)
		{
		 ?>
         <option<?php if($reviewee==$row[username])echo " selected";?>><?php echo $row[username];?></option> 
         <?php 
		}
    } 
    } 
    else 
	{
     echo "<option>No Names Present</option>";  
    } 
    ?>
    </td>
</tr>

<tr>
<td>Bug Category</td>
<td>
  <select name="bcat" size="1" id="bcat" onchange="filloption(this.value)">
    <option value="Select" selected>Select</option>
    <option value="Instructional Design" <?php echo $cat == "Instructional Design" ? "selected": "" ?>>Instructional Design</option>
    <option value="Media" <?php echo $cat == "Media" ? "selected": "" ?>>Media</option>
    <option value="Functionality" <?php echo $cat == "Functionality" ? "selected": "" ?>>Functionality</option>
  </select>
</td>
</tr>

<tr>
  <td>Bug Subcategory</td>
  <td><div name="OpHint" id="OpHint"></div></td>
</tr>

<tr>
<td>Severity</td>
<td>
	<select name="severity" size="1" id="severity">
		<option value="select">Select</option>
		<option value="High" <?php echo $severity == "High" ? "selected": "" ?>>High</option>
		<option value="Medium" <?php echo $severity == "Medium" ? "selected": "" ?>>Medium</option>
		<option value="Low" <?php echo $severity == "Low" ? "selected": "" ?>>Low</option>
	</select>
</td>
</tr>

<tr>
  <td>Bug Description</td>
  <td><textarea name="bdr" rows="4" cols="30" id="bdr"><?php echo $description ? stripslashes($description) : '';?></textarea></td>
</tr>

<textarea class="hide" name="container" rows="2" cols="20"></textarea>

<tr>
  <td>Screen Grab</td>
  <td><div class="ex" contenteditable="true" id="grab" name="grab"><?php echo $grab ? $grab : "Paste Image Here if any.Clean All These Text if pasting image..." ?></p></td>
</tr>

</table>
<br />
<input type="button" class="button" value="Submit" onclick="test();">
<input type="button" class="button" value="Log Out" onclick="location.href='logout.php';">
<input type="button" name="showreport" class="button" value="Show All Functional Review Data" onclick="redirect();">
<input type="button" class="button" value="QC Review" onclick="qcreviewemail()">
<input type="button" class="button" value="Developer Review" onclick="developerreviewemail()">
<input type="hidden" id="luser" name="reviewer" value="<?php echo $username; ?>">
<br>
<br>
<table width="50%" cellspacing="0" cellpadding="0" border="0" class="table_text">
  <tr>
    <td>Bug Category</td>
    <td>
      <select name="searchBC" id="searchBC" size="1">
        <option value="select" selected>Select bug category</option>
        <option value="Instructional Design">Instructional Design</option>
        <option value="Media">Media</option>
        <option value="Functionality">Functionality</option>
		<option value="all">All</option>
      </select>
    </td>
    <td>Bug Status</td>
    <td>
      <select name="searchBS" id="searchBS" size="1">
        <option value="select" selected>Select bug status</option>
		<option value="fixed">Fixed</option>
        <option value="ok as is">Ok As IS</option>
        <option value="hold">Hold</option>
        <option value="reopened">Reopen</option>
        <option value="closed">Close</option>
        <option value="open">Open</option>
		<option value="all">All</option>
      </select>
    </td>
    <td>&nbsp;</td>
    <td><input type="button" class="button" value="Show All Fileinfo" onclick="showAll()"></td>        
  </tr>  
</table>
</form>
<div id="ResHint"></div>
<div id="txtHint"><?php if($message<>""){echo $message;}?></div>
	<div class="loaderParent">
	</div>
		<div class="loader">
		    <span></span>
		    <span></span>
		    <span></span>
		</div>
</body>
<script>
function test(){
  var project = trim(document.getElementById('project').value);
  if(project=="Select"){alert("Please select project"); return false;};
  var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
  $("#pro_id_hidden").val(pro_id);
  var phase = trim(document.getElementById('phase').value);
  if(phase=="Select"){alert("Please select phase"); return false;};
  
  var module = trim(document.getElementById('module').value);
  if(module==""){ alert("Module Name should be identified"); return false;}
  var screen = trim(document.getElementById('screen').value);
  if(screen==""){ alert("Screen Name should be identified"); return false;}
  
  var reviewee = trim(document.getElementById('reviewee').value);
  if(reviewee=="Select"){alert("Please select reviewee"); return false;}; 
  
  var bcat = trim(document.getElementById('bcat').value);
  if(bcat=="Select"){alert("Please select category"); return false;};

  var severity = trim(document.getElementById('severity').value);
  if(severity=="Select"){alert("Please select Severity"); return false;};
  
  var subcat = trim(document.getElementById('subcat').value);
  if(subcat=="Select"){alert("Please select sub-category"); return false;};
  
  var bdr = trim(document.getElementById('bdr').value);
  if(bdr==""){alert("Please enetr the bug description"); return false;};
 
  var nt = document.getElementById('grab').innerHTML;
  document.forms["tstest"].container.value += nt;
  document.forms["tstest"].submit();
}

function qcreviewemail() {
 var project = trim(document.getElementById('project').value);
 var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
 var phase = trim(document.getElementById('phase').value);
 //var course = trim(document.getElementById('chd').value);
 if(project=="Select") {alert("Please select the project"); return false;}
 if(phase=="select") {alert("Please select the phase"); return false;}
 //if(course=="") {alert("Course Required"); return false;}
 project=encodeURIComponent(project);
 phase=encodeURIComponent(phase);
 mywindow=window.open ("getreviewemail.php?pro="+project+"&pro_id="+pro_id+"&phs="+phase,"Ratting","scrollbars=1,width=600,height=600,0,status=0,");
 if (window.focus) {mywindow.focus()}
}

function developerreviewemail() {
 var project = trim(document.getElementById('project').value);
 var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
 var phase = trim(document.getElementById('phase').value);
 //var course = trim(document.getElementById('chd').value);
 if(project=="Select") {alert("Please select the project"); return false;}
 if(phase=="select") {alert("Please select the phase"); return false;}
 //if(course=="") {alert("Course Required"); return false;}
 project=encodeURIComponent(project);
 phase=encodeURIComponent(phase);
 mywindow=window.open ("getreviewemail.php?pro="+project+"&pro_id="+pro_id+"&phs="+phase,"Ratting","scrollbars=1,width=600,height=600,0,status=0,");
 if (window.focus) {mywindow.focus()}
}


/*function showAll(){
  var project = trim(document.getElementById('project').value);
  var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
  if(project=="Select"){
    alert("Project must be selected");
    return false;
  }
  
  var searchBC  = trim(document.getElementById('searchBC').value);
  if(searchBC=="select"){
    alert("Category must be selected");
    return false;
  }
  
  var searchBS  = trim(document.getElementById('searchBS').value);
  if(searchBS=="select"){
    alert("Status must be selected");
    return false;
  }
  
  if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  }else{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  
  xmlhttp.onreadystatechange=function(){
    if(xmlhttp.readyState==4 && xmlhttp.status==200){
      document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
		$('.loader').hide();
		$('.loaderParent').hide();
    }
  }
  
  project=encodeURIComponent(project);
  //console.log("getrevinfo.php?q="+project+"&bugCat="+searchBC+"&bugStatus="+searchBS);
  $('.loader').show();
  $('.loaderParent').show();
  xmlhttp.open("GET", "getrevinfo.php?q="+project+"&pro_id="+pro_id+"&bugCat="+searchBC+"&bugStatus="+searchBS, true);
  xmlhttp.send();
}*/

function showAll(){
  displayRecords(10,1);
}

function displayRecords(numRecords, pageNum) {
	  var project = trim(document.getElementById('project').value);
	  var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
	  if(project=="Select"){
		alert("Project must be selected");
		return false;
	  }
	  
	  var searchBC  = trim(document.getElementById('searchBC').value);
	  if(searchBC=="select"){
		alert("Category must be selected");
		return false;
	  }
	  
	  var searchBS  = trim(document.getElementById('searchBS').value);
	  if(searchBS=="select"){
		alert("Status must be selected");
		return false;
	  }
	
	$.ajax({
		type: "GET",
		url: "getrevinfo.php",
		data: "show=" + numRecords + "&pagenum="+pageNum+"&q="+project+"&pro_id="+pro_id+"&bugCat="+searchBC+"&bugStatus="+searchBS,
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
	var project = trim(document.getElementById('project').value);
	var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
	if(project=="Select"){
		alert("Project must be selected");
		return false;
	}
  
	var searchBC  = trim(document.getElementById('searchBC').value);
	if(searchBC=="select"){
		alert("Category must be selected");
		return false;
	}
  
	var searchBS  = trim(document.getElementById('searchBS').value);
	if(searchBS=="select"){
		alert("Status must be selected");
		return false;
	}
	window.open('exportfunrev.php?q='+project+'&pro_id='+pro_id+'&searchBC='+searchBC+'&searchBS='+searchBS);
	
}

function filloption(str, subcat=''){
  var cat=str;
  
  if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  }else{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  
  xmlhttp.onreadystatechange=function(){
    if(xmlhttp.readyState==4 && xmlhttp.status==200){
      document.getElementById("OpHint").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET", "catdump.php?q="+cat+"&subcat="+subcat, true);
  xmlhttp.send();
}

function fillSubCat(str){
  var cat=str;
  
  if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  }else{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  
  xmlhttp.onreadystatechange=function(){
    if(xmlhttp.readyState==4 && xmlhttp.status==200){
      document.getElementById("searchBSC").innerHTML=xmlhttp.responseText;
    }
  }
  
  xmlhttp.open("GET", "subcatbyajax.php?catName="+cat, true);
  xmlhttp.send();
}

function submitresponse(str){
re  = /^[A-Za-z ]+$/;
comm='txt'+str;

var ptr = document.getElementById(str).value;

var ctr = trim(document.getElementById(comm).value);


if (ptr=="select")
{
 alert ("The status must be selected");
 return false;
}

if (ctr=="")
{
 alert ("Reason must be specified");
 return false;
}

if(!ctr.match(re))
  {
  alert("Comment should be Alphabet Only");
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

ctr=encodeURIComponent(ctr);
xmlhttp.open("GET","updatefunstat.php?q="+str+ "&r=" + ptr+ "&s=" + ctr,true);
xmlhttp.send();

}


function submitrev(str)
{
//alert (str);
mywindow=window.open ("editreviewee.php?id="+str,"Ratting","scrollbars=1,width=550,height=180,0,status=0,");
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

function redirect(){
	if($('#project').val() != 'Select') {
		var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
		location.href='funrevreport.php?project='+$('#project').val()+"&pro_id="+pro_id;
		return true;
	} else {
		alert('Please select Project Name');
		return false;
	}
}
var phase = '';
function getinfo(){
	if($('#project').val() != 'Select') {
		var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
		$.get('getprojectdetail.php', {pro_id:pro_id}, function(data){
			var data1 = $.parseJSON(data);
			phase = data1.version;
			$("#phase").val(data1.version);
		});
	}
}
$(document).ready(function(){
	var cat = '<?php echo $cat ?>';
	var subcat = '<?php echo $subcat ?>';
	if(cat && subcat) {
		filloption(cat, subcat);
	}
});
function changeRev(id){
	window.open("submitreview.php?id="+id, "Rating", "width=500,height=500,0,status=0,");
}
</script>
</html> 