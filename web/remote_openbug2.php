<html>
<head>
<style type="text/css">
body
{
	margin:13px 0px 0px 0px;
	font-family:Arial;
	font-size:12px;
	overflow:hidden;

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
h4{
	font-size:80%;
}
label{
	font-family:Tahoma;
	font-size:12px;
}
.helpicon{
	width:15px;
	height:15px;
	display:inline-block;
	border-radius:20px;
	color:#FFFFFF;
	background-color:#000000;
	text-indent:4px;
	line-height:15px;
}
</style>
<script src="js/jquery.js"></script>
</head>
<?php	
error_reporting(0);
session_start();

$reviewer = isset($_SESSION['reviewer']) ? $_SESSION['reviewer'] : "";

$user=$_SESSION['login'];

include('config.php');

$errors = array();

if(!isset($_REQUEST['mode']) || $_REQUEST['mode'] != 'bug_submission') {
	if(!isset($_REQUEST['Project']) || !ctype_digit($_REQUEST['Project']) || $_REQUEST['Project'] < 0) {
		$errors[] = "Invalid Project";
	} else {
		$result = mysql_query("SELECT projectname from projectmaster WHERE pindatabaseid =".$_REQUEST['Project']);
		if(mysql_num_rows($result) != 1){
			$errors[] = "Project does not exists";
		} else if(mysql_num_rows($result) == 1){
			$row = mysql_fetch_assoc($result);
			$project_name = $row['projectname']; 
		}
	}
	if(!isset($_REQUEST['phase']) || !ctype_alpha($_REQUEST['phase']) || !in_array($_REQUEST['phase'], array("alpha", "beta", "gold", "POC"))){
		$errors[] = "Invalid Phase";
	}
	if(!isset($_REQUEST['module']) || $_REQUEST['module'] == ""){
		$errors[] = "Invalid Module";
	}
	if(!isset($_REQUEST['topic']) ||  $_REQUEST['topic'] == ""){
		$errors[] = "Invalid Topic";
	}
	if(!isset($_REQUEST['screen']) || $_REQUEST['screen'] == ""){
		$errors[] = "Invalid Screen";
	}
	if(!isset($_REQUEST['browser']) || $_REQUEST['browser'] == '' || !in_array($_REQUEST['browser'], array('IE6','IE7','IE8','IE9','IE10','IE11','IE12','Chrome','Firefox','Ipad2','Ipad3','Android Phone','Android Tablet','Safari','IPhone'))){
		$errors[] = "Invalid Browser Info";
	}
}

if (!(isset($_SESSION['login']) && $_SESSION['login'] != '') || !(isset($_SESSION['username']) && $_SESSION['username'] != '')) { 
	$_SESSION['qString'] = $_SERVER['QUERY_STRING'];
	header ("Location:remote_login.php");
} 
	



$query = "select username from login where uniqueid='$user'";
$retval = mysql_query( $query, $con );
$count = mysql_num_rows($retval);

if($count==0){
	die('Data Not Found Please contact SEPG');
}

//if(!isset($_REQUEST['mode'])) {  
	while($row = mysql_fetch_assoc($retval)) { 
		echo"	<div style='width:100%;height:32px;'>
				<div style='width:50%;float:left;height:32px;text-indent:10px;'><img src='images/G_Cube_logo1.png' style='margin-bottom:4px;'></div>
				<div style='width:46%;float:right;margin-right:10px;height:32px;text-align:left;'>"."Hi ".$row['username']." !<br/> Welcome to Bug Tracking Tool </div>
			</div>";
		//echo "<div style='width:100%;height:22px;'><div style='width:40%;float:left;height:22px;line-height:22px;text-indent:10px;'>"."Hi ".$row['username']." !</div><div style='width:55%;float:right;margin-right:10px;height:22px;text-align:right;line-height:22px;'> Welcome to QC bug logging Tool </div></div>";
		$username=$row['username'];
	} 	
//}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'bug_submission') {
   // Configuration - Your Options
   $allowed_filetypes = array('.doc','.docx','.xls','.xlsx','.jpeg','.jpg','.JPG','.JPEG','.png','.PNG','.bmp','.BMP','.gif','.GIF'); // These will be the types of file that will pass the validation.
   $max_filesize = 1048576; // Maximum filesize in BYTES (currently 1MB).
   $upload_path = './qcfiles/'; // The place the files will be uploaded to (currently a 'files' directory).
   
   $a=mysql_real_escape_string($_POST["project"]);//project
   $sql="SELECT projectmanager,fmone,fmtwo,fmthree,fmfour FROM projectmaster WHERE projectname = '".$a."'";
   $result = mysql_query($sql);
   $count = mysql_num_rows($result);

   if($count==0){
	die('Data Not Found');
   }

   while($row = mysql_fetch_array($result)){
	   $pm=$row['projectmanager']; 
	   $fmone=$row['fmone'];
	   $fmtwo=$row['fmtwo'];
	   $fmthree=$row['fmthree'];
	   $fmfour=$row['fmfour']; 
   }

   $b="PM :".$pm."| ID FM :".$fmone."|  Media FM :".$fmtwo."|  Scripting FM :".$fmthree."|  QC FM :".$fmfour;
   $f=mysql_real_escape_string($_POST["phase"]);//topic
   $g=mysql_real_escape_string($_POST["module"]);//screen
   $h=mysql_real_escape_string($_POST["topic"]);//qc
   $x = date( 'Y-m-d');
   $j=mysql_real_escape_string($_POST["browser"]);//module
   $k=mysql_real_escape_string($_POST["coursestatus"]);//topic
   $l=mysql_real_escape_string($_POST["bcat"]);//pagenumber
   $m=mysql_real_escape_string($_POST["bdr"]);//bug description
   // $n=mysql_real_escape_string($_POST["asignee"]);//bug description
   $o=mysql_real_escape_string($_POST["qc"]);
   $p=mysql_real_escape_string($_POST["screen"]);
   $q=mysql_real_escape_string($_POST["severity"]);
   $filename = $_FILES['userfile']['name']; // Get the name of the file (including file extension).
   $reviewer = mysql_real_escape_string($_POST['reviewer']);
   $_SESSION['reviewer'] = $reviewer;


	/**** find out assignee on behalf of bug cateory ****/
	switch($l) {
		case "editorial":{ 
			$n = $fmone; // ID Manager
		}
		break;
		case "media":{ 
			$n = $fmtwo; // Graphics / Media Manager
		}
		break;
		case "functionality":{ 
			$n = $fmthree; // Scripting Manager
		}
		break;
		case "audio":{ 
			$n = $fmtwo; // Media Manager
		}
		break;
		case "suggesstion":{ 
			$n = $fmfour; // QC Manager
		}
		break;
		case "global":{ 
			$n = $fmfour; // QC Manager
		}
		break;
	}

   if($filename<>""){
	$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); // Get the extension from the filename.
	// Check if the filetype is allowed, if not DIE and inform the user.
	if(!in_array($ext,$allowed_filetypes)){
		die('The file you attempted to upload is not allowed.Allowed are : doc,docx,xls,xlsx,jpg,jpeg,png,bmp');
    }
   //we can also try this : if($_FILES['userfile']['type'] != "image/gif") { echo "Sorry, we only allow uploading GIF images";   exit;}
 
   // Now check the filesize, if it is too large then DIE and inform the user.
   if(filesize($_FILES['userfile']['tmp_name']) > $max_filesize)
      die('The file you attempted to upload is too large.');
 
   // Check if we can upload to the specified path, if not DIE and inform the user.
   if(!is_writable($upload_path))
      die('You cannot upload to the specified directory, please CHMOD it to 777.');
    $date = date('m/d/Y h:i:s a', time());
	$mydate = date('Y-m-d h:i:s', time());
	//echo "Current Time:".$date;
	$values = explode(" ",$date);
	$dates = explode("/", $values[0]);
	$times = explode(":", $values[1]);
	$timex=$dates[1]."_".$dates[0]."_".$dates[2]."_"."T".$times[0]."_".$times[1]."_".$times[2];
	$str=$a."_".$f."_".$timex.$ext;
	$str=mysql_real_escape_string($str);
	
   if(move_uploaded_file($_FILES['userfile']['tmp_name'],$upload_path . $str))
   {
    $msg='Your file '.$filename.' upload was successful for project :'.$a.' and phase :'.$f.',You can view the file <a href="' . $upload_path . $str . '" title="Your File">here</a>'; // It worked.
    echo "</br>";
    $query="INSERT INTO qcuploadinfo(project,phase,module,topic,receivedate,browser,coursestatus,bcat,bdr,asignee,qc,screen,filepath,filename,uploaddate,severity,whenchangedstatus,whochangedstatus, reviewer) values('".$a."','".$f."','".$g."','".$h."','".$x."','".$j."','".$k."','".$l."','".$m."','".$n."','".$o."','".$p."','".$str."','".$filename."','".$mydate."','".$q."','".$mydate."','".$username."', '".$reviewer."')";

     if (mysql_query($query))
     {
	      //header ("Location: openbug2.php?message=".urlencode($msg)."&proj=".urlencode($a)."&fmdetails=".urlencode($b)."&phase=".urlencode($f)."&module=".urlencode($g)."&topic=".urlencode($h)."&receivedate=".urlencode($i)."&browser=".urlencode($j)."&coursestatus=".urlencode($k)."&bcat=".urlencode($l)."&bdr=".urlencode($m)."&asignee=".urlencode($n)."&qc=".urlencode($o)."&screen=".urlencode($p)."&severity=".urlencode($q));

		echo '<div style="width:100%;height:5px;background-color:rgb(247,148,28);color:#FFFFFF"></div>';
		echo '<div style="width:100%;height:5px;background-color:rgb(251,192,122);"></div>';
		echo '<div style="width:100%;height:10px;"></div>';
		
		echo '<div style="width:57%;height:200px;float:left;display:table-cell;">';
		echo "<br><br><br><br><center>Issue has been submitted successfully</center>";
		echo '</div>';
		echo '<div style="width:42%;height:200px;float:right;text-align:left;">';
		echo '	<img src="images/Bee003.png">';
		echo '</div>';
		echo "<script>window.setTimeout(function(){this.close();},2000);</script>";
		exit();
     }
     else
     {
        	echo "Uploadinfo table couldn't be updated.";
		exit();
     }
   }	  
   
   else
         echo 'There was an error during the file upload.  Please try again.'; // It failed :(.
         exit();

   } //this is end of if which is checking whether filename is blank or not. 

   else //filename is blank means the user has not uploaded any file.
   {
	$mydate = date('Y-m-d h:i:s', time());     
	$query="INSERT INTO qcuploadinfo(project,phase,module,topic,receivedate,browser,coursestatus,bcat,bdr,asignee,qc,screen,uploaddate,severity,whenchangedstatus,whochangedstatus, reviewer) values('".$a."','".$f."','".$g."','".$h."','".$x."','".$j."','".$k."','".$l."','".$m."','".$n."','".$o."','".$p."','".$mydate."','".$q."','".$mydate."','".$username."', '".$reviewer."')";
	if (mysql_query($query))
        {
		$msg="The bug has been logged without file. You can click on Show All Fileinfo to see the details";
	      	//header ("Location: openbug2.php?message=".urlencode($msg)."&proj=".urlencode($a)."&pm=".urlencode($b));
		//header ("Location: openbug2.php?message=".urlencode($msg)."&proj=".urlencode($a)."&fmdetails=".urlencode($b)."&phase=".urlencode($f)."&module=".urlencode($g)."&topic=".urlencode($h)."&receivedate=".urlencode($i)."&browser=".urlencode($j)."&coursestatus=".urlencode($k)."&bcat=".urlencode($l)."&bdr=".urlencode($m)."&asignee=".urlencode($n)."&qc=".urlencode($o)."&screen=".urlencode($p)."&severity=".urlencode($q));



		echo '<div style="width:100%;height:5px;background-color:rgb(247,148,28);color:#FFFFFF"></div>';
		echo '<div style="width:100%;height:5px;background-color:rgb(251,192,122);"></div>';
		echo '<div style="width:100%;height:10px;"></div>';
		
		echo '<div style="width:57%;height:200px;float:left;display:table-cell;">';
		echo "<br><br><br><br><center>Issue has been submitted successfully</center>";
		echo '</div>';
		echo '<div style="width:42%;height:200px;float:right;text-align:left;">';
		echo '	<img src="images/Bee003.png">';
		echo '</div>';
		echo "<script>window.setTimeout(function(){this.close();},2000);</script>";
		exit();
	}
    	else
        {
        	echo "Uploadinfo table couldn't be updated.";
		exit();
	}
   }
}
?>
<body>
<script src="js/jquery.js"></script>
<script type="text/javascript">
if ($.browser.msie) {
	this.resizeTo(430,435);
} else {
	this.resizeTo(430,400);
}

window.onresize = function() 
{
	if ($.browser.msie) {
	    window.resizeTo(430,435);
	} else {
	    window.resizeTo(430,400);
	}
}
function verify()
{
 var numericExpression = /^[0-9]+$/;
 var alphaExp = /^[a-zA-Z /s]*$/;
 var alphanumericExp = /^[0-9a-zA-Z._, /s]*$/;
 var project = trim(document.getElementById('project').value);
 var phase = trim(document.getElementById('phase').value);
 var module = trim(document.getElementById('module').value);
 var topic = trim(document.getElementById('topic').value);
 var screen = trim(document.getElementById('screen').value);
 var qc = trim(document.getElementById('qc').value);
 var severity = trim(document.getElementById('severity').value);
 var SDate = trim(document.getElementById('SDate').value);
 var browser = trim(document.getElementById('browser').value);
 var coursestatus = trim(document.getElementById('coursestatus').value);
 var bcat = trim(document.getElementById('bcat').value);
 var bug = trim(document.getElementById('bdr').value);

if(project=="Select" || project == '' || project == undefined)
  {
  alert("Project must be selected");
  return false;
  }

if(phase=="select" || phase == '' || phase == undefined)
  {
  alert("Phase must be selected");
  return false;
  }

if(module=="" || module == '' || module == undefined)
  {
  alert("Module Name should be identified");
  return false;
  }
 
if(topic=="" || topic == '' || topic == undefined)
  {
  alert("Topic should be identified");
  return false;
  }
if(screen=="" || screen == '' || screen == undefined)
  {
  alert("Screen no should be identified");
  return false;
  }
 
if(qc=="select" || qc == '' || qc == undefined)
  {
  alert("QC must be identified");
  return false;
  }
 
if(severity=="select")
  {
  alert("Severity must be identified");
  return false;
  }

if(SDate=="")
  {
  alert("Date on which received must be selected");
  return false;
  }
 
if(browser=="select")
  {
  alert("Browser should be identified");
  return false;
  }
 
if(coursestatus=="select" || coursestatus == '' || coursestatus == undefined)
  {
  alert("Status should be specified");
  return false;
  }
  
if(bcat=="select")
  {
  alert("Bug category should be identified");
  return false;
  }
  
if(bug=="")
  {
  alert("Bug description should be given");
  return false;
  }

if(bug.length > 500)
  {
  alert("Bug description should not be greater than 500 characters");
  return false;
  }

/*
if(!module.match(alphanumericExp))
  {
  alert("Module Name Should be Purely Alphanumeric");
  return false;
  }
  
if(!screen.match(alphanumericExp))
  {
  alert("Screen Details Should be Purely Alphanumeric");
  return false;
  }

if(!topic.match(alphanumericExp))
  {
  alert("Topic Details Should be Purely Alphanumeric");
  return false;
  }
*/
 /*
  if(!bug.match(alphanumericExp))
  {
  alert("Please don't use special characters in description");
  return false;
  }
*/
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
	$('#bdr').keyup(function () {
	  var max = 500;
	  var len = $(this).val().length;
	  if (len >= max) {
	    $('#charNum').text('0 char(s) left');
	    $(this).val($(this).val().substr(0, max));
	  } else {
	    var char = max - len;
	    $('#charNum').text(char + ' char(s) left');
	  }
	});

});



</script>

<?php
if(count($errors) > 0){
	echo '<div style="width:100%;height:5px;background-color:rgb(247,148,28);color:#FFFFFF"></div>';
	echo '<div style="width:100%;height:5px;background-color:rgb(251,192,122);"></div>';
	echo '<div style="width:100%;height:10px;"></div>';
	
	echo '<div style="width:57%;height:200px;float:left;display:table-cell;">';
	echo '  <br/><br/>';
		echo "<ul>";
		foreach($errors as $error) {
			echo '<li>'.$error."</li>";
		}
		echo "</ul>";
	echo '<p align="center"><input type="button" class="button" value="Log Out" onclick="location.href=\'remote_logout.php\';"></p>';
	echo '</div>';
	echo '<div style="width:42%;height:200px;float:right;text-align:left;">';
	echo '	<img src="images/Bee002.png">';
	echo '</div>';
		exit();
	}
?>
<form name="tstest" action="./remote_openbug2.php" onsubmit="return verify()" method="post" enctype="multipart/form-data">

<input type="hidden" name="mode" id="mode" value="bug_submission">
<input type="hidden" name="project" id="project" value="<?=$project_name?>">
<input type="hidden" name="module" id="module" value="<?=$_REQUEST['module']?>">
<input type="hidden" name="topic" id="topic" value="<?=$_REQUEST['topic']?>">
<input type="hidden" name="screen" id="screen" value="<?=$_REQUEST['screen']?>">
<input type="hidden" name="browser" id="browser" value="<?=$_REQUEST['browser']?>">
<input type="hidden" name="qc" id="qc" value="<?=$_SESSION['username']?>">
<input type="hidden" name="SDate" id="SDate" value="<?=date("d-M-Y")?>">
<input type="hidden" name="coursestatus" id="coursestatus" value="accepted">
<input type="hidden" name="luser" id="luser" value="<?php echo $username;?>">


<div style="width:100%;height:22px;line-height:22px;text-indent:10px;background-color:rgb(247,148,28);color:#FFFFFF">
	<label><?=$project_name?></label>
	<label style="float:right;padding-right:10px">Reviewer: <?=$reviewer?></label>
</div>
<div style="width:100%;height:22px;line-height:22px;text-indent:10px;background-color:rgb(251,192,122);">
	<label><?=$_REQUEST['module']?> : <?=$_REQUEST['topic']?> : <?=$_REQUEST['screen']?></label>
	<label style="float:right;padding-right:10px"><a href="remote_logout.php">Log out</a></label>
</div>
<div style="width:100%;height:10px;"></div>
<TABLE cellspacing="0" cellpadding="0">
<TR>
<TD style="text-indent:10px"><label>Phase</label></TD><TD>
<?php
	echo "<label>".$_REQUEST['phase']."</label>";
	echo '<input type="hidden" name="phase" id="phase" value="'.$_REQUEST['phase'].'">';
?>
</TD>
</TR>

<TR>
<TD width="30%" style="text-indent:10px"><label>Severity</label></TD><TD><select name="severity" size="1" id="severity">
<option value="High">High</option>
<option value="Medium" selected>Medium</option>
<option value="Low">Low</option>
</select></TD>
</TR>

<TR>
<TD style="text-indent:10px"><label>Bug Category</label></TD><TD><select name="bcat" size="1" id="bcat">
<option value="select" selected>Select</option>
<option value="global" <?php if($bcat=="global")echo " selected";?>>Global</option>
<option value="editorial" <?php if($bcat=="editorial")echo " selected";?>>Editorial</option>
<option value="media" <?php if($bcat=="media")echo " selected";?>>Media</option>
<option value="functionality" <?php if($bcat=="functionality")echo " selected";?>>Functionality</option>
<option value="audio" <?php if($bcat=="audio")echo " selected";?>>Audio</option>
<option value="suggesstion" <?php if($bcat=="suggesstion")echo " selected";?>>Suggesstion</option>
</select></TD>
</TR>

<input type="hidden" name="reviewer" id="reviewer" maxlength="100" value="<?=$reviewer?>">
<TR>
<TD style="padding-left:10px;vertical-align:top;"><label>Bug Description</label><br />
<label id="charNum" style="font-size:10px;"></label>
</TD>
<TD><textarea name="bdr" rows="4" cols="30" id="bdr"><?php echo stripslashes($bdr);?></textarea></TD>
</TR>

<TR>
<TD style="text-indent:10px"><label>Select a file <span class="helpicon"><a title="Only .doc, .docx, .xls, .xlsx, .jpg, .jpeg, .png, .bmp, .gif and max size 1 MB">?</a></span></label></TD><TD><input type="file" name="userfile" id="file"></TD>
</TR>
<tr>
  <td></td>
  <td>
	<div style="width:100%;height:6px;"></div>
	<input type="submit" class="button" value="Submit">
	<input type="button" class="button" value="View all comments" onclick="window.open('remote_allbugs.php?project_name=<?=$project_name?>','bug_report');">
  </td>
</tr>
</TABLE>

</form>
</body>
</html> 