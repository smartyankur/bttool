<html>
<head>
<title>Add Course Handover Document</title>
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
  die('Data Not Found. Please contact SEPG.');
}

while($row = mysql_fetch_assoc($retval)){ 
  echo "<br>";
  echo "<br>";
  echo "<h4>"."Hi ".$row['username']." ! Welcome to Course Handover Document."."</h4>";
  $username = $row['username'];
  $email    = $row['email'];  
} ?>	
<input class="button" value="Show Twenty Recent CHDs" onclick="location.href='chdList.php';" type="button">&nbsp;&nbsp;
<input class="button" value="Show CHD Guidelines" onclick="location.href='CHD_Guidelines_and_Release_Notes.xlsx';" type="button">
<?php
$post_data = array();
if( isset($_POST['addInfo']) && ($_POST['addInfo'] == 'Add')){
  $project        = urldecode($_POST["project"]);
  $project_id     = $_POST["pro_id"];
  $pm             = $_POST["pm"];
  $courseTitle    = $_POST["courseTitle"];
  $SDate          = time(); //$_POST["SDate"];
  $courseLevel    = $_POST["courseLevel"];
  $fmid           = $_POST["fmid"];
  $fmmedia        = $_POST["fmmedia"];
  $fmtech         = $_POST["fmtech"];
  $devsid         = implode(",", $_POST["devsid"]);  
  $devsmed        = implode(",", $_POST["devsmed"]);  
  $devstech       = implode(",", $_POST["devstech"]);  
  $version        = $_POST["version"];
  $pagecount      = $_POST["pagecount"];
  $slidecount     = $_POST["slidecount"];
  //$iterationRound = $_POST["iterationRound"];
  $learningHours  = $_POST["learningHours"];
  $coursesize     = $_POST["coursesize"];
  $testingScope   = $_POST["testingScope"];
  $partialTesting = implode(",", $_POST["partialTesting"]);
  $confReviews    = implode(",", $_POST["confReviews"]);
  $path           = mysql_real_escape_string($_POST["path"]);
  $sbpath         = mysql_real_escape_string($_POST["sbpath"]);
  $editsheet      = mysql_real_escape_string($_POST["editsheet"]);
  $dtpath         = mysql_real_escape_string($_POST["dtpath"]);
  $tppath         = mysql_real_escape_string($_POST["tppath"]);
  $chk            = mysql_real_escape_string($_POST["chk"]);
  $reviewer       = mysql_real_escape_string($_POST["reviewer"]);
  $comments       = mysql_real_escape_string($_POST["comments"]);
  $testenvironment = implode(",", $_POST["testenvironment"]);
  $chd_submit_date = date('d-m-Y'); 
  
///////////////////////////////////////////////////////////////////////////////////


  $errorMessage   = "";    
  $successMessage = "";    
  $max_filesize = 1048576; //Maximum filesize in BYTES (currently 1MB).
  $upload_path = './support/'; //The place the files will be uploaded to (currently a 'files' directory).
  $filename1 = $_FILES['supportfile1']['name']; //Get the name of the file (including file extension).
  $filename2 = $_FILES['supportfile2']['name']; //Get the name of the file (including file extension).
  $filename3 = $_FILES['supportfile3']['name']; //Get the name of the file (including file extension).
  $filename4 = $_FILES['supportfile4']['name']; //Get the name of the file (including file extension).
  $ADate = date('Y-m-d H:i:s', time());

  if($filename1<>"" || $filename2<>"" || $filename3<>"" || $filename4<>""){
    for($x=1; $x<=4; $x++){
      if( empty(${filename.$x}) ){
        continue;
      }      
       
      //Now check the filesize, if it is too large then DIE and inform the user.
      if(filesize($_FILES["supportfile$x"]['tmp_name']) > $max_filesize)
      $errorMessage .= "The file '${filename.$x}' you attempted to upload is too large.<br>";
       
      //Check if we can upload to the specified path, if not DIE and inform the user
      if(!is_writable($upload_path))
      $errorMessage .= "You cannot upload to the specified directory. Please CHMOD it to 777.";
       
      ${fstr.$x} = time()."_".${filename.$x};
      
      if(empty($errorMessage)){
        if(move_uploaded_file($_FILES["supportfile$x"]['tmp_name'], $upload_path . ${fstr.$x})){
          $successMessage .= 'Your file '.$filename.' has been uploaded successfully. You can view the uploaded file <a href="' . $upload_path . $fstr . '" title="Your File">here</a>';
        }
      }else{
		$_POST['errorMessage'] = $errorMessage;
		//print_r($post_data); die;
        //header ("Location: chd.php?errorMessage=".urlencode($errorMessage));
        //exit;
      }
    }
  }	

///////////////////////////////////////////////////////////////////////////////////
  if( empty($errorMessage) ){
	$FReviewNo = "";
	if(empty($_POST['edit'])) {
		$insertFunctionalReview = "INSERT INTO tbl_functional_review(project_id,project_name,project_manager,course_title,start_date,course_level,functional_manager_id,functional_manager_media,functional_manager_tech,developers_id,developers_media,developers_tech,version,pagecount,slidecount,learning_hours,testing_scope,partial_testing,conf_reviews,course_path,sb_path,editsheet,dt_path,test_plan_path,test_checklists,reviewer,comments,support_file1,support_file2,support_file3,support_file4, testenvironment,coursesize,chdreleasedate) values('".$project_id."','".$project."','".$pm."','".$courseTitle."','".$SDate."','".$courseLevel."','".$fmid."','".$fmmedia."','".$fmtech."','".$devsid."','".$devsmed."','".$devstech."', '".$version."','".$pagecount."','".$slidecount."','".$learningHours."','".$testingScope."','".$partialTesting."','".$confReviews."','".$path."','".$sbpath."','".$editsheet."','".$dtpath."','".$tppath."','".$chk."','".$reviewer."','".$comments."','".$fstr1."','".$fstr2."','".$fstr3."','".$fstr4."', '".$testenvironment."','".$coursesize."','".$chd_submit_date."')";
		if(mysql_query($insertFunctionalReview)){
			$FReviewNo = mysql_insert_id();
			$successMessage = "Record has been created for project '".$project."'. Please click on the 'Show All Fileinfo' button to read the entries.";
		} else {
			$errorMessage = "Record has not been created for project '".$project . "'";
		}
	} else {
		$updateFunctionalReview = "UPDATE tbl_functional_review set project_id='".$project_id."',project_name='".$project."',project_manager='".$pm."',course_title='".$courseTitle."',start_date='".$SDate."',course_level='".$courseLevel."',functional_manager_id='".$fmid."',functional_manager_media='".$fmmedia."',functional_manager_tech='".$fmtech."',developers_id='".$devsid."',developers_media='".$devsmed."',developers_tech='".$devstech."',version='".$version."',pagecount='".$pagecount."',slidecount='".$slidecount."',learning_hours='".$learningHours."',testing_scope='".$testingScope."',partial_testing='".$partialTesting."',conf_reviews='".$confReviews."',course_path='".$path."',sb_path='".$sbpath."',editsheet='".$editsheet."',dt_path='".$dtpath."',test_plan_path='".$tppath."',test_checklists='".$chk."',reviewer='".$reviewer."',comments='".$comments."',support_file1='".$fstr1."',support_file2='".$fstr2."',support_file3='".$fstr3."',support_file4='".$fstr4."', testenvironment='".$testenvironment."',coursesize='".$coursesize."',chdreleasedate='".$chd_submit_date."', status='' where id =".$_POST['edit'];
		if(mysql_query($updateFunctionalReview)){
			$FReviewNo = $_POST['edit'];
			$successMessage = "Record has been updated for project '".$project."'. Please click on the 'Show All Fileinfo' button to read the entries.";
		} else {
			$errorMessage = "Record has not been updated for project '".$project . "'";
		}
		//echo '<pre>'; print_r($_POST); die;
	}
    if($FReviewNo) { 		
		$str  = '<html><head><style type="text/css">body{background:url(\'qcr.jpg\') no-repeat;} .table_text{font-family:Calibri; font-size:12px; font-style:normal; line-height:normal; font-weight:normal; font-variant:normal; color:#000000; text-indent:10px; vertical-align:middle;}  
</style></head>';
  	$str .= '<body>';    
  	$str .= '<h4>Dear QA Team,</h4>';
  	$str .= '<h5>Please find below the CHD details :-</h5>';
  	$str .= '<table border=1 class="table_text">';
  	$str .= '<tr><th>S. No.</th><th>Project Name</th><th>Project Manager</th><th>Course Title</th><th>CHD Submission Date</th><th>Course Level</th><th>Functional Manager[ID]</th><th>Developers[ID]</th><th>Functional Manager[Med]</th><th>Developers[Med]</th><th>Functional Manager[Tech]</th><th>Developers[Tech]</th><th>Version</th><th>No of HTML/Flash Pages</th><th>No. of slides in PPT</th><th>Learning Hours</th><th>Course Memory Size in MB</th><th>Scope for testing</th><th>Partial Testing</th><th>Confirmation On Reviews</th><th>Course Path [SVN]</th><th>SB Path [SVN]</th><th>Edit Sheet</th><th>Development Tracker Path [SVN]</th><th>Test Plan Path [SVN]</th><th>Test Case/Checklists [SVN]</th><th>Reviewer</th><th>Comments</th><th>Test Environment</th><th>Attach supporting documents</th></tr>';
  	$str .= '<tr>';
  	$str .= "<td>".$FReviewNo."</td>";
    $str .= "<td>".$project."</td>";
    $str .= "<td>".$pm."</td>";  
    $str .= "<td>".$courseTitle."</td>";
    $str .= "<td>".date("d-m-Y", $SDate)."</td>";
    $str .= "<td>".$courseLevel."</td>";
    $str .= "<td>".$fmid."</td>";
	$str .= "<td>".$devsid."</td>";
    $str .= "<td>".$fmmedia."</td>";
	$str .= "<td>".$devsmed."</td>";
    $str .= "<td>".$fmtech."</td>"; 
    $str .= "<td>".$devstech."</td>"; 
	$str .= "<td>".$version."</td>";
    $str .= "<td>".$pagecount."</td>";
    $str .= "<td>".$slidecount."</td>";
    $str .= "<td>".$learningHours."</td>";
    $str .= "<td>".$coursesize."</td>";
    $str .= "<td>".$testingScope."</td>";
    $str .= "<td>".$partialTesting."</td>";
    $str .= "<td>".$confReviews."</td>";
    $str .= "<td>".$path."</td>";
    $str .= "<td>".$sbpath."</td>";
    $str .= "<td>".$editsheet."</td>";
    $str .= "<td>".$dtpath."</td>";
    $str .= "<td>".$tppath."</td>";
    $str .= "<td>".$chk."</td>";
    $str .= "<td>".$reviewer."</td>";
    $str .= "<td>".$comments."</td>";
    $str .= "<td>".$testenvironment."</td>";
    $str .= "<td>".$fstr1 ."</td>";
  	$str .= '</tr>';
  	$str .= '</table>';
  	$str .= '<br /><br />Thanks and Regards';
	$str .= '<br /><br /> ';
	$str .= '</body></html>';
        
	$to_emails = array();
	$to_emails[] = "content_qc@gc-solutions.net"; 
	//$to_emails[] = "manojs@gc-solutions.net";
	//$to_emails[] = "kanchanr@gc-solutions.net";	
	$to_emails[] = getEmail($pm);
	$to_emails[] = getEmail($fmid);
	$to_emails[] = getEmail($fmmedia);
	$to_emails[] = getEmail($fmtech);
	if(isset($_POST["devsid"]) && is_array($_POST["devsid"]) && count($_POST["devsid"]) > 0){
		foreach($_POST["devsid"] as $dev)
		$to_emails[] = getEmail($dev);
	}
	if(isset($_POST["devsmed"]) && is_array($_POST["devsmed"]) && count($_POST["devsmed"]) > 0){
		foreach($_POST["devsmed"] as $dev)
		$to_emails[] = getEmail($dev);
	}
	if(isset($_POST["devstech"]) && is_array($_POST["devstech"]) && count($_POST["devstech"]) > 0){
		foreach($_POST["devstech"] as $dev)
		$to_emails[] = getEmail($dev);
	}

  	$mailer = new phpmailer();
  	$mailer->IsSMTP();
  	$mailer->IsHTML(true);
  
  	$mailer->Host     = "smtp.office365.com";//"98.129.185.2";
	$mailer->Port     = 587;
  	$mailer->Username = "radar@gc-solutions.net";
  	$mailer->Password = "Gcube#123";//pass#123";//"Gcube!123";
  
  	$mailer->SMTPAuth  = true;
	$mailer->SMTPSecure = "tls";
  	$mailer->SMTPDebug = false;
  
  	//$mailer->From     = $email;
  	//$mailer->FromName = $username;

  	$mailer->From     = "radar@gc-solutions.net";
  	$mailer->FromName = "RADAR";

	$mailer->AddCC($email,$username);

	$to_emails = array_unique($to_emails);
    
	foreach($to_emails as $email_id){
		if($email_id != null)
			$mailer->AddAddress($email_id);
	}
    
  	$mailer->Subject = "Course Handover Document - CHD No : " . $FReviewNo;
  	$mailer->Body    = $str."<br />".$username;
  
   	$mailer->Send();
  	echo $mailer->ErrorInfo."<br/>";  
	header("Location: chd.php?project=".urlencode($project)."&successMessage=".urlencode($successMessage));
  }else{
    
	$_POST['errorMessage'] = $errorMessage;
    //header("Location: chd.php?project=".urlencode($project)."&errorMessage=".urlencode($errorMessage));
  }	
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
  var project = trim(document.getElementById('project').value);
  if(project=="Select"){alert("Please select project name!"); return false;};
  var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
  $("#pro_id_hidden").val(pro_id);
  var pm = trim(document.getElementById('pm').value);
  if(pm=="Select"){alert("Please select project manager!"); return false;};
  
  var courseTitle = trim(document.getElementById('courseTitle').value);
  if(courseTitle==""){alert("Please enter course title!"); return false;}; 
  
  //var SDate = trim(document.getElementById('SDate').value);
  //if(SDate==""){alert("Please enter start date!"); return false;};
  
  
  var radios = document.getElementsByName("courseLevel");
  var formValid = false;
  var i = 0;
  while(!formValid && i < radios.length) {
    if (radios[i].checked) formValid = true;
    i++;        
  }
  if(!formValid){alert("Please check some option for course level!"); return false;};
  
  
  var fmid = trim(document.getElementById('fmid').value);
  if(fmid=="Select"){alert("Please select functional manager id!"); return false;};
  
  var fmmedia = trim(document.getElementById('fmmedia').value);
  if(fmmedia=="Select"){alert("Please select functional manager media!"); return false;};
  
  var fmtech = trim(document.getElementById('fmtech').value);
  if(fmtech=="Select"){alert("Please select functional manager tech!"); return false;};    
  
  //var devs = trim(document.getElementById('devs').value);
  //if(devs==""){alert("Please select the developers!"); return false;};


  var radios = document.getElementsByName("version");
  var formValid = false;
  var i = 0;
  while(!formValid && i < radios.length) {
    if (radios[i].checked) formValid = true;
    i++;        
  }
  if(!formValid){alert("Please check some option for version!"); return false;};
  
  
  var pagecount = trim(document.getElementById('pagecount').value);
  if(pagecount==""){alert("Please enter the number of HTML/flash pages!"); return false;}
  else if(isNaN(pagecount)){alert("Please enter the number of HTML/flash pages!"); return false;};
  
  var slidecount = trim(document.getElementById('slidecount').value);
  if(slidecount==""){alert("Please enter the number of slide in PPT"); return false;}
  else if(isNaN(slidecount)){alert("Please enter the number of slide in PPT!"); return false;};
  //var iterationRound = trim(document.getElementById('iterationRound').value);
  //if(iterationRound==""){alert("Please select the Iteration Round #!"); return false;};

  var learningHours = trim(document.getElementById('learningHours').value);
  if(learningHours==""){alert("Please enter the learning hours!"); return false;}
  else if(isNaN(learningHours)){alert("Please enter the number of learning hours!"); return false;};
  var coursesize = trim(document.getElementById('coursesize').value);
  if(coursesize==""){alert("Please enter the course size in MBs!"); return false;}
  if(coursesize=="0"){alert("Please enter the course size in MBs!"); return false;}
  if(isNaN(coursesize)){alert("Please enter the number for course size in MBs!"); return false;}
 // check for course size here

//   var radios = document.getElementsByName("learningHours");
//   var formValid = false;
//   var i = 0;
//   while(!formValid && i < radios.length) {
//     if (radios[i].checked) formValid = true;
//     i++;        
//   }
//   if(!formValid){alert("Please check some option for learning hours!"); return false;};  
  
    
  var testingScope = trim(document.getElementById('testingScope').value);
  if(testingScope=="Select"){alert("Please select scope of testing!"); return false;};
  
  
  var radios = document.getElementsByName("partialTesting[]");
  var formValid = false;
  var i = 0;
  while(!formValid && i < radios.length) {
    if (radios[i].checked) formValid = true;
    i++;        
  }
  if(!formValid){alert("Please check some option for partial testing!"); return false;};
  
  
  var radios = document.getElementsByName("confReviews[]");
  var formValid = false;
  var i = 0;
  while(!formValid && i < radios.length) {
    if (radios[i].checked) formValid = true;
    i++;        
  }
  if(!formValid){alert("Please check some option for confirmation On reviews!"); return false;};    
  
  
  var path = trim(document.getElementById('path').value);
  if(path==""){alert("Please enter the path!"); return false;};
  
  var sbpath = trim(document.getElementById('sbpath').value);
  if(sbpath==""){alert("Please enter the SB path!"); return false;};
  
  if(testingScope != 'regression'){
    var editsheet = trim(document.getElementById('editsheet').value);
    if(editsheet==""){alert("Please enter the edit sheet value!"); return false;};
  }  

  var dtpath = trim(document.getElementById('dtpath').value);
  if(dtpath==""){alert("Please enter the development tracker path!"); return false;};

  var tppath = trim(document.getElementById('tppath').value);
  if(tppath==""){alert("Please enter the test plan path!"); return false;};
  
  var chk = trim(document.getElementById('chk').value);
  if(chk==""){alert("Please enter the test case/checklists!"); return false;};
}

function showAll(){
  var project = trim(document.getElementById('project').value);
  var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
  if(project=="Select"){
    alert("Project name must be selected!");
    return false;
  }else{
    window.location.href="managefunctionalreview.php?project=" + project+"&pro_id="+pro_id;  
  }
}

function filloption(str)
{
var cat=str;
//alert(dept);

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
    document.getElementById("OpHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","catdump.php?q="+cat,true);
xmlhttp.send();
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
$(document).ready(function(){
	
});


</script>
</head>

<body>
<script language="JavaScript" src="datetimepicker.js"></script>
<?php 
$message = "";  
$color   = "";

if( isset($_REQUEST["successMessage"]) && !empty($_REQUEST["successMessage"]) ){
  $message = $_REQUEST["successMessage"];  
  $color   = "green";    
}elseif( isset($_POST["errorMessage"]) && !empty($_POST["errorMessage"]) ){
  $message = $_POST["errorMessage"];  
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
<?php
if(isset($_GET['chdid']) && !empty($_GET['chdid'])) {
	$query = "select * from tbl_functional_review where id = ".$_GET['chdid'];
	$retval = mysql_query($query, $con);
	$row = mysql_fetch_assoc($retval); 
	if($row['status'] != "rejected") {
		exit;
	}
	$_REQUEST['project'] = $row['project_name'];
	$_REQUEST['pm'] = $row['project_manager'];
	$_REQUEST['courseTitle'] = $row['course_title'];
	$_REQUEST['SDate'] = $row['start_date'];
	$_REQUEST['courseLevel'] = $row['course_level'];
	$_REQUEST['fmid'] = $row['functional_manager_id'];
	$_REQUEST['fmmedia'] = $row['functional_manager_media'];
	$_REQUEST['fmtech'] = $row['functional_manager_tech'];
	$_REQUEST['devsid'] = explode(",", $row['developers_id']);
	$_REQUEST['devstech'] = explode(",", $row['developers_tech']);
	$_REQUEST['devsmed'] = explode(",", $row['developers_media']);
	$_REQUEST["version"] = $row['version'];
	$_REQUEST["pagecount"] = $row['pagecount'];
	$_REQUEST["slidecount"] = $row['slidecount'];
	$_REQUEST["iterationRound"] = $row['iterationRound'];
	$_REQUEST["learningHours"] = $row['learning_hours'];
	$_REQUEST["coursesize"] = $row['coursesize'];
	$_REQUEST["testingScope"] = $row['testing_scope'];
	$_REQUEST["partialTesting"] = explode(",", $row['partial_testing']);
	$_REQUEST["confReviews"] = explode(",", $row['conf_reviews']);
	$_REQUEST["path"] = $row['course_path'];
	$_REQUEST["sbpath"] = $row['sb_path'];
	$_REQUEST["editsheet"] = $row['editsheet'];
	$_REQUEST["dtpath"] = $row['dt_path'];
	$_REQUEST["tppath"] = $row['test_plan_path'];
	$_REQUEST["chk"] = $row['test_checklists'];
	$_REQUEST["comments"] = $row['comments'];
	$_REQUEST["testenvironment"] = explode(",", $row['testenvironment']);
	$_REQUEST["function"] = $row['function'];
}
  $project        = $_REQUEST["project"];
  $pm             = $_REQUEST["pm"];
  $courseTitle    = $_REQUEST["courseTitle"];
  $SDate          = $_REQUEST["SDate"];
  $courseLevel    = $_REQUEST["courseLevel"];
  $fmid           = $_REQUEST["fmid"];
  $fmmedia        = $_REQUEST["fmmedia"];
  $fmtech         = $_REQUEST["fmtech"];
  $devsid         = $_REQUEST["devsid"];
  $devstech       = $_REQUEST["devstech"];
  $devsmed         = $_REQUEST["devsmed"];
  $version        = $_REQUEST["version"];
  $pagecount      = $_REQUEST["pagecount"];
  $slidecount     = $_REQUEST["slidecount"];
  $iterationRound = $_REQUEST["iterationRound"];
  $learningHours  = $_REQUEST["learningHours"];
  $coursesize     = $_REQUEST["coursesize"]; 
  $testingScope   = $_REQUEST["testingScope"];
  $partialTesting = $_REQUEST["partialTesting"];
  $confReviews    = $_REQUEST["confReviews"];
  $path           = $_REQUEST["path"];
  $sbpath         = $_REQUEST["sbpath"];
  $editsheet      = $_REQUEST["editsheet"];
  $dtpath         = $_REQUEST["dtpath"];
  $tppath         = $_REQUEST["tppath"];
  $chk            = $_REQUEST["chk"];
  $comments       = $_REQUEST["comments"];  
  $testenvironment = $_REQUEST["testenvironment"];  
  $function       = $_REQUEST["function"];  
?>  
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
    <option value="<?php echo urlencode($fetchProject['projectname']); ?>" <?php if(urldecode($project)==$fetchProject['projectname'])echo "selected"; ?> ref="<?php echo $fetchProject['pindatabaseid']; ?>"><?php echo $fetchProject['projectname']; ?></option> 
<?php 
    }
  } 
}else{
  echo "<option>No names present</option>";  
} 
?>
    </select>
	<input type="hidden" name="pro_id" id="pro_id_hidden" value="" />
  </td>
</TR>

<TR>
  <TD>Project Manager <font color='red'>*</font></TD>
  <TD>
    <select name="pm" id="pm"> 
      <option size="30" selected>Select</option>  
<?php
      $selectProjectManager  = "select DISTINCT username from login where role='PM' AND dept='Content' order by username ASC";
      $queryProjectManager   = mysql_query($selectProjectManager);
      $numrowsProjectManager = mysql_num_rows($queryProjectManager);
      if(!empty($numrowsProjectManager)){ 
        while($fetchProjectManager = mysql_fetch_array($queryProjectManager)){ 
          if(strlen($fetchProjectManager['username'])<>0){
?>
      <option <?php if($pm==$fetchProjectManager['username'])echo " selected"; ?>><?php echo $fetchProjectManager['username']; ?></option> 
<?php 
          }
        } 
      }else{
        echo "<option>No project manager</option>";  
      } 
?>
    </select>
  </TD>
</TR>


<TR>
  <TD>Course Title <font color='red'>*</font></TD>
  <TD><input type="text" name="courseTitle" id="courseTitle" maxlength="100" size="45" value="<?php echo $courseTitle; ?>"></TD>
</TR>

<!--<TR>
  <TD>CHD Submission Date <font color='red'>*</font></TD>
  <TD><input type="text" name="SDate" id="SDate" value="<?php echo $SDate; ?>" maxlength="20" size="19" readonly="readonly">
  <a href="javascript:NewCal('SDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>-->

<TR>
    <TD>Course Level <font color='red'>*</font></TD>
    <TD>
      <label for="L1"><input class="radio_style" id="L1" name="courseLevel" type="radio" value="L1" <?php echo $courseLevel == "L1" ? "checked" : "" ?>>L1</label>
      <label for="L2"><input class="radio_style" id="L2" name="courseLevel" type="radio" value="L2" <?php echo $courseLevel == "L2" ? "checked" : "" ?>>L2</label>
      <label for="L3"><input class="radio_style" id="L3" name="courseLevel" type="radio" value="L3" <?php echo $courseLevel == "L3" ? "checked" : "" ?>>L3</label>
    </TD>
</TR>

<TR>
  <TD>Functional Manager[ID] <font color='red'>*</font></TD>
  <TD>
    <select name="fmid" id="fmid"> 
      <option size="30" selected>Select</option>
      <option <?php if($fmid=='N/A')echo " selected"; ?>>N/A</option>
      <option <?php if($fmid=='External/Client')echo " selected"; ?>>External/Client</option>
<?php
      $selectFMID  = "select DISTINCT username from login where role='ID FM' order by username ASC";
      $queryFMID   = mysql_query($selectFMID);
      $numrowsFMID = mysql_num_rows($queryFMID);
      //$tmp =array();
	  if(!empty($numrowsFMID)){ 
        while($fetchFMID = mysql_fetch_array($queryFMID)){
          //$tmp[] = $fetchFMID['username'];
		  if(strlen($fetchFMID['username'])<>0){
?>
            <option <?php if($fmid==$fetchFMID['username'])echo " selected"; ?>><?php echo $fetchFMID['username']; ?></option> 
<?php 
          }
        } 
      }else{
        echo "<option>No functional manager id</option>";  
      } 
?>
  </TD>
</TR>

<TR>
  <TD>Developer Names[ID]</TD>
  <TD>
  <!--<textarea name="devs" id="devs" rows="4" cols="30"><?php //echo stripslashes($devs); ?></textarea>-->
  <select id="devsid" name="devsid[]" size="10" style="width:200px;" multiple>
    <option value="">Select</option>
<?php
$selectDEV  = "SELECT DISTINCT username FROM login WHERE dept='Content' AND role like '%ID%'ORDER BY username ASC";
$queryDEV   = mysql_query($selectDEV);
$numrowsDEV = mysql_num_rows($queryDEV);
if(!empty($numrowsDEV)){ 
  while($fetchDEV = mysql_fetch_array($queryDEV)){
    if(strlen($fetchDEV['username'])<>0){
?>
    <option value='<?php echo $fetchDEV['username']; ?>' <?php if(in_array($fetchDEV['username'], $devsid))echo " selected"; ?>><?php echo $fetchDEV['username']; ?></option> 
<?php 
    }
  } 
} 
?>
  </select>
  </TD>
</TR>

<TR>
  <TD>Functional Manager[Med] <font color='red'>*</font></TD>
  <TD>
    <select name="fmmedia" id="fmmedia"> 
      <option size="30" selected>Select</option>
      <option <?php if($fmid=='N/A')echo " selected"; ?>>N/A</option>
      <option <?php if($fmid=='External/Client')echo " selected"; ?>>External/Client</option>
<?php
      $selectFMMedia  = "select DISTINCT username from login where role='Media FM' order by username ASC";
      $queryFMMedia   = mysql_query($selectFMMedia);
      $numrowsFMMedia = mysql_num_rows($queryFMMedia);
      if(!empty($numrowsFMMedia)){ 
        while($fetchFMMedia = mysql_fetch_array($queryFMMedia)){
	     
		  if(strlen($fetchFMMedia['username'])<>0){
?>
            <option<?php if($fmmedia==$fetchFMMedia['username'])echo " selected"; ?>><?php echo $fetchFMMedia['username']; ?></option> 
<?php 
          }
        } 
      } else{
        echo "<option>No functional manager media</option>";  
      } 
?>
  </TD>
</TR>

<TR>
  <TD>Developer Names[Med]</TD>
  <TD>
  <!--<textarea name="devs" id="devs" rows="4" cols="30"><?php //echo stripslashes($devs); ?></textarea>-->
  <select id="devsmed" name="devsmed[]" size="10" style="width:200px;" multiple>
    <option value="">Select</option>
<?php
$selectDEV  = "SELECT DISTINCT username FROM login WHERE dept='Content' AND role like '%Media%'ORDER BY username ASC";
$queryDEV   = mysql_query($selectDEV);
$numrowsDEV = mysql_num_rows($queryDEV);
if(!empty($numrowsDEV)){ 
  while($fetchDEV = mysql_fetch_array($queryDEV)){
    if(strlen($fetchDEV['username'])<>0){
?>
    <option value='<?php echo $fetchDEV['username']; ?>' <?php if(in_array($fetchDEV['username'], $devsmed))echo " selected"; ?>><?php echo $fetchDEV['username']; ?></option> 
<?php 
    }
  } 
} 
?>
  </select>
  </TD>
</TR>

<TR>
  <TD>Functional Manager[Tech] <font color='red'>*</font></TD>
  <TD>
    <select name="fmtech" id="fmtech"> 
      <option size="30" selected>Select</option>
      <option <?php if($fmid=='N/A')echo " selected"; ?>>N/A</option>
      <option <?php if($fmid=='External/Client')echo " selected"; ?>>External/Client</option>
<?php
      $selectFMTech  = "select DISTINCT username from login where role='Tech FM' order by username ASC";
      $queryFMTech   = mysql_query($selectFMTech);
      $numrowsFMTech = mysql_num_rows($queryFMTech);
      if(!empty($numrowsFMTech)){ 
        while($fetchFMTech = mysql_fetch_array($queryFMTech)){
		if(strlen($fetchFMTech['username'])<>0){
?>
            <option<?php if($fmtech==$fetchFMTech['username'])echo " selected"; ?>><?php echo $fetchFMTech['username']; ?></option> 
<?php 
          }
        } 
      }else{
        echo "<option>No functional manager tech</option>";  
      } 
?>
  </TD>
</TR>


<TR>
  <TD>Developer Names[Tech]</TD>
  <TD>
  <!--<textarea name="devs" id="devs" rows="4" cols="30"><?php //echo stripslashes($devs); ?></textarea>-->
  <select id="devstech" name="devstech[]" size="10" style="width:200px;" multiple>
    <option value="">Select</option>
<?php
$selectDEV  = "SELECT DISTINCT username FROM login WHERE dept='Content' AND role like '%Tech%'ORDER BY username ASC";
$queryDEV   = mysql_query($selectDEV);
$numrowsDEV = mysql_num_rows($queryDEV);
if(!empty($numrowsDEV)){ 
  while($fetchDEV = mysql_fetch_array($queryDEV)){
    if(strlen($fetchDEV['username'])<>0){
?>
    <option value='<?php echo $fetchDEV['username']; ?>' <?php if(in_array($fetchDEV['username'], $devstech))echo " selected"; ?>><?php echo $fetchDEV['username']; ?></option> 
<?php 
    }
  } 
} 
?>
  </select>
  </TD>
</TR>

<TR>
  <TD><label for="type">Version</label> <font color='red'>*</font></TD>
  <TD>
    <label for="proto"><input class="radio_style version" id="proto" name="version" type="radio" value="proto" <?php echo $version == "proto" ? "checked" : "" ?>>Proto</label>
    <label for="POC"><input class="radio_style version" id="POC" name="version" type="radio" value="POC" <?php echo $version == "POC" ? "checked" : "" ?>>POC</label>
    <label for="alpha"><input class="radio_style version" id="alpha" name="version" type="radio" value="alpha" <?php echo $version == "alpha" ? "checked" : "" ?>>Alpha</label>
    <label for="beta"><input class="radio_style version" id="beta" name="version" type="radio" value="beta" <?php echo $version == "beta" ? "checked" : "" ?>>Beta</label>
    <label for="gold"><input class="radio_style version" id="gold" name="version" type="radio" value="gold" <?php echo $version == "gold" ? "checked" : "" ?>>Gold</label>
  </TD>
</TR>

<TR>
  <TD>No of HTML/Flash Pages <font color='red'>*</font></TD>
  <TD><input type="text" name="pagecount" id="pagecount" maxlength="5" size="5" value="<?php echo $pagecount; ?>"></TD>
</TR>
<TR>
  <TD>No. of slides in PPT <font color='red'>*</font></TD>
  <TD><input type="text" name="slidecount" id="slidecount" maxlength="5" size="5" value="<?php echo $slidecount; ?>"></TD>
</TR>

<!--<TR>
  <TD>Iteration round # <font color='red'>*</font></TD>
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
</TR>-->

<TR>
  <TD><label for="type">Learning Hours</label> <font color='red'>*</font></TD>
  <TD><input type="text" name="learningHours" id="learningHours" maxlength="5" size="5" value="<?php echo $learningHours; ?>">
    <!--<label for="pointfive"><input class="radio_style" id="pointfive" name="learningHours" type="radio" value="pointfive">0.5</label>
    <label for="one"><input class="radio_style" id="one" name="learningHours" type="radio" value="one">1</label>
    <label for="oneandhalf"><input class="radio_style" id="oneandhalf" name="learningHours" type="radio" value="oneandhalf">1.5</label>
    <label for="two"><input class="radio_style" id="two" name="learningHours" type="radio" value="two">2</label>-->
  </TD>
</TR>

<TR>
  <TD><label for="type">Course Memory Size in MB</label> <font color='red'>*</font></TD>
  <TD><input type="text" name="coursesize" id="coursesize" maxlength="5" size="5" value="<?php echo $coursesize; ?>">
    <!--<label for="pointfive"><input class="radio_style" id="pointfive" name="learningHours" type="radio" value="pointfive">0.5</label>
    <label for="one"><input class="radio_style" id="one" name="learningHours" type="radio" value="one">1</label>
    <label for="oneandhalf"><input class="radio_style" id="oneandhalf" name="learningHours" type="radio" value="oneandhalf">1.5</label>
    <label for="two"><input class="radio_style" id="two" name="learningHours" type="radio" value="two">2</label>-->
  </TD>
</TR>


<TR>
  <TD>Scope for Testing <font color='red'>*</font></TD>
  <TD>
    <select name="testingScope" id="testingScope" size="1" onChange="checkAllPT(this.value);">
      <option size="30" selected>Select</option>
      <option value="e2e" <?php if($testingScope=="e2e")echo " selected";?>>E2E</option>
      <option value="regression" <?php if($testingScope=="regression")echo " selected";?>>Regression</option>
      <option value="partial testing" <?php if($testingScope=="partial testing")echo " selected";?>>Partial Testing</option>
    </select>
  </TD>
</TR>

<TR>
  <TD><label for="type">Partial Testing</label> <font color='red'>*</font></TD>
  <TD id="check1">
    <label for="audioreview"><input type="checkbox" name="partialTesting[]" id="audioreview" class="check" value="Audio review" <?php if(in_array("Audio review", $partialTesting))echo " checked"; ?>>Audio review</label>
    <label for="contentmapping"><input type="checkbox" name="partialTesting[]" id="contentmapping" class="check" value="Content mapping" <?php if(in_array("Content mapping", $partialTesting))echo " checked"; ?>>Content mapping</label>
    <label for="functionality"><input type="checkbox" name="partialTesting[]" id="functionality" class="check" value="Functionality" <?php if(in_array("Functionality", $partialTesting))echo " checked"; ?>>Functionality</label>
    <label for="transcriptmapping"><input type="checkbox" name="partialTesting[]" id="transcriptmapping" class="check" value="Transcript mapping" <?php if(in_array("Transcript mapping", $partialTesting))echo " checked"; ?>>Transcript mapping</label>
    <label for="internaledit"><input type="checkbox" name="partialTesting[]" id="internaledit" value="Internal edit" <?php if(in_array("Internal edit", $partialTesting))echo " checked"; ?>>Internal edit</label>
    <label for="clienteditalpha"><input type="checkbox" name="partialTesting[]" id="clienteditalpha" class="disable" value="Clientedit alpha" <?php if(in_array("Clientedit alpha", $partialTesting))echo " checked"; ?>>Clientedit alpha</label>
    <label for="clienteditbeta"><input type="checkbox" name="partialTesting[]" id="clienteditbeta" class="disable" value="Clientedit beta" <?php if(in_array("Clientedit beta", $partialTesting))echo " checked"; ?>>Clientedit beta</label>
    <label for="clienteditgold"><input type="checkbox" name="partialTesting[]" id="clienteditgold" class="disable" value="Clientedit gold" <?php if(in_array("Clientedit gold", $partialTesting))echo " checked"; ?>>Clientedit gold</label>
	<br/>
	<label for="scormtesting" style="margin-left:10px;"><input type="checkbox" name="partialTesting[]" id="scormtesting" class="" value="Scorm 1.2" <?php if(in_array("Scorm 1.2", $partialTesting))echo " checked"; ?>>Scorm 1.2</label>
	<label for="scorm2004"><input type="checkbox" name="partialTesting[]" id="scorm2004" class="" value="Scorm 2004" <?php if(in_array("Scorm 2004", $partialTesting))echo " checked"; ?>>Scorm 2004</label>
	
	<label for="AICC" ><input type="checkbox" name="partialTesting[]" id="AICC" class="" value="AICC" <?php if(in_array("AICC", $partialTesting))echo " checked"; ?>>AICC</label>
    <label for="audiomapping"><input type="checkbox" name="partialTesting[]" id="audiomapping" class="check" value="Audio mapping" <?php if(in_array("Audio mapping", $partialTesting))echo " checked"; ?>>Audio mapping</label>
    <label for="audiosynching"><input type="checkbox" name="partialTesting[]" id="audiosynching" class="check" value="Audio synching" <?php if(in_array("Audio synching", $partialTesting))echo " checked"; ?>>Audio synching</label>
    
	<label for="ILT"><input type="checkbox" name="partialTesting[]" id="ILT" value="ILT" <?php if(in_array("ILT", $partialTesting))echo " checked"; ?>>ILT</label>
  </TD>
</TR>

<TR>
  <TD><label for="confimation">Confirmation On Reviews</label> <font color='red'>*</font></TD>
  <TD>
    <label for="idreview"><input type="checkbox" name="confReviews[]" id="idreview" value="ID Review Sign Off Internal" <?php if(in_array("ID Review Sign Off Internal", $confReviews))echo " checked"; ?>>ID Review Sign Off Internal</label>
    <label for="gdreview"><input type="checkbox" name="confReviews[]" id="gdreview" value="Media Review Sign Off Internal" <?php if(in_array("Media Review Sign Off Internal", $confReviews))echo " checked"; ?>>Media Review Sign Off Internal</label>
    <label for="progreview"><input type="checkbox" name="confReviews[]" id="progreview" value="Programming Review Sign Off Internal" <?php if(in_array("Programming Review Sign Off Internal", $confReviews))echo " checked"; ?>>Programming Review Sign Off Internal</label>
    <label for="peerreview"><input type="checkbox" name="confReviews[]" id="peerreview" value="Audio Review Sign Off Internal" <?php if(in_array("Audio Review Sign Off Internal", $confReviews))echo " checked"; ?>>Audio Review Sign Off Internal</label>
    <label for="functionalreview"><input type="checkbox" name="confReviews[]" id="functionalreview" value="Content Mapping Tool Used" <?php if(in_array("Content Mapping Tool Used", $confReviews))echo " checked"; ?>>Content Mapping Tool Used</label>
    <label for="idsignoff"><input type="checkbox" name="confReviews[]" id="idsignoff" value="Functional Review" <?php if(in_array("Functional Review", $confReviews))echo " checked"; ?>>Functional Review</label>
  </TD>
</TR>

<TR>
  <TD><label for="type">Test Environment</label> <font color='red'>*</font></TD>
  <TD id="check1">
<label for="Win7/8 IE11"><input type="checkbox" name="testenvironment[]" id="Win7/8 IE11" value="Win7/8 IE11" <?php if(in_array("Win7/8 IE11", $testenvironment))echo " checked"; ?>>Win7/8 IE11</label>
<label for="Win7 IE10"><input type="checkbox" name="testenvironment[]" id="Win7 IE10" value="Win7 IE10" <?php if(in_array("Win7 IE10", $testenvironment))echo " checked"; ?>>Win7 IE10</label>
<label for="Win7 IE9"><input type="checkbox" name="testenvironment[]" id="Win7 IE9" value="Win7 IE9" <?php if(in_array("Win7 IE9", $testenvironment))echo " checked"; ?>>Win7 IE9</label>
<label for="Win7 IE8"><input type="checkbox" name="testenvironment[]" id="Win7 IE8" value="Win7 IE8" <?php if(in_array("Win7 IE8", $testenvironment))echo " checked"; ?>>Win7 IE8</label>
    <label for="Win7/8 Firefox Latest"><input type="checkbox" name="testenvironment[]" id="Win7/8 Firefox Latest" value="Win7/8 Firefox Latest" <?php if(in_array("Win7/8 Firefox Latest", $testenvironment))echo "  checked"; ?>>Win7/8 Firefox Latest</label>
    <label for="Win7/8 Chrome Latest"><input type="checkbox" name="testenvironment[]" id="Win7/8 Chrome Latest" value="Win7/8 Chrome Latest" <?php if(in_array("WWin7/8 Chrome Latest", $testenvironment))echo " checked";  ?>>Win7/8 Chrome Latest</label>
<label for="iPad 3"><input type="checkbox" name="testenvironment[]" id="iPad 3" value="iPad 3" <?php if(in_array("iPad 3", $testenvironment))echo " checked"; ?>>iPad 3</label>
<label for="iPad 4"><input type="checkbox" name="testenvironment[]" id="iPad 4" value="iPad 4" <?php if(in_array("iPad 4", $testenvironment))echo " checked"; ?>>iPad 4</label>
<label for="iPad Mini"><input type="checkbox" name="testenvironment[]" id="iPad Mini" value="iPad Mini" <?php if(in_array("iPad Mini", $testenvironment))echo " checked"; ?>>iPad Mini</label>
<label for="iPad Air"><input type="checkbox" name="testenvironment[]" id="iPad Air" value="iPad Air" <?php if(in_array("iPad Air", $testenvironment))echo " checked"; ?>>iPad Air</label>
<label for="Apple iPhone 4S"><input type="checkbox" name="testenvironment[]" id="Apple iPhone 4S" value="Apple iPhone 4S" <?php if(in_array("Apple iPhone 4S", $testenvironment))echo " checked"; ?>>Apple iPhone 4S</label>
<br/>&nbsp&nbsp&nbsp

<label for="Apple iPhone 6"><input type="checkbox" name="testenvironment[]" id="Apple iPhone 6" value="Apple iPhone 6" <?php if(in_array("Apple iPhone 6", $testenvironment))echo "  
checked"; ?>>Apple iPhone 6</label>
<label for="Apple iPhone 3GS"><input type="checkbox" name="testenvironment[]" id="Apple iPhone 3GS" value="Apple iPhone 3GS" <?php if(in_array("Apple iPhone 3GS",  
$testenvironment))echo " checked"; ?>>Apple iPhone 3GS</label>
<label for="Apple iPhone 5C"><input type="checkbox" name="testenvironment[]" id="Apple iPhone 5C" value="Apple iPhone 5C" <?php if(in_array("Apple iPhone 5C", $testenvironment))echo  
" checked"; ?>>Apple iPhone 5C</label>
<label for="Nokia Lumia 925"><input type="checkbox" name="testenvironment[]" id="Nokia Lumia 925" value="Nokia Lumia 925" <?php if(in_array("Nokia Lumia 925", $testenvironment))echo  
" checked"; ?>>Nokia Lumia 925</label>
<label for="Nokia Lumia 550"><input type="checkbox" name="testenvironment[]" id="Nokia Lumia 550" value="Nokia Lumia 550" <?php if(in_array("Nokia Lumia 550", $testenvironment))echo  
" checked"; ?>>Nokia Lumia 550</label>
<label for="Samsung Galaxy S3 Neo"><input type="checkbox" name="testenvironment[]" id="Samsung Galaxy S3 Neo" value="Samsung Galaxy S3 Neo" <?php if(in_array("Samsung Galaxy S3 Neo", $testenvironment))echo " checked"; ?>>Samsung Galaxy S3 Neo</label>
<label for="Samsung Galaxy S4"><input type="checkbox" name="testenvironment[]" id="Samsung Galaxy S4" value="Samsung Galaxy S4" <?php if(in_array("Samsung Galaxy S4",  
$testenvironment))echo " checked"; ?>>Samsung Galaxy S4</label>
<label for="Samsung Grand 2"><input type="checkbox" name="testenvironment[]" id="Samsung Grand 2" value="Samsung Grand 2" <?php if(in_array("Samsung Grand 2",  
$testenvironment))echo " checked"; ?>>Samsung Grand 2</label>
<label for="Samsung Galaxy Tab 3, 8 inch"><input type="checkbox" name="testenvironment[]" id="Samsung Galaxy Tab 3, 8 inch" value="Samsung Galaxy Tab 3, 8 inch" <?php if (in_array("Samsung Galaxy Tab 3, 8 inch", $testenvironment))echo " checked"; ?>>Samsung Galaxy Tab 3, 8 inch</label>
<br/>&nbsp&nbsp&nbsp
<label for="Samsung Galaxy Tab 4, 8 inch"><input type="checkbox" name="testenvironment[]" id="Samsung Galaxy Tab 4, 8 inch" value="Samsung Galaxy Tab 4, 8 inch" <?php if (in_array("Samsung Galaxy Tab 4, 8 inch", $testenvironment))echo " checked"; ?>>Samsung Galaxy Tab 4, 8 inch</label>
<label for="Samsung Note 10"><input type="checkbox" name="testenvironment[]" id="Samsung Note 10" value="Samsung Note 10" <?php if(in_array("Samsung Note 10", $testenvironment))echo " checked"; ?>>Samsung Note 10</label>
<label for="Samsung Galaxy Tab E"><input type="checkbox" name="testenvironment[]" id="Samsung Galaxy Tab E" value="Samsung Galaxy Tab E" <?php if(in_array("Samsung Galaxy Tab E", $testenvironment))echo " checked"; ?>>Samsung Galaxy Tab E</label>
<label for="Microsoft Surface RT"><input type="checkbox" name="testenvironment[]" id="Microsoft Surface RT" value="Microsoft Surface RT" <?php if(in_array("Microsoft Surface RT", $testenvironment))echo " checked"; ?>>Microsoft Surface RT</label>
<label for="Mac Book"><input type="checkbox" name="testenvironment[]" id="Mac Book" value="Mac Book" <?php if(in_array("Mac Book", $testenvironment))echo " checked"; ?>>Mac Book</label>
<label for="MS Word"><input type="checkbox" name="testenvironment[]" id="MS Word" value="MS Word" <?php if(in_array("MS Word", $testenvironment))echo " checked"; ?>>MS Word</label>
<label for="Media Player"><input type="checkbox" name="testenvironment[]" id="Media Player" value="Media Player" <?php if(in_array("Media Player", $testenvironment))echo " checked"; ?>>Media Player</label>
<label for="PPT"><input type="checkbox" name="testenvironment[]" id="PPT" value="PPT" <?php if(in_array("PPT", $testenvironment))echo " checked"; ?>>PPT</label>
  </TD>
</TR>

<TR>
  <TD>Course Path [SVN] <font color='red'>*</font></TD>
  <TD><input type="text" name="path" id="path" maxlength="400" size="45" value="<?php echo $path; ?>"></TD>
</TR>

<TR>
  <TD>SB Path [SVN] <font color='red'>*</font></TD>
  <TD><input type="text" name="sbpath" id="sbpath" maxlength="400" size="45" value="<?php echo $sbpath; ?>"></TD>
</TR>

<TR>
  <TD>Edit Sheet <font color='red'>*</font></TD>
  <TD><input type="text" name="editsheet" id="editsheet" maxlength="400" size="45" value="<?php echo $editsheet; ?>"></TD>
</TR>

<TR>
  <TD>Development Tracker Path [SVN] <font color='red'>*</font></TD>
  <TD><input type="text" name="dtpath" id="dtpath" maxlength="400" size="45" value="<?php echo $dtpath; ?>"></TD>
</TR>

<TR>
  <TD>Updated PSD path [SVN] <font color='red'>*</font></TD>
  <TD><input type="text" name="tppath" id="tppath" maxlength="400" size="45" value="<?php echo $tppath; ?>"></TD>
</TR>

<TR>
  <TD>Test Case/Checklists [SVN] <font color='red'>*</font></TD>
  <TD><input type="text" name="chk" id="chk" maxlength="400" size="45" value="<?php echo $chk; ?>"></TD>
</TR>

<TR>
  <TD width="150">Comments / Release note information</TD>
  <TD><textarea name="comments" id="comments" rows="4" cols="30"><?php echo stripslashes($comments); ?></textarea></TD>
</TR>




<TR>
	<TD valign="top">Attach supporting documents</TD>
  <TD>
    <table cellpading="0" cellspacing="0">
      <tr>
        <td><input type="file" name="supportfile1" id="supportfile1" size="35" /></td>
      </tr>
      <tr>
        <td><input type="file" name="supportfile2" id="supportfile2" size="35" /></td>
      </tr>
      <tr>
        <td><input type="file" name="supportfile3" id="supportfile3" size="35" /></td>
      </tr>
      <tr>
        <td><input type="file" name="supportfile4" id="supportfile4" size="35" /></td>
      </tr>
    </table>  
  </TD>
</TR>

</TABLE>
<br>
<input type="hidden" name="reviewer" id="reviewer" value="<?php echo $username; ?>">
<input type="hidden" name="edit" value="<?php echo $_GET['chdid']; ?>">
<input type="submit" name="addInfo" class="button" value="Add">
<input type="button" class="button" value="Log Out" onclick="location.href='logout.php';">
<input type="button" class="button" value="Show All Fileinfo" onClick="showAll()">
<br>
<br>
<div id="ResHint"></div>
<div id="txtHint"></div>
</form>
</body>
</html> 
<script>
$(document).ready(function(){
	$(".version").click(function(){
		if($(this).is(":checked")){
			var version = $(this).val();
			if(version != "beta" && version != "gold") {
				$(".disable").attr("disabled", true);
				$(".disable").attr("checked", false);
			} else  {
				$(".disable").attr("disabled", false);
			}
		}
	});
    var ver = '<?php echo $_REQUEST['version']?>';
	if(ver != "beta" && ver != "gold" && ver != "") {
		$(".disable").attr("checked", false);
		$(".disable").attr("disabled", true);
	}
});
function checkAllPT(tsval){
  if(tsval=='e2e'){
    $('.check').attr('checked', true);
  }else{
    $('.check').attr('checked', false);
  }
}
</script>

<?php

function getEmail($username){
	$result = mysql_query("select email from login where username = '".$username."' limit 0,1");
	if(mysql_num_rows($result) == 1) {
		$value = mysql_fetch_object($result);
		return $value->email;
	}
	return null;
}

?>