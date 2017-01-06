<html>
<head>
<?php	
	error_reporting(0);
	session_start();
	
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
		header ("Location:index.php");
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
    } 	
?>
</head>
<body background="bg.gif">
<script type="text/javascript">

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
<form name="tstest" action="./editbug4.php" onsubmit="return verify()" method="post" enctype="multipart/form-data">

<?php
$id=$_REQUEST['id'];
$equery="select * from qcuploadinfo1 where id='$id'";
$eresult = mysql_query( $equery, $con );
$count = mysql_num_rows($eresult);
	
if($count==0)
	{
	die('Data Not Found Please contact SEPG');
	}

 
    while($row = mysql_fetch_assoc($eresult)) 
    { 
     //echo "<h4>"."Hi ".$row['username']." ! Welcome To BUG Sheet Upload Tool"."</h4>";
    $project=$row['project'];
	$phase=$row['phase'];
    $module=$row['module'];
	$topic=$row['topic'];
	$screen=$row['screen'];
	$qc=$row['qc'];
	$severity=$row['severity'];
	$asignee=$row['asignee'];
	$receivedate=$row['receivedate'];
	$w=strtotime($receivedate);
    $receivedate= date( 'd-M-Y', $w );
	$browser=$row['browser'];
	$coursestatus=$row['coursestatus'];
	$bcat=$row['bcat'];
	$bug=$row['bdr'];
	//$username=$row['username'];
    } 	

echo "Bug ID  ".$id;
?>
<TABLE>

<TR>
<TD>Phase</TD><TD><select name="phase" size="1" id="phase">
<option value="select" selected>Select</option>
<option value="alpha" <?php if($phase=="alpha")echo " selected";?>>Alpha</option>
<option value="beta" <?php if($phase=="beta")echo " selected";?>>Beta</option>
<option value="gold" <?php if($phase=="gold")echo " selected";?>>Gold</option>
</select></TD>
</TR>


<TR>
<TD>Module Name</TD>
<TD><input type=text maxlength=42 size=42 name="module" id="module" value="<?php echo $module;?>"></TD>
</TR>

<TR>
<TD>Topic Name</TD>
<TD><input type=text maxlength=42 size=42 name="topic" id="topic" value="<?php echo $topic;?>"></TD>
</TR>

<TR>
<TD>Screen Details</TD>
<TD><input type=text maxlength=42 size=42 name="screen" id="screen" value="<?php echo $screen;?>"></TD>
</TR>

<TR>
<TD>Raised by</TD>
<TD>
    <?php
	$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}

    echo "<select name=\"qc\" id=\"qc\">"; 
    echo "<option size =30 selected value=\"select\">Select</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
    //echo "<option>$row[username]</option>";
	if(strlen($row[username])<>0)
		{
		 ?>
         <option<?php if($qc==$row[username])echo " selected";?>><?php echo $row[username];?></option> 
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
<TD>Severity</TD><TD><select name="severity" size="1" id="severity">
<option value="select" selected>Select</option>
<option value="High" <?php if($severity=="High")echo " selected";?>>High</option>
<option value="Medium" <?php if($severity=="Medium")echo " selected";?>>Medium</option>
<option value="Low" <?php if($severity=="Low")echo " selected";?>>Low</option>
</select></TD>
</TR>


<TR>
<TD>Assignee</TD>
<TD>
    <?php
	$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}

    echo "<select name=\"asignee\" id=\"asignee\">"; 
    echo "<option size =30 selected value=\"select\">Select</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
     //echo "<option>$row[username]</option>";
	 if(strlen($row[username])<>0)
		{
		 ?>
         <option<?php if($asignee==$row[username])echo " selected";?>><?php echo $row[username];?></option> 
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
<TD>Project Received On</TD>
<TD><input type="Text" id="SDate" value="<?php echo $receivedate;?>" maxlength="20" size="9" name="SDate" readonly="readonly">
<a href="javascript:NewCal('SDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>

<TR>
<TD>Bowser Used</TD>
<TD><select name="browser" size="1" id="browser">
<option value="select" selected>Select</option>
<option value="IE6" <?php if($browser=="IE6")echo " selected";?>>IE6</option>
<option value="IE7" <?php if($browser=="IE7")echo " selected";?>>IE7</option>
<option value="IE8" <?php if($browser=="IE8")echo " selected";?>>IE8</option>
<option value="IE9" <?php if($browser=="IE9")echo " selected";?>>IE9</option>
<option value="Chrome" <?php if($browser=="Chrome")echo " selected";?>>Chrome</option>
<option value="FireFox" <?php if($browser=="FireFox")echo " selected";?>>Mozilla FireFox</option>
<option value="Ipad2" <?php if($browser=="Ipad2")echo " selected";?>>Ipad2</option>
<option value="Ipad3" <?php if($browser=="Ipad3")echo " selected";?>>Ipad3</option>
<option value="Android Phone" <?php if($browser=="Android Phone")echo " selected";?>>Android Phone</option>
<option value="Android Tablet" <?php if($browser=="Android Tablet")echo " selected";?>>Android Tablet</option>
<option value="Safari" <?php if($browser=="Safari")echo " selected";?>>Safari</option>
<option value="IPhone" <?php if($browser=="IPhone")echo " selected";?>>IPhone</option>
</select></TD>
</TR>

<TR>
<TD>Course Status</TD>
<TD><select name="coursestatus" size="1" id="coursestatus">
<option value="select">Select</option>
<option value="accepted" <?php if($coursestatus=="accepted")echo " selected";?>>Accepted</option>
<option value="rejected" <?php if($coursestatus=="rejected")echo " selected";?>>Rejected</option>
</select></TD>
</TR>

<TR>
<TD>Bug Category</TD><TD><select name="bcat" size="1" id="bcat">
<option value="select" selected>Select</option>
<option value="editorial" <?php if($bcat=="editorial")echo " selected";?>>Editorial</option>
<option value="media" <?php if($bcat=="media")echo " selected";?>>Media</option>
<option value="functionality" <?php if($bcat=="functionality")echo " selected";?>>Functionality</option>
<option value="audio" <?php if($bcat=="audio")echo " selected";?>>Audio</option>
<option value="simulation" <?php if($bcat=="simulation")echo " selected";?>>Simulation</option>
<option value="suggesstion" <?php if($bcat=="suggesstion")echo " selected";?>>Suggesstion</option>
</select></TD>
</TR>

<TR>
<TD>Bug Description</TD>
<TD><textarea name="bdr" rows="4" cols="30" id="bdr"><?php echo $bug;?></textarea></TD>
</TR>

<TR>
<TD>Select a file:</TD><TD><input type="file" name="userfile" id="file"> </TD>
</TR>

</TABLE>
<input type="hidden" name="id" value="<?php echo $id;?>">
<input type="hidden" name="project" value="<?php echo $project;?>">
<input type="submit" value="Upload or Submit">
<br>
<br>
<div id="ResHint"></div>
<div id="txtHint"><?php $m=$_REQUEST["message"]; $l=$_REQUEST["proj"];if($m<>""){echo $m;}?></div>
</form>
</body>
</html> 