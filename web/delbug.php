<html>
<head>
<?php	
	error_reporting(0);
	session_start();
	
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location:bugremove.php");
    }
	$user=$_SESSION['login'];
	include('config.php');

    $query = "select username from login where uniqueid='$user'";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found Please contact SEPG');
		}

    
    while($row = mysql_fetch_assoc($retval)) 
    { 
     echo "<h4>"."Hi ".$row['username']." ! Welcome To BUG Sheet Upload Tool"."</h4>";
	 $username=$row['username'];
	 if($username <> "Manoj Kumar")
		{
		 echo "You are not authorised to delete bugs";
		 exit();
		}
    } 	

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
   // Configuration - Your Options
   $allowed_filetypes = array('.doc','.docx','.xls','.xlsx'); // These will be the types of file that will pass the validation.
   $max_filesize = 1048576; // Maximum filesize in BYTES (currently 1MB).
   $upload_path = './qcfiles/'; // The place the files will be uploaded to (currently a 'files' directory).
   
   $a=mysql_real_escape_string($_POST["project"]);//project
   $sql="SELECT projectmanager,fmone,fmtwo,fmthree,fmfour FROM projectmaster WHERE projectname = '".$a."'";
   //echo $sql;
   $result = mysql_query($sql);
   $count = mysql_num_rows($result);

   if($count==0)
   {
    die('Data Not Found');
   }

   while($row = mysql_fetch_array($result))
   {
   $pm=$row['projectmanager']; 
   $fmone=$row['fmone'];
   $fmtwo=$row['fmtwo'];
   $fmthree=$row['fmthree'];
   $fmfour=$row['fmfour']; 
   }
   $b="PM :".$pm."| ID FM :".$fmone."|  Media FM :".$fmtwo."|  Scripting FM :".$fmthree."|  QC FM :".$fmfour;
   //$b=mysql_real_escape_string($_POST["fmHint"]);//fm details
   $f=mysql_real_escape_string($_POST["phase"]);//topic
   $g=mysql_real_escape_string($_POST["module"]);//screen
   $h=mysql_real_escape_string($_POST["topic"]);//qc
   $i= mysql_real_escape_string($_POST["SDate"]);//SData
   $w=strtotime($i);
   $x = date( 'Y-m-d', $w );
   $j=mysql_real_escape_string($_POST["browser"]);//module
   $k=mysql_real_escape_string($_POST["coursestatus"]);//topic
   $l=mysql_real_escape_string($_POST["bcat"]);//pagenumber
   $m=mysql_real_escape_string($_POST["bdr"]);//bug description
   $n=mysql_real_escape_string($_POST["asignee"]);//bug description
   $o=mysql_real_escape_string($_POST["qc"]);
   $p=mysql_real_escape_string($_POST["screen"]);
   $q=mysql_real_escape_string($_POST["severity"]);
   //$loggeduser=mysql_real_escape_string($_POST["user"]);
   $filename = $_FILES['userfile']['name']; // Get the name of the file (including file extension).

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
	$query="INSERT INTO qcuploadinfo(project,phase,module,topic,receivedate,browser,coursestatus,bcat,bdr,asignee,qc,screen,filepath,filename,uploaddate,severity,whenchangedstatus,whochangedstatus) values('".$a."','".$f."','".$g."','".$h."','".$x."','".$j."','".$k."','".$l."','".$m."','".$n."','".$o."','".$p."','".$str."','".$filename."','".$mydate."','".$q."','".$mydate."','".$username."')";

    //echo $query;
	if (mysql_query($query))
       {
		  //echo "Record created with id :".$row['id']." and description :".$w;
	      header ("Location: openbug2.php?message=".urlencode($msg)."&proj=".urlencode($a)."&fmdetails=".urlencode($b)."&phase=".urlencode($f)."&module=".urlencode($g)."&topic=".urlencode($h)."&receivedate=".urlencode($i)."&browser=".urlencode($j)."&coursestatus=".urlencode($k)."&bcat=".urlencode($l)."&bdr=".urlencode($m)."&asignee=".urlencode($n)."&qc=".urlencode($o)."&screen=".urlencode($p)."&severity=".urlencode($q));
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
//$date = date('m/d/Y h:i:s a', time());
	$mydate = date('Y-m-d h:i:s', time());     
$query="INSERT INTO qcuploadinfo(project,phase,module,topic,receivedate,browser,coursestatus,bcat,bdr,asignee,qc,screen,uploaddate,severity,whenchangedstatus,whochangedstatus) values('".$a."','".$f."','".$g."','".$h."','".$x."','".$j."','".$k."','".$l."','".$m."','".$n."','".$o."','".$p."','".$mydate."','".$q."','".$mydate."','".$username."')";
    //echo $query;
	if (mysql_query($query))
       {
		  //echo "Record created with id :".$row['id']." and description :".$w;
		  $msg="You haven't uploaded any file. You can click on Show All Fileinfo";
	      //header ("Location: openbug2.php?message=".urlencode($msg)."&proj=".urlencode($a)."&pm=".urlencode($b));
		  header ("Location: openbug2.php?message=".urlencode($msg)."&proj=".urlencode($a)."&fmdetails=".urlencode($b)."&phase=".urlencode($f)."&module=".urlencode($g)."&topic=".urlencode($h)."&receivedate=".urlencode($i)."&browser=".urlencode($j)."&coursestatus=".urlencode($k)."&bcat=".urlencode($l)."&bdr=".urlencode($m)."&asignee=".urlencode($n)."&qc=".urlencode($o)."&screen=".urlencode($p)."&severity=".urlencode($q));
	   }
    else
       {
        echo "Uploadinfo table couldn't be updated.";
		exit();
	   }
	}
}
?>
</head>
<body background="bg.gif">
<script type="text/javascript">

function editbug(mtr)
{
 alert(mtr);
//var ptr = document.getElementById(str).value;
//alert (ptr);

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
xmlhttp.open("GET","deletethebug.php?q="+mtr,true);
xmlhttp.send();
}


function submitresponse(str)
{
//alert (str);
 
var ptr = document.getElementById(str).value;
//alert (ptr);

if (ptr=="select")
{
 alert ("The status must be selected");
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
xmlhttp.open("GET","updatecoursestat.php?q="+str+ "&r=" + ptr,true);
xmlhttp.send();
}


function submitbugresponse(str)
{
//alert (str);
qtr = "bug".concat(str); 
var ptr = document.getElementById(qtr).value;
//alert (ptr);

var lutr = document.getElementById('luser').value;
//alert(lutr);

if (ptr=="select")
{
 alert ("The status must be selected");
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
xmlhttp.open("GET","updatebugstat.php?q="+str+ "&r=" + ptr+ "&s=" + lutr,true);
xmlhttp.send();
}


function verify()
{
 var numericExpression = /^[0-9]+$/;
 var alphaExp = /^[a-zA-Z /s]*$/;
 var alphanumericExp = /^[0-9a-zA-Z._, /s]*$/;
 var project = trim(document.getElementById('project').value);
 var projectmanager = trim(document.getElementById('projectmanager').value);
 var idfm = trim(document.getElementById('idfm').value);
 var medfm = trim(document.getElementById('medfm').value);
 var scrfm = trim(document.getElementById('scrfm').value);
 var phase = trim(document.getElementById('phase').value);
 var module = trim(document.getElementById('module').value);
 var topic = trim(document.getElementById('topic').value);
 var screen = trim(document.getElementById('screen').value);
 var qc = trim(document.getElementById('qc').value);
 var severity = trim(document.getElementById('severity').value);
 var asignee = trim(document.getElementById('asignee').value);
 var SDate = trim(document.getElementById('SDate').value);
 var browser = trim(document.getElementById('browser').value);
 var coursestatus = trim(document.getElementById('coursestatus').value);
 var bcat = trim(document.getElementById('bcat').value);
 var bug = trim(document.getElementById('bdr').value);

if(project=="Select")
  {
  alert("Project must be selected");
  return false;
  }

if(projectmanager=="Select")
  {
  alert("Projectmanager must be selected");
  return false;
  }

if(idfm=="Select")
  {
  alert("ID Functionalmanager must be selected");
  return false;
  }

if(medfm=="Select")
  {
  alert("Media Functionalmanager must be selected");
  return false;
  }

if(scrfm=="Select")
  {
  alert("Programing Functionalmanager must be selected");
  return false;
  }

if(phase=="select")
  {
  alert("Phase must be selected");
  return false;
  }

if(module=="")
  {
  alert("Module Name should be identified");
  return false;
  }
 
if(topic=="select")
  {
  alert("Topic should be identified");
  return false;
  }
  
if(screen=="")
  {
  alert("Screen no should be identified");
  return false;
  }
 
if(qc=="select")
  {
  alert("QC must be identified");
  return false;
  }
 
if(severity=="select")
  {
  alert("Severity must be identified");
  return false;
  }

if(asignee=="select")
  {
  alert("Asignee must be identified");
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
 
if(coursestatus=="select")
  {
  alert("Status should be specified");
  return false;
  }
  
if(bcat=="")
  {
  alert("Bug category should be identified");
  return false;
  }
  
  if(bug=="")
  {
  alert("Bug description should be given");
  return false;
  }

  
  if(!module.match(alphaExp))
  {
  alert("Module Name Should be Purely Alphabetic");
  return false;
  }
  
  if(!screen.match(numericExpression))
  {
  alert("Screen Number Should be Numeric");
  return false;
  }

  if(!bug.match(alphanumericExp))
  {
  alert("Please don't use special characters in description");
  return false;
  }
}

function showAll()
{
//newwindow.close();
str=document.forms["tstest"]["project"].value;
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
xmlhttp.open("GET","getqcfiledel.php?q="+str,true);
xmlhttp.send();
}

function getfm()
{
 str=document.forms["tstest"]["project"].value;
 //alert(str);
 
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
xmlhttp.open("GET","getfminfo.php?q="+str,true);
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
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" action="./openbug2.php" onsubmit="return verify()" method="post" enctype="multipart/form-data">
<TABLE>
<TR>
	<TD>Project Name</TD>
	<td>
    <?php
	$con = mysql_connect("localhost","root","password");

    if (!$con)
      {
        die('Could not connect: ' . mysql_error());
      }

	mysql_select_db("audit") or die(mysql_error());
    $query = "select DISTINCT projectname from projectmaster where projectmanager= '$username' or accountmanager= '$username' or buhead='$username' or practicehead='$username' or sepghead='$username' or sepglead='$username' or md='$username' or ceo = '$username' or fmfour='$username' or fmthree='$username' or fmtwo='$username' or fmone='$username' or lead='$username' or dev1='$username' or dev2='$username' or dev3='$username' or dev4='$username' or dev5='$username' or dev6='$username' or dev7='$username' or dev8='$username' or tester1='$username' or tester2='$username' or tester3='$username' or tester4='$username' or tester5='$username' or tester6='$username' or tester7='$username' or tester8='$username'";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	//$m=$_REQUEST["project"];
	
	if($count==0)
		{
			die('Data Not Found');
		}

    echo "<select name=\"project\" id=\"project\" onchange=\"getfm()\">"; 
    echo "<option size =30 selected>Select</option>";
    $proj=$_REQUEST["proj"];
	$fmdetails=$_REQUEST["fmdetails"];
	$phase=$_REQUEST["phase"];
	$module=$_REQUEST["module"];
	$topic=$_REQUEST["topic"];
    $receivedate=$_REQUEST["receivedate"];
	//$receivedate = date( 'dd-MMM-yy', strtotime($receivedate) );
	$browser=$_REQUEST["browser"];
	$coursestatus=$_REQUEST["coursestatus"];
	$bcat=$_REQUEST["bcat"];
	$bdr=$_REQUEST["bdr"];
	$asignee=$_REQUEST["asignee"];
	$qc=$_REQUEST["qc"];
	$screen=$_REQUEST["screen"];
	$severity=$_REQUEST["severity"];
	
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    {
	 if(strlen($row[projectname])<>0)
		{
		 ?>
         <option<?php if($proj==$row[projectname])echo " selected";?>><?php echo $row[projectname];?></option> 
         <?php 
		}
	} 
 
    } 
    else {
    echo "<option>No Names Present</option>";  
    } 
    ?>
    </td>
</TR>
</TABLE>
</br>
</br>

<input type="hidden" id="luser" value="<?php echo $username;?>">
<input type="button" value="Log Out" onclick="location.href='dellogout.php';">
<input type="button" value="Show All Fileinfo" onclick="showAll()">
<br>
<br>
<div id="ResHint"></div>
<div id="txtHint"><?php $m=$_REQUEST["message"]; $l=$_REQUEST["proj"];if($m<>""){echo $m;}?></div>
</form>
</body>
</html> 