<html>
<?php	
	error_reporting(0);
	session_start();
	
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location:index.php");
    }
	
    $user=$_SESSION['login'];

    include('config.php');

    $query = "select username,role from login where pwd='$user'";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found Please contact SEPG');
		}

    
    while($row = mysql_fetch_assoc($retval)) 
    { 
     //echo "<h4>"."Hi ".$row['username']." ! Welcome To BUG Sheet Upload Tool"."</h4>";
	 $username=$row['username'];
         $role=$row['role'];
    } 	

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
     // Configuration - Your Options
   $allowed_filetypes = array('.doc','.docx','.xls','.xlsx','.jpeg','.jpg','.JPG','.JPEG','.png','.PNG','.bmp','.BMP','.gif','.GIF'); // These will be the types of file that will pass the validation.
   $max_filesize = 1048576; // Maximum filesize in BYTES (currently 1MB).
   $upload_path = './files/'; // The place the files will be uploaded to (currently a 'files' directory).
   
   $q=mysql_real_escape_string($_POST["project"]);//project
   $r=mysql_real_escape_string($_POST["phase"]);//phase
   $s=mysql_real_escape_string($_POST["user"]);//user
   //$t=mysql_real_escape_string($_POST["reviewer"]);//reviewer
   $bc = mysql_real_escape_string($_POST["bcat"]);//reviewer
   $u=mysql_real_escape_string($_POST["module"]);//module
   $v=mysql_real_escape_string($_POST["topic"]);//topic
   $w=mysql_real_escape_string($_POST["pagenumber"]);//pagenumber
   $x=mysql_real_escape_string($_POST["bdr"]);//bug description
 
   $filename = $_FILES['userfile']['name']; // Get the name of the file (including file extension).
   echo "File :".$filename;
   if($filename<>"")
   {
   $ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); // Get the extension from the filename.
   // Check if the filetype is allowed, if not DIE and inform the user.
   if(!in_array($ext,$allowed_filetypes))
      die('The file you attempted to upload is not allowed.');

   //we can also try this : if($_FILES['userfile']['type'] != "image/gif") { echo "Sorry, we only allow uploading GIF images";   exit;}
 
   // Now check the filesize, if it is too large then DIE and inform the user.
   if(filesize($_FILES['userfile']['tmp_name']) > $max_filesize)
      die('The file you attempted to upload is too large.');
 
   // Check if we can upload to the specified path, if not DIE and inform the user.
   if(!is_writable($upload_path))
      die('You cannot upload to the specified directory, please CHMOD it to 777.');
    $date = date('m/d/Y h:i:s a', time());
	//echo "Current Time:".$date;
	$values = explode(" ",$date);
	$dates = explode("/", $values[0]);
	$times = explode(":", $values[1]);
	$timex=$dates[1]."_".$dates[0]."_".$dates[2]."_"."T".$times[0]."_".$times[1]."_".$times[2];
	$str=$q."_".$r."_".$timex.$ext;
	$str=mysql_real_escape_string($str);
	
   if(move_uploaded_file($_FILES['userfile']['tmp_name'],$upload_path . $str))
   {
    $msg='Your file '.$filename.' upload was successful for project :'.$q.' and phase :'.$r.',You can view the file <a href="' . $upload_path . $str . '" title="Your File">here</a>'; // It worked.
    echo "</br>";
	$query="INSERT INTO uploadinfo(project,phase,filepath,user,category,module,topic,page,description,filename, bug_posting_date) values('".$q."','".$r."','".$str."','".$s."','".$bc."','".$u."','".$v."','".$w."','".$x."','".$filename."',SYSDATE())";
    //echo $query;
	if (mysql_query($query))
       {
		  //echo "Record created with id :".$row['id']." and description :".$w;
	      header ("Location: uploadsheet.php?message=".urlencode($msg)."&proj=".urlencode($q)."&phase=".urlencode($r)."&bugcat=".urlencode($bc)."&module=".urlencode($u)."&topic=".urlencode($v)."&screen=".urlencode($w)."&bdr=".urlencode($x));
	   }
    else
       {
        echo "Uploadinfo table couldn't be updated.".mysql_error();
	   }
   }	  
   
   else
         echo 'There was an error during the file upload.  Please try again.'; // It failed :(.	

   } //this is end of if which is checking whether filename is blank or not. 

  else //filename is blank means the user has not uploaded any file.
	{
     $query="INSERT INTO uploadinfo(project,phase,user,category,module,topic,page,description, bug_posting_date) values('".$q."','".$r."','".$s."','".$bc."','".$u."','".$v."','".$w."','".$x."', SYSDATE())";
    //echo $query;
	if (mysql_query($query))
       {
		  //echo "Record created with id :".$row['id']." and description :".$w;
		  $msg="You haven't uploaded any file. You can click on Show All Fileinfo";
	      header ("Location: uploadsheet.php?message=".urlencode($msg)."&proj=".urlencode($q)."&phase=".urlencode($r)."&bugcat=".urlencode($bc)."&module=".urlencode($u)."&topic=".urlencode($v)."&screen=".urlencode($w)."&bdr=".urlencode($x));
	   }
    else
       {
        echo "Uploadinfo table couldn't be updated.".mysql_error();
	   }
	}
}
?>
<head>
<script src="js/jquery.js"></script>
<script type="text/javascript">
function editbug(str)
{
 //alert(str);
 mywindow=window.open ("edituat.php?id="+str,"Ratting","scrollbars=1,width=550,height=170,0,status=0,");
 if (window.focus) {mywindow.focus()}
}

function submitresponse(str)
{
reason = "reason"+str;
var usr = trim(document.getElementById('uname').value); 
var ptr = trim(document.getElementById(str).value);
var rea = trim(document.getElementById(reason).value);

//alert (usr);
//alert (rea);
//alert (str);
//alert (ptr);

if (ptr=="select")
{
 alert ("The status must be selected");
 //document.getElementById(str).focus();
 return false;
}

/*
if (rea=="")
{
 alert ("The reason must be specified");
 //document.getElementById(str).focus();
 return false;
}
*/


/*
if (str=="")
  {
  document.getElementById("ResHint").innerHTML="";
  return;
  }
*/

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
      //document.getElementById("ResHint").innerHTML=xmlhttp.responseText;
	if(confirm(xmlhttp.responseText+"\n\nClick 'OK' or 'Show All Fileinfo' to reload the bugs data.")){
		showAll('display');
	}
    }
  }

rea=encodeURIComponent(rea); 
xmlhttp.open("GET","updatbugstat.php?q="+str+ "&r=" + ptr+ "&s=" + usr+ "&t=" + rea,true);
xmlhttp.send();

}

function verify()
{
 var numericExpression = /^[0-9]+$/;
 var alphaExp = /^[a-zA-Z /s]*$/;
 var alphanumericExp = /^[0-9a-zA-Z._, /s]*$/;
 var project = trim(document.getElementById('project').value);
 var phase = trim(document.getElementById('phase').value);
 var bcat = trim(document.getElementById('bcat').value);
 //var reviewer = trim(document.getElementById('reviewer').value);
 var module = trim(document.getElementById('module').value);
 var topic = trim(document.getElementById('topic').value);
 var page = trim(document.getElementById('pagenumber').value);
 var bug = trim(document.getElementById('bdr').value);

 if(project=="Select")
  {
  alert("Project must be selected");
  return false;
  }

 if(phase=="select")
  {
  alert("Phase must be selected");
  return false;
  }
 
 if(bcat=="select")
  {
  alert("Category must be selected");
  return false;
  }
 
/*
 if(module=="")
  {
  alert("Module should be identified");
  return false;
  }
 
 if(topic=="")
  {
  alert("Topic should be identified");
  return false;
  }
  
  if(page=="")
  {
  alert("Page should be identified");
  return false;
  }
*/  

  if(bug=="")
  {
  alert("Bug description should be given");
  return false;
  }

  if(!reviewer.match(alphaExp))
  {
  alert("Reviewer Name Should be purly Alphabetic");
  return false;
  }

  if(!module.match(alphanumericExp))
  {
  alert("Module details Should be only Alpha-Numeric");
  return false;
  }

  if(!topic.match(alphanumericExp))
  {
  alert("Topic details Should be only Alpha-Numeric");
  return false;
  }

  if(!page.match(alphanumericExp))
  {
  alert("Page Number Should be only Alpha-Numeric");
  return false;
  }
  
}

function showAll(param)
{
//newwindow.close();
str=document.forms["tstest"]["project"].value;
role=document.forms["tstest"]["role"].value;
//alert (str);

if (str=="Select")
  {
  alert("Project must be selected");
  document.forms["tstest"]["project"].focus();
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
    }
  }
str=encodeURIComponent(str);
//alert(123);
	if(param == 'display') {
		xmlhttp.open("GET","getfileinfo.php?q="+str+ "&r="+role+"&bcat="+$('#filter_bcat').val()+ "&bugstatus="+$('#filter_bugstatus').val()+"&mode="+param,true);
		xmlhttp.send();
	} else {
		window.open("getfileinfo.php?q="+str+ "&r="+role+"&bcat="+$('#filter_bcat').val()+ "&bugstatus="+$('#filter_bugstatus').val()+"&mode="+param);
	}
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
<script language="JavaScript" src="datetimepicker.js">
</script>
<title>Internal_pages</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/mystyle.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<!-- Save for Web Slices (Internal_pages.psd) -->
<table id="Table_01" width="1000" height="582" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<img src="images/Internal_pages_01.jpg" width="249" height="80" alt=""></td>
		<td width="751" height="80" background="images/Internal_pages_02.jpg">&nbsp;</td>
	</tr>
	<tr>
		<td height="27" colspan="2" background="images/Internal_pages_03.jpg" class="s11">Hi <?php echo $username;?> ! Welcome to Bug Sheet Upload Tool</td>
	</tr>
	<tr>
	  <td height="475" colspan="2" valign="top" style="background-image:url(images/Internal_pages_04.jpg); background-repeat: no-repeat; " class="table_align"><form name="tstest" action="./uploadsheet.php" onsubmit="return verify()" method="post" enctype="multipart/form-data">
	    <table width="51%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="20%" height="30" valign="middle" class="table_text">Project Name </td>
            <td height="30" colspan="2" valign="middle"><?php
    $query = "select DISTINCT projectname from projectmaster where projectmanager= '$username' or accountmanager= '$username' or buhead='$username' or practicehead='$username' or sepghead='$username' or sepglead='$username' or md='$username' or ceo = '$username' or fmfour='$username' or fmthree='$username' or fmtwo='$username' or fmone='$username' or lead='$username' or tester1='$username' or tester2='$username' or tester3='$username' or tester4='$username' or tester5='$username' or tester6='$username' or tester7='$username' or tester8='$username'or dev1='$username' or dev2='$username' or dev3='$username' or dev4='$username' or dev5='$username' or dev6='$username' or dev7='$username' or dev8='$username' or clientspoc='$username'";
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	//$m=$_REQUEST["project"];
	
	if($count==0)
		{
			die('Data Not Found');
		}

    echo "<select name=\"project\" id=\"project\" style=\"width:300px;\">"; 
    echo "<option size =30 selected>Select</option>";
    $pr=$_REQUEST["proj"];
	$ph=$_REQUEST["phase"];
    //$re=$_REQUEST["reviewer"];
	$bct=$_REQUEST["bugcat"];
	$module=$_REQUEST["module"];
	$topic=$_REQUEST["topic"];
	$screen=$_REQUEST["screen"];
	$bdr=$_REQUEST["bdr"];

	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    {
	 if(strlen($row[projectname])<>0)
		{
		 ?>
         <option<?php if($pr==$row[projectname])echo " selected";?>><?php echo $row[projectname];?></option> 
         <?php 
		}
	} 
 
    } 
    else {
    echo "<option>No Names Present</option>";  
    } 
    ?></td>
          </tr>
          <tr>
            <td valign="middle" class="table_text">Phase</td>
            <td height="30" colspan="2" valign="middle"><select name="phase" size="1" id="phase">
<option value="select" selected>Select</option>
<option value="Alpha" <?php if($ph=="Alpha") echo "selected";?>>Alpha</option>
<option value="Beta" <?php if($ph=="Beta") echo "selected";?>>Beta</option>
<option value="Gold" <?php if($ph=="Gold") echo "selected";?>>Gold</option>
</select></td>
          </tr>
          <tr>
            <td valign="middle" class="table_text">Bug Category </td>
            <td height="30" colspan="2" valign="middle"><select name="bcat" size="1" id="bcat">
<option value="select" selected>Select</option>
<option value="Editorial" <?php if($bct=="Editorial") echo "selected";?>>Editorial</option>
<option value="Media" <?php if($bct=="Media") echo "selected";?>>Media</option>
<option value="Functionality" <?php if($bct=="Functionality") echo "selected";?>>Functionality</option>
<option value="Audio" <?php if($bct=="Audio") echo "selected";?>>Audio</option>
<option value="Simulation" <?php if($bct=="Simulation") echo "selected";?>>Simulation</option>
<option value="Id" <?php if($bct=="Id") echo "selected";?>>ID</option>
</select></td>
          </tr>
          <tr>
            <td valign="middle" class="table_text">Module-Topic-Page</td>
            <td height="30" colspan="2" valign="middle"><input type=text maxlength=40 size=12 name="module" id="module" value="<?php echo $module;?>">-<input type=text maxlength=40 size=12 name="topic" id="topic" value="<?php echo $topic;?>">-<input type=text maxlength=40 size=12 name="pagenumber" id="pagenumber" value="<?php echo $screen;?>"></td>
          </tr>
          <tr>
            <td valign="middle" class="table_text">Bug Discription </td>
            <td colspan="2" valign="middle"><textarea name="bdr" rows="8" cols="35" id="bdr"><?php echo stripslashes($bdr);?></textarea></td>
          </tr>
          <tr>
            <td valign="middle" class="table_text">Select a file </td>
            <td width="34%" height="30" valign="middle"><input type="file" name="userfile" id="file"></td>
          </tr>
          <tr>
            <td valign="middle" class="table_text"></td>
            <td valign="middle" class="table_text">Only .doc, .docx, .xls, .xlsx, .jpg, .png, .gif of max-size 1MB</td>
          </tr>
          <tr>
            <td valign="middle">&nbsp;</td>
            <td colspan="2" valign="middle">
            <input type="hidden" value="<?php echo $username;?>" name="uname" id="uname">
			<input type="submit" value="Upload or Submit" class="button">
			<input type="button" value="Log Out" onclick="location.href='clientlogout.php';" class="button">
                        <input type="hidden" value="<?php echo $role;?>" name="role" id="role"> 
			</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td></td>
            <td >
                <table class="table_text">
                  <tr>
                      <td>Bug Category: <select name="filter_bcat" size="1" id="filter_bcat">
			<option value="All" selected>All</option>
			<option value="Editorial">Editorial</option>
			<option value="Media">Media</option>
			<option value="Functionality">Functionality</option>
			<option value="Audio">Audio</option>
			<option value="Simulation">Simulation</option>
			<option value="Id">ID</option>
			</select></td>
                      <td rowspan="2"><input type="button" value="Show All Fileinfo" onclick="showAll('display')" class="button"></td>
                  </tr>
                  <tr>
                      <td>Bug Status: <select id="filter_bugstatus" name="filter_bugstatus">
			    <option value="All">All</option>
			    <option value="hold">hold</option>
			    <option value="open">open</option>
			    <option value="closed">closed</option>
			    <option value="ok as is">ok as is</option>
			    <option value="reopened">reopened</option>
			    <option value="fixed">fixed</option>
			</select></td>
                  </tr>
                </table>
		 
            </td>
          </tr>
	</table>
			<?php
			echo "<input type ='hidden' name='user' value='$username'>";
			?>
        </form>
	  </td>
	</tr>
	<tr><td valign="middle" class="table_text"><div id="ResHint"></div></td></tr>
</table>
<!-- End Save for Web Slices -->
</body>
<table>
<tr>
<td valign="middle" class="table_text"><div id="txtHint"><?php $m=$_REQUEST["message"];if($m<>""){echo $m;}?></div></td>
</tr>
</table>
</html>