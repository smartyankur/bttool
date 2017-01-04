<html>
<head>
<?php	
	error_reporting(0);
	session_start();
	
  if(!(isset($_SESSION['login']) && $_SESSION['login'] != '')){
    header ("Location:index.php");
  }
  $user = $_SESSION['login'];
	
  include("config.php");
  
  $query  = "select username from login where uniqueid='$user'";
  $retval = mysql_query($query, $con);
  $count  = mysql_num_rows($retval);
	
  if($count==0){
    die('Data Not Found Please contact SEPG');
  }

  while($row = mysql_fetch_assoc($retval)){ 
    echo "</br>";
    echo "</br>";
    echo "</br>";
    echo "<h4>" . "Hi " . $row['username'] . " ! Welcome to Functional Review Interface" . "</h4>";
    $username = $row['username'];
  } 	

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $reviewer    = $_POST["reviewer"];
  $project     = $_POST["project"];
  $module      = addslashes($_POST["module"]);
  $submodule   = addslashes($_POST["submodule"]);
  $build       = $_POST["build"];
  $type        = $_POST["type"];
  $priority    = $_POST["priority"];
  $severity    = $_POST["severity"];
  $btype       = $_POST["btype"];
  $reqid       = $_POST["reqid"];
  $dev         = $_POST["dev"];
  $bdr         = mysql_real_escape_string($_POST["bdr"]);
  $b           = $_POST["container"];
  $currentdate = date('Y-m-d H:i:s', time());
 
 $rquery = "select * from lmsblob where project='$project' AND module='".stripslashes($module)."' AND submodule='".stripslashes($submodule)."' AND build='$build' AND type='$type' AND priority='$priority' AND severity='$severity' AND btype='$btype' AND reqid='$reqid' AND bdr='$bdr' AND dev='$dev'";
 $cret = mysql_query($rquery, $con);
 $count = mysql_num_rows($cret);

 if($count>0){
  echo("This entry already exists");
  exit();
 }

 $query="INSERT INTO lmsblob(reviewer, project, module, submodule, build, type, priority, grab, btype, reqid, bdr, entrydate, severity,dev) values('".$reviewer."','".$project."','".$module."','".$submodule."','".$build."','".$type."','".$priority."','".$b."','".$btype."','".$reqid."','".$bdr."','".$currentdate."','".$severity."','".$dev."')";

  if (mysql_query($query)){
		$message="Record has been created for project ".$project." and "."module : ".stripslashes($module).", please click on the Show All Fileinfo to read the entry.";
		header ("Location: lmsbt.php?project=".urlencode($project)."&module=".urlencode(stripslashes($module))."&submodule=".urlencode(stripslashes($submodule))."&build=".urlencode($build)."&type=".urlencode($type)."&priority=".urlencode($priority)."&btype=".urlencode($btype)."&reqid=".urlencode($reqid)."&bdr=".urlencode($bdr)."&severity=".urlencode($severity)."&dev=".urlencode($dev)."&message=".urlencode($message));
  }else{
    echo "Row Not Created";
    die(mysql_error());
  }	
}

?>
<style>
div.ex{
  height:350px;
  width:600px;
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
<script>

function test(){
  var decimalExpression = /^[0-9. ]+$/;
  var project = trim(document.getElementById('project').value);
  if(project=="Select"){alert("Please select project"); return false;};
  
  var reqid = trim(document.getElementById('reqid').value);
  if(reqid=="Select"){alert("Please select request id"); return false;}; 
  
  var module = trim(document.getElementById('module').value);
  if(module=="Select"){alert("Please select module"); return false;};
  
  var submodule = trim(document.getElementById('submodule').value);
  if(submodule==""){alert("Please specify submodule"); return false;}; 
  
  var build = trim(document.getElementById('build').value);
  if(build==""){alert("Please select build"); return false;};
  
  if(!build.match(decimalExpression)){
    alert("Build should be in proper format");
    return false;
  } 
  
  var type = trim(document.getElementById('type').value);
  if(type=="Select"){alert("Please select Issue type"); return false;};
  
  var priority = trim(document.getElementById('priority').value);
  if(priority=="Select"){alert("Please enetr the priority"); return false;};
  
  var severity = trim(document.getElementById('severity').value);
  if(severity=="Select"){alert("Please enetr the severity"); return false;};
  
  var btype = trim(document.getElementById('btype').value);
  if(btype=="Select"){alert("Please select product or custom type"); return false;};
  
  var dev = trim(document.getElementById('dev').value);
  if(dev=="Select"){alert("Please select developer"); return false;};
  
  var bdr = trim(document.getElementById('bdr').value);
  if(bdr==""){alert("Please give description."); return false;};
  
  var nt = document.getElementById('grab').innerHTML;
  document.forms["tstest"].container.value += nt;
  document.forms["tstest"].submit();
}

function showAll(){
  var project = trim(document.getElementById('project').value);
  var requestId = trim(document.getElementById('reqid').value);

  if(project=="Select"){
    alert("Project name must be selected!");
    return false;
  }else{
    window.location.href="lmsgetrevinfo.php?q=" + project + "&requestId=" + requestId;  
  }
}


function trim(s){
	return rtrim(ltrim(s));
}

function ltrim(s){
	var l=0;
	while(l < s.length && s[l] == ' ')
	{	l++; }
	return s.substring(l, s.length);
}

function rtrim(s){
	var r=s.length -1;
	while(r > 0 && s[r] == ' ')
	{	r-=1;	}
	return s.substring(0, r+1);
}

function loadReqId(projectName, projectId){
  self.location='lmsbt.php?project=' + projectName;  
}

</script>
</head>

<body background="bg.gif">
<?php
  $project   = $_GET["project"];      
  $reqid     = $_REQUEST["reqid"];      
  $module    = $_REQUEST["module"];
  $submodule = $_REQUEST["submodule"];
  $build     = $_REQUEST["build"];
  $typo      = $_REQUEST["type"];
  $priority  = $_REQUEST["priority"];
  $btype     = $_REQUEST["btype"];
  $bdr       = $_REQUEST["bdr"];
  $severity  = $_REQUEST["severity"];
  $dev       = $_REQUEST["dev"];
  $message   = $_REQUEST["message"]; 
?>
<form name="tstest" action="./lmsbt.php" onsubmit="return verify()" method="post" enctype="multipart/form-data">
<TABLE>
<TR>
	<TD>Project Name</TD>
	<td>
    <?php
      $query = "select DISTINCT project from projecttask where status='accepted'";
      $retval = mysql_query( $query, $con );
      $count = mysql_num_rows($retval);
		
      if($count==0){
        die('Data Not Found');
      }

      echo "<select name=\"project\" id=\"project\">"; 
      echo "<option size =30 selected>Select</option>";
      
      if(mysql_num_rows($retval)){ 
        while($row = mysql_fetch_assoc($retval)){
          if(strlen($row['project'])<>0){
          ?>
            <option<?php if($project==$row['project'])echo " selected";?> onClick="loadReqId('<?php echo $row['project']; ?>')"><?php echo $row['project'];?></option> 
          <?php 
          }
        } 
      }else{
        echo "<option>No Names Present</option>";  
      } 
    ?>
    </td>
</TR>
<TR>
  <TD>Request ID</TD>
  <TD>
    <?php
      if( isset($_GET['project']) && !empty($_GET['project']) ){      
        $selectProject = "SELECT GROUP_CONCAT( DISTINCT `id` ORDER BY `id` DESC SEPARATOR ',' ) AS projectIds FROM projecttask WHERE project = '".$_GET['project']."' and status = 'accepted'";
        $queryProject = mysql_query($selectProject, $con);
        $numrowsProject = mysql_num_rows($queryProject);
        if($numrowsProject != 0){
          $fetchProject = mysql_fetch_array($queryProject);            
        
          $query = "select indx from qcreq where id IN (".$fetchProject['projectIds'].") and status='accepted' order by indx ASC";          
        }else{
          $query = "select indx from qcreq where status='accepted' order by indx ASC";      
        }        
      }else{
        $query = "select indx from qcreq where status='accepted' order by indx ASC";      
      }
      $retval = mysql_query( $query, $con );
      $count = mysql_num_rows($retval);
	
      if($count==0){
        die('IDs Not Found; Contact SEPG');
      }

      echo "<select name=\"reqid\" id=\"reqid\">"; 
      echo "<option size =30 selected value=\"Select\">Select</option>";
    
      if(mysql_num_rows($retval)){ 
        while($row = mysql_fetch_assoc($retval)){ 
          //echo "<option>$row[username]</option>";
          if(strlen($row['indx'])<>0){
        ?>
          <option <?php if($reqid==$row['indx'])echo " selected";?>><?php echo $row['indx'];?></option> 
        <?php 
          }
        } 
      }else{
        echo "<option>No Requests Present</option>";  
      } 
    ?>
  </TD>
</TR>

<TR>
  <TD>Module</TD>
  <TD>
    <select name="module" size="1" id="module" onchange="filloption(this.value)">
      <option value="Select" selected>Select</option>
      <option value="Not Applicable" <?php if($module=="Not Applicable")echo " selected";?>>Not Applicable</option>
      <option value="User Account Management" <?php if($module=="User Account Management")echo " selected";?>>User Account Management</option>
      <option value="Role Management" <?php if($module=="Role Management")echo " selected";?>>Role Management</option>
      <option value="Group Management" <?php if($module=="Group Management")echo " selected";?>>Group Management</option>
      <option value="Job Role Management" <?php if($module=="Job Role Management")echo " selected";?>>Job Role Management</option>
      <option value="Skill Management" <?php if($module=="Skill Management")echo " selected";?>>Skill Management</option>
      <option value="Location Management" <?php if($module=="Location Management")echo " selected";?>>Location Management</option>
      <option value="Zone Management" <?php if($module=="Zone Management")echo " selected";?>>Zone Management</option>
      <option value="Client Management" <?php if($module=="Client Management")echo " selected";?>>Client Management</option>
      <option value="Logged In Users" <?php if($module=="Logged In Users")echo " selected";?>>Logged In Users</option>
      <option value="Knowledge Asset Management" <?php if($module=="Knowledge Asset Management")echo " selected";?>>Knowledge Asset Management</option>
      <option value="Content Management" <?php if($module=="Content Management")echo " selected";?>>Content Management</option>
      <option value="Learning Plan Management" <?php if($module=="Learning Plan Management")echo " selected";?>>Learning Plan Management</option>
      <option value="Course Management" <?php if($module=="Course Management")echo " selected";?>>Course Management</option>
      <option value="Classroom Training Management" <?php if($module=="Classroom Training Management")echo " selected";?>>Classroom Training Management</option>
      <option value="Catalog Management" <?php if($module=="Catalog Management")echo " selected";?>>Catalog Management</option>
      <option value="Certificate Background Management" <?php if($module=="Certificate Background Management")echo " selected";?>>Certificate Background Management</option>
      <option value="Pending Learning Request" <?php if($module=="Pending Learning Request")echo " selected";?>>Pending Learning Request</option>
      <option value="System" <?php if($module=="System")echo " selected";?>>System</option>
      <option value="Reports" <?php if($module=="Reports")echo " selected";?>>Reports</option>
      <option value="Collaboration Item Management" <?php if($module=="Collaboration Item Management")echo " selected";?>>Collaboration Item Management</option>
      <option value="Discussion Forum" <?php if($module=="Discussion Forum")echo " selected";?>>Discussion Forum</option>
      <option value="Survey Management" <?php if($module=="Survey Management")echo " selected";?>>Survey Management</option>
      <option value="Announcement Management" <?php if($module=="Announcement Management")echo " selected";?>>Announcement Management</option>
      <option value="FAQ Management" <?php if($module=="FAQ Management")echo " selected";?>>FAQ Management</option>
      <option value="Blog Management" <?php if($module=="Blog Management")echo " selected";?>>Blog Management</option>
      <option value="Wiki Management" <?php if($module=="Wiki Management")echo " selected";?>>Wiki Management</option>
      <option value="Learner's Dashboard" <?php if($module=="Learner's Dashboard")echo " selected";?>>Learner's Dashboard</option>
      <option value="Mentor's Dashboard" <?php if($module=="Mentor's Dashboard")echo " selected";?>>Mentor's Dashboard</option>
      <option value="Non LMS Module" <?php if($module=="Non LMS Module")echo " selected";?>>Non LMS Module</option>
    </select>
  </TD>
</TR>

<TR>
<TD>Module Subsection</TD>
<TD><input type=text maxlength=100 size=30 name="submodule" id="submodule" value="<?php echo $submodule;?>"></TD>
</TR>

<TR>
<TD>Build Version</TD>
<TD><input type=text maxlength=10 size=10 name="build" id="build" value="<?php echo $build;?>"></TD>
</TR>

<TR>
<TD>Issue Type</TD><TD><select name="type" size="1" id="type">
<option value="Select" selected>Select</option>
<option value="functional" <?php if($typo=="functional")echo " selected";?>>Functional</option>
<option value="userinterface" <?php if($typo=="userinterface")echo " selected";?>>User Interface</option>
<option value="validation" <?php if($typo=="validation")echo " selected";?>>Validation</option>
<option value="performance" <?php if($typo=="performance")echo " selected";?>>Performance</option>
<option value="security" <?php if($typo=="security")echo " selected";?>>Security</option>
<option value="suggestion" <?php if($typo=="suggestion")echo " selected";?>>Suggestion</option>
<option value="crash" <?php if($typo=="crash")echo " selected";?>>Crash</option>
<option value="doubt" <?php if($typo=="doubt")echo " selected";?>>Doubt</option>
</select></TD>
</TR>

<TR>
<TD>Priority</TD><TD><select name="priority" size="1" id="priority">
<option value="Select" selected>Select</option>
<option value="high" <?php if($priority=="high")echo " selected";?>>High</option>
<option value="medium" <?php if($priority=="medium")echo " selected";?>>Medium</option>
<option value="low" <?php if($priority=="low")echo " selected";?>>Low</option>
<option value="none" <?php if($priority=="none")echo " selected";?>>None</option>
</select></TD>
</TR>

<TR>
<TD>Severity</TD><TD><select name="severity" size="1" id="severity">
<option value="Select" selected>Select</option>
<option value="high" <?php if($severity=="high")echo " selected";?>>High</option>
<option value="medium" <?php if($severity=="medium")echo " selected";?>>Medium</option>
<option value="low" <?php if($severity=="low")echo " selected";?>>Low</option>
<option value="none" <?php if($severity=="none")echo " selected";?>>None</option>
</select></TD>
</TR>

<TR>
<TD>Product or Custom</TD><TD><select name="btype" size="1" id="btype">
<option value="Select" selected>Select</option>
<option value="product" <?php if($btype=="product")echo " selected";?>>Product Level</option>
<option value="customization" <?php if($btype=="customization")echo " selected";?>>Customization Level</option>
</select></TD>
</TR>

<TR>
<TD>Developer</TD>
<TD>
    <?php
	$query = "select username from login where role='DEV' and dept='LMS'";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('IDs Not Found; Contact SEPG');
		}

    echo "<select name=\"dev\" id=\"dev\">"; 
    echo "<option size =30 selected value=\"Select\">Select</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
     //echo "<option>$row[username]</option>";
	 if(strlen($row['username'])<>0)
		{
		 ?>
         <option <?php if($dev==$row['username'])echo " selected";?>><?php echo $row['username'];?></option> 
         <?php 
		}
    } 
    } 
    else 
	{
     echo "<option>No Requests Present</option>";  
    } 
    ?>
    </TD>
</TR>

<TR>
<TD>Bug Description</TD>
<TD><textarea name="bdr" rows="4" cols="30" id="bdr"><?php echo stripslashes($bdr);?></textarea></TD>
</TR>

<textarea class="hide" name="container" rows="2" cols="20"></textarea>

<TR>
<TD>Screen Grab</TD>
<TD><div style="border:1px solid black" class="ex" contenteditable="true" id="grab" name="grab">Paste Image Here if any.Clean All These Text if pasting image...</p>
</TD>
</TR>

</TABLE>
<br>
<input type="button" class="button" value="Submit" onclick="test();">
<input type="button" class="button" value="Log Out" onclick="location.href='logout.php';">
<input type="button" class="button" value="Show All Fileinfo" onclick="showAll()">
<input type="hidden" id="luser" name="reviewer" value="<?php echo $username;?>">
</form>
<br>
<br>
<div id="ResHint"></div>
<div id="txtHint"><?php if($message<>""){echo $message;}?></div>
</body>
</html> 