<?php	
	error_reporting(0);
	session_start();
	
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location:index.php");
    }
	
    $user=$_SESSION['login'];

    include('config.php');

    $query = "select username,dept from login where uniqueid='$user'";
    
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
	 echo "<h3>"."Hi ".$row['username']." ! Welcome To Task Creation Interface"."</h3>";
	 $username=$row['username'];
	 $dept=$row['dept'];
    } 	
    //echo "Dept :".$dept;
    

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
 $project=mysql_real_escape_string(trim($_POST["project"]));
 $developers=mysql_real_escape_string($_POST['developer']);
 $tasktype=trim($_POST["tasktype"]);
 $task=trim($_POST["task"]);
 $str=str_replace('\n',"&#10;",$task);
 $strfin=str_replace('\r'," ",$str);
 $strfin=mysql_real_escape_string(trim($strfin));
 $effort=mysql_real_escape_string($_POST['effort']);
 $user=mysql_real_escape_string($_POST['loggeduser']);
 $phase=mysql_real_escape_string($_POST['phase']);
 $mydate = date('Y-m-d h:i:s', time());
 
 $aquery="select * from projecttask where project='$project' AND task='$strfin'";
 $aqval = mysql_query( $aquery, $con );
 $count = mysql_num_rows($aqval);
 
 if($count==0)
 {
 $cquery="insert into  projecttask(project,developers,task,effort,user,timestamp,phase,type) values('".$project."','".$developers."','".$strfin."','".$effort."','".$user."','".$mydate."','".$phase."','".$tasktype."')";
 $message="Task created for :"." ".$project." ".$developers." ".stripslashes($strfin)." ".$effort."     Now it can be sent to QC for testing.";

 if (mysql_query($cquery))
       {
		header ("Location: createtask.php?message=".urlencode($message)."&project=".urlencode($project)."&task=".urlencode($task)."&effort=".urlencode($effort)."&phase=".urlencode($phase)."&devs=".urlencode($developers)."&tasktype=".urlencode($tasktype));
	   }
    else
       {
        die (mysql_error());
	   }
  }
 
 else
  {
   $message="This record already exists....";
   header ("Location: createtask.php?message=".urlencode($message)."&project=".urlencode($project)."&task=".urlencode($task)."&effort=".urlencode($effort)."&phase=".urlencode($phase)."&devs=".urlencode($developers)."&tasktype=".urlencode($tasktype));
  }
 }
?>
<html>
<head>
<script type="text/javascript">

function showStatus()
{
str=document.forms["tstest"]["project"].value;
auditee=document.forms["tstest"]["loggeduser"].value;

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
 }
}
str= encodeURIComponent(str);
xmlhttp.open("GET","getqcplans.php?q="+str+ "&r=" + auditee,true);
xmlhttp.send();
}

function unloadPage()
{
 //alert("unload event detected!");
 newwindow.close();
 //chwindow.close();
}

function qcplan(str)
{
    //alert (str);
	mywindow=window.open ("qcplan.php?id="+ str,"Ratting","scrollbars=1,width=220,height=200,0,status=0,");
	if (window.focus) {mywindow.focus()}
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
xmlhttp.open("GET","getalltasks.php?q="+str,true);
xmlhttp.send();
}

function verify()
{
 var decimalExpression = /^[0-9.]+$/;
 var project = trim(document.getElementById('project').value);
 var developer = trim(document.getElementById('developer').value);
 var task = trim(document.getElementById('task').value);
 var effort = trim(document.getElementById('effort').value);
 var phase = trim(document.getElementById('phase').value);
 var type = trim(document.getElementById('tasktype').value);

 if(project == "Select"){alert("Please select project"); return false;}
 if(developer == "select"){alert("Please mention developer details"); return false;}
 if(task == ""){alert("Please mention task name"); return false;}
 if(phase == "select"){alert("Please mention phase name"); return false;}
 if(effort == ""){alert("Please mention planned effort"); return false;}
 if(type == "select"){alert("Please mention tasktype"); return false;}

 if(!effort.match(decimalExpression))
  {
	alert("Effort Should be Purely Decimal");
	return false;
  }
}

function sendtoqc(mtr)
{
    //alert (str);
	mywindow=window.open ("testrequest.php?id="+mtr,"Ratting","scrollbars=1,width=470,height=500,0,status=0");
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
</head>
<body>
<?php
if($dept!="LMS")
	{
     die("This Link is Only For LMS Dept.");
    }
?>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" method="post" onsubmit="return verify()" action="createtask.php">
<?php
$message=$_REQUEST["message"];
$project=$_REQUEST["project"];
$task=$_REQUEST["task"];
$effort=$_REQUEST["effort"];
$phase=$_REQUEST["phase"];
$developers=$_REQUEST["devs"];
$tasktype=$_REQUEST["tasktype"];
?>
<TABLE>
<TR>
<TD>Project Name</TD>
<TD>
    <?php
	$query = "select DISTINCT projectname from projectmaster where projectmanager= '$username' or accountmanager= '$username' or buhead='$username' or practicehead='$username' or sepghead='$username' or sepglead='$username' or md='$username' or ceo = '$username' or fmfour='$username' or fmthree='$username' or fmtwo='$username' or fmone='$username' or lead='$username' or dev1='$username' or dev2='$username' or dev3='$username' or dev4='$username' or dev5='$username' or dev6='$username' or dev7='$username' or dev8='$username'";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Project Data Not Found; Contact SEPG');
		}

    echo "<select name=\"project\" id=\"project\">"; 
    echo "<option size =30 selected>Select</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    {
	?>	
    <option<?php if($project==$row[projectname])echo " selected";?>><?php echo $row[projectname];?></option> 
    <?php
	} 
    } 
    else 
	{
     echo "<option>No Names Present</option>";  
    } 
    ?>
    </TD>
</TR>

<TR>
<TD>Developer</TD>
<TD>
    <?php
	$query = "select DISTINCT username from login where role='DEV'order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}

    echo "<select name=\"developer\" id=\"developer\">"; 
    echo "<option size =30 selected value=\"select\">Select</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
    //echo "<option>$row[username]</option>";
	if(strlen($row[username])<>0)
		{
		 ?>
         <option<?php if($developers==$row[username])echo " selected";?>><?php echo $row[username];?></option> 
         <?php 
		}

    } 
    } 
    else 
	{
     echo "<option>No Names Present</option>";  
    } 
    ?>
</TD>
</TR>

<TR>
<TD>Work Packet</TD>
<TD><textarea name="task" rows="10" cols="40" id="task"><?php $str=str_replace('\n',"&#10;",$task); $strfin=str_replace('\r'," ",$str); echo $strfin;?></textarea></TD>
</TR>
<TR>
<TD></TD>
<TD><i>Use Only: Alphabet,Integer,Single Space and Period</i></TD>
</TR>

<TR>
<TD>Phase</TD><TD><select name="phase" size="1" id="phase">
<option value="select" selected>Select</option>
<option value="poc" <?php if($phase=="poc")echo " selected";?>>POC</option>
<option value="alpha" <?php if($phase=="alpha")echo " selected";?>>Alpha</option>
<option value="beta" <?php if($phase=="beta")echo " selected";?>>Beta</option>
<option value="gold" <?php if($phase=="gold")echo " selected";?>>Gold</option>
<option value="UAT Support" <?php if($phase=="UAT Support")echo " selected";?>>UAT Support</option>
</select></TD>
</TR>

<TR>
<TD>Planned Effort</TD>
<TD><input type="Text" id="effort" maxlength="5" size="5" name="effort" value="<?php echo $effort;?>">Hours</TD>
</TR>

<TR>
<TD>Type Of Task</TD><TD><select name="tasktype" size="1" id="tasktype">
<option value="select" selected>Select</option>
<option value="nontesting" <?php if($tasktype=="nontesting")echo " selected";?>>Non Testing</option>
<option value="testing" <?php if($tasktype=="testing")echo " selected";?>>Testing</option>
</select></TD>
</TR>

</TABLE>
<?php
echo "<input type ='hidden' name='loggeduser' value='$username'>";
?>
<input type="button" value="Log Out" onclick="location.href='logout.php';" class="button">
<input type="submit" value="Add Details" class="button">
<input type="button" value="Show All Work Packets" onclick="showAll()" class="button">
<input type="button" value="Show Status" onclick="showStatus()" class="button">
</form>
<br />
<div id="txtHint"></i><?php if($message<>"") {$str=str_replace('\n'," ",$message); $strfin=str_replace('\r'," ",$str); echo $strfin;} else{echo "Previous tasks will appear here.....";}?></i></div>
</body>
</html> 