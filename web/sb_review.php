<html>
<head>
<title>SB Review</title>
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

if( isset($_POST['addInfo']) && ($_POST['addInfo'] == 'Add')){
  //echo '<pre>'; print_r($_POST); die;
  $project        = urldecode($_POST["project"]);
  $project_id     = $_POST["pro_id"];
  $RDate          = $_POST["RDate"];
  $courseName     = mysql_real_escape_string($_POST["courseName"]);
  $iterationRound = $_POST["iterationRound"];
  $learningHours  = $_POST["learningHours"];
  $author         = mysql_real_escape_string($_POST["author"]);
  $reviewer       = mysql_real_escape_string($_POST["reviewer"]);
  $l1_issues      = $_POST["l1_issues"];
  $l2_issues      = $_POST["l2_issues"];
  $l3_issues      = $_POST["l3_issues"];
  $comment        = mysql_real_escape_string($_POST["comment"]);
  $sbpath         = mysql_real_escape_string($_POST["sbpath"]);
  $sb_review_submit_date = date('d-m-Y H:i:s'); 
  $max_filesize = 1048576; //Maximum filesize in BYTES (currently 1MB).
  $upload_path = './support/';
  $filename = $_FILES['attachment']['name'];
///////////////////////////////////////////////////////////////////////////////////
  $errorMessage   = "";    
  $successMessage = ""; 
  if(filesize($_FILES["attachment"]['tmp_name']) > $max_filesize)
      $errorMessage .= "The file '${filename.$x}' you attempted to upload is too large.<br>";
  if(!is_writable($upload_path))
      $errorMessage .= "You cannot upload to the specified directory. Please CHMOD it to 777.";
       
  $fstr = time()."_".$filename;

  

///////////////////////////////////////////////////////////////////////////////////
	if( empty($errorMessage) ){
		move_uploaded_file($_FILES["attachment"]['tmp_name'], $upload_path . $fstr);
		$insertFunctionalReview = "INSERT INTO tbl_sbreview(project_id, project_name, review_date, course_name, learning_hours, author, reviewer, sb_review_round, l1_issues, l2_issues, l3_issues, comment, svn_path_reviewe, attachment, review_submit_date) values('".$project_id."', '".$project."', '".$RDate."', '".$courseName."', '".$learningHours."', '".$author."', '".$reviewer."', '".$iterationRound."', '".$l1_issues."', '".$l2_issues."', '".$l3_issues."', '".$comment."', '".$sbpath."', '".$fstr."', '".$sb_review_submit_date."')";
		try {
		   $insert_id = mysql_query($insertFunctionalReview);
		} catch(Exception $e){
		   echo $e->getMessage(); die;
		}
		   
		if($insert_id){
			$successMessage = "Record has been created for project '".$project."'. Please click on the 'Show All Fileinfo' button to read the entries.";    
			header("Location: sb_review.php?project=".urlencode($project)."&successMessage=".urlencode($successMessage));
		}else{
			$errorMessage = "Record has not been created for project '".$project . "'";
			header("Location: sb_review.php?project=".urlencode($project)."&errorMessage=".urlencode($errorMessage));	
		} 
	} else{
			header("Location: sb_review.php?errorMessage=".urlencode($errorMessage));
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
<script>
function test(){
  var RDate = trim(document.getElementById('RDate').value);
  if(RDate==""){alert("Please enter start date!"); return false;};
  var project = trim(document.getElementById('project').value);
  if(project=="Select"){alert("Please select project name!"); return false;};
  var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
  $("#pro_id_hidden").val(pro_id);
  var courseName = trim(document.getElementById('courseName').value);
  if(courseName==""){alert("Please enter course name!"); return false;}; 
  var learningHours = trim(document.getElementById('learningHours').value);
  if(learningHours==""){alert("Please enter the learning hours!"); return false;}
  else if(isNaN(learningHours)){alert("Please enter the number of learning hours!"); return false;};
  var iterationRound = trim(document.getElementById('iterationRound').value);
  if(iterationRound==""){alert("Please select the Iteration Round #!"); return false;};

  var l1_issues = trim(document.getElementById('l1_issues').value);
  if(l1_issues == ""){alert("Please enter the l1 issues number!"); return false;}
  else if(isNaN(l1_issues)){alert("Please enter the number of l1 issues!"); return false;};
  
  var l2_issues = trim(document.getElementById('l2_issues').value);
  if(l2_issues ==""){alert("Please enter the l2 issues number!"); return false;}
  else if(isNaN(l2_issues)){alert("Please enter the number of l2 issues!"); return false;};
  
  
  var l3_issues = trim(document.getElementById('l3_issues').value);
  if(l3_issues == ''){alert("Please enter the l3 issues number!"); return false;}
  else if(isNaN(l3_issues)){alert("Please enter the number of l3 issues!"); return false;};
  
  var sbpath = trim(document.getElementById('sbpath').value);
  if(sbpath==""){alert("Please enter the SB path!"); return false;};
  
  var comments = trim(document.getElementById('comment').value);
  if(comments==""){alert("Please enter the SB path!"); return false;};
  

}


function displayRecords(numRecords = 10, pageNum = 1){
	var project = trim(document.getElementById('project').value);
	var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
	if(project=="Select"){
		$.ajax({
			type: "POST",
			url: "sb_review_feed.php",
			data: "show="+ numRecords +"&pagenum=" +pageNum,
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
		$.ajax({
			type: "POST",
			url: "sb_review_feed.php",
			data: "show="+ numRecords +"&pagenum=" +pageNum+"&id="+pro_id,
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
	}
}
function showAll(){
 var project = trim(document.getElementById('project').value);
  if(project!="Select"){
	displayRecords(10,1);
  } else {
	alert('Please Select Project');
	$("#txtHint").html('');
  }
}
function showAllProject(){
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
	window.open('export_sb_review.php?q='+$('#project').val()+'&pro_id='+pro_id);
	
}



function submitresponse(str)
{
re = /^[A-Za-z ]+$/;
//alert (str);
comm='txt'+str;
//alert(comm);

var ptr = document.getElementById(str).value;
//alert (ptr);

var ctr = trim(document.getElementById(comm).value);
//alert(ctr);

if (ptr=="select")
{
 alert ("The status must be selected");
 //document.getElementById(str).focus();
 return false;
}

if (ctr=="")
{
 alert ("Reason must be specified");
 //document.getElementById(str).focus();
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

</script>
<script language="JavaScript" src="datetimepicker.js"></script>
</head>

<body>

<?php 
$message = "";  
$color   = "";

if( isset($_REQUEST["successMessage"]) && !empty($_REQUEST["successMessage"]) ){
  $message = $_REQUEST["successMessage"];  
  $color   = "green";    
}elseif( isset($_REQUEST["errorMessage"]) && !empty($_REQUEST["errorMessage"]) ){
  $message = $_REQUEST["errorMessage"];  
  $color   = "red";  
}

if( !empty($message) ){
?> 
<table cellpading="0" cellspacing="0" class="table_text">
  <tr>
    <td valign="top">
      <font color="<?php echo $color; ?>"><?php echo $message; ?></font>
      <br />
      <br />
    </td>
  </tr>  
</table>
<?php
}
?>

<form name="tstest" id="tstest" method="post" action="" onsubmit="return test()" enctype="multipart/form-data">
<TABLE cellpading="0" cellspacing="0" class="table_text">
<TR>
  <TD align="left"><font color='red'>* <b>Mandatory Fields</b></font></TD>
  <TD><br /><br /></TD>
</TR>
<TR>
<TD>Review Date <font color='red'>*</font></TD>
<TD><input type="text" name="RDate" id="RDate" value="<?php echo $RDate; ?>" maxlength="20" size="19" readonly="readonly">
  <a href="javascript:NewCal('RDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD> 
</TD>
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
	<input type="hidden" name="pro_id" id="pro_id_hidden" value="<?php echo $pro_id; ?>" />
  </td>
</TR>




<TR>
  <TD>Course Name <font color='red'>*</font></TD>
  <TD><input type="text" name="courseName" id="courseName" maxlength="100" size="45" value="<?php echo $courseName; ?>"></TD>
</TR>

<TR>
  <TD><label for="type">Learning Hours</label> <font color='red'>*</font></TD>
  <TD><input type="text" name="learningHours" id="learningHours" maxlength="5" size="5" value="<?php echo $learningHours; ?>"></TD>
</TR>

<TR>
    <TD>Author <font color='red'>*</font></TD>
    <TD><select name="author" id="author"> 
	<?php $query  = "select username from login where username <> '' order by username"; 
		$retval = mysql_query($query, $con);
		$count  = mysql_num_rows($retval);
		$tmp = array(); 
		while($row = mysql_fetch_assoc($retval)){ 
		  $tmp[] = $row;
		  echo "<option value='".$row['username']."'>".$row['username']."</option>";   
		} 	
			
	?> 
	</select></TD>
</TR>
<TR>
    <TD>Reviewer <font color='red'>*</font></TD>
    <TD><select name="reviewer" id="reviewer">
	<?php
		foreach($tmp as $val) {
			echo "<option value='".$val['username']."'>".$val['username']."</option>";   
		} 	
			
	?> 
	</select></TD>
</TR>


<TR>
  <TD>SB Review round # <font color='red'>*</font></TD>
  <TD>
	<select name="iterationRound" id="iterationRound">
		<option value="">Select</option>
		<option value="R1">R1</option>
		<option value="R2">R2</option>
		<option value="R3">R3</option>
		<option value="R4">R4</option>
		<option value="R5">R5</option>
		<option value="R6">R6</option>
		<option value="R7">R7</option>
	</select>
  </TD>
</TR>


<TR>
  <TD><label for="type">No. of L1 Issues</label> <font color='red'>*</font></TD>
  <TD><input type="text" name="l1_issues" id="l1_issues" maxlength="5" size="5" ></TD>
</TR>
<TR>
  <TD><label for="type">No. of L2 Issues</label> <font color='red'>*</font></TD>
  <TD><input type="text" name="l2_issues" id="l2_issues" maxlength="5" size="5" ></TD>
</TR>
<TR>
  <TD><label for="type">No. of L3 Issues</label> <font color='red'>*</font></TD>
  <TD><input type="text" name="l3_issues" id="l3_issues" maxlength="5" size="5" ></TD>
</TR>
<TR>
  <TD>Comments <font color='red'>*</font></TD>
  <TD><textarea name="comment" id="comment" rows="4" cols="75"></textarea></TD>
</TR>

<TR>
  <TD>SVN path of the  reviewed SB <font color='red'>*</font></TD>
  <TD><textarea name="sbpath" id="sbpath" rows="4" cols="75"></textarea></TD>
</TR>
<TR>
  <TD>Attachment</TD>
  <TD><input type="file" name="attachment" id="attachment" size="35" /></TD>
</TR>
</TABLE>
<br>
<input type="submit" name="addInfo" class="button" value="Add">
<input type="button" class="button" value="Log Out" onclick="location.href='logout.php';">
<input type="button" class="button" value="Show All Fileinfo" onClick="showAll()">
<input type="button" class="button" value="Show All Projects Info" onClick="showAllProject()">
<br>
<br>
<div id="ResHint"></div>
<div id="txtHint"></div>
</form>
</body>
</html> 
