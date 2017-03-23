<html>
<head>
<?php	
	error_reporting(0);
	session_start();
	include('config.php');
	$user=$_SESSION['login'];
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
		header ("Location:index.php");
    }


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
<script src="js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#bcat').change(function(){
		var cat = $(this).val();
		$.get(
	    'getsubcat.php',
	    {cat:cat},
		function(data){
			var data = $.parseJSON(data);
			var str = '<option value="">Select Sub Category</option>';
			for(var i = 0; i < data.length; i++) {
				
				str += '<option value="'+data[i].id+'">'+data[i].category+'</option>'; 
			}
			$("#bscat").html(str);
		}
	  );
	});
	$("#bscat").change(function() {
		var subcat = $(this).val();
		$.get(
			'getsubcat.php',
			{subcat:subcat},
			function(data){
				$("#severity").val(data);
			}
		);
	});
});
function verify()
{
 var numericExpression = /^[0-9]+$/;
 var alphaExp = /^[a-zA-Z /s]*$/;
 var alphanumericExp = /^[0-9a-zA-Z._, /s]*$/;
 //var project = trim(document.getElementById('project').value);
 //var projectmanager = trim(document.getElementById('projectmanager').value);
 //var idfm = trim(document.getElementById('idfm').value);
 //var medfm = trim(document.getElementById('medfm').value);
 //var scrfm = trim(document.getElementById('scrfm').value);
 //var phase = trim(document.getElementById('phase').value);
 var module = trim(document.getElementById('module').value);
 var topic = trim(document.getElementById('topic').value);
 var screen = trim(document.getElementById('screen').value);
 var qc = trim(document.getElementById('qc').value);
 var severity = trim(document.getElementById('severity').value);
 var asignee = trim(document.getElementById('asignee').value);
 //var SDate = trim(document.getElementById('SDate').value);
 var browser = trim(document.getElementById('browser').value);
 //var coursestatus = trim(document.getElementById('coursestatus').value);
 var func = trim(document.getElementById('function').value);
 var bcat = trim(document.getElementById('bcat').value);
 var bscat = trim(document.getElementById('bscat').value);
 var bug = trim(document.getElementById('bdr').value);

/*if(project=="Select")
  {
  alert("Project must be selected");
  return false;
  }

if(projectmanager=="Select")
  {
  alert("Projectmanager must be selected");
  return false;
  }*/

/*if(idfm=="Select")
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
  }*/

/*if(phase=="select")
  {
  alert("Phase must be selected");
  return false;
  }*/

if(module=="")
  {
  alert("Module Name should be identified");
  return false;
  }
 
if(topic=="")
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
 
if(severity=="")
  {
  alert("Severity must be identified");
  return false;
  }

if(asignee=="select")
  {
  alert("Asignee must be identified");
  return false;
  }

/*if(SDate=="")
  {
  alert("Date on which received must be selected");
  return false;
  }*/
 
if(browser=="select")
  {
  alert("Browser should be identified");
  return false;
  }
 
if(func=="")
  {
	  alert("Function should be identified");
	  return false;
  }
  
if(bcat=="")
  {
  alert("Bug category should be identified");
  return false;
  }
  
  if(bscat=="")
  {
  alert("Bug Sub category should be identified");
  return false;
  }
  
  if(bug=="")
  {
  alert("Bug description should be given");
  return false;
  }

  
  /*if(!module.match(alphaExp))
  {
  alert("Module Name Should be Purely Alphabetic");
  return false;
  }
  
  if(!screen.match(alphanumericExp))
  {
  alert("Screen Details Should be Purely Alphanumeric");
  return false;
  }

  if(!bug.match(alphanumericExp))
  {
  alert("Please don't use special characters in description");
  return false;
  }*/
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
<form name="tstest" action="./editbug.php" onSubmit="return verify();" method="post" enctype="multipart/form-data">

<?php
$id=$_REQUEST['id'];
$equery="select * from qcuploadinfo where id='$id'";
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
	//$phase=$row['phase'];
    $module=$row['module'];
	$topic=$row['topic'];
	$screen=$row['screen'];
	$qc=$row['qc'];
	$severity=$row['severity'];
	$asignee=$row['asignee'];
	//$receivedate=$row['receivedate'];
	//$w=strtotime($receivedate);
    //$receivedate= date( 'd-M-Y', $w );
	$browser=$row['browser'];
	//$coursestatus=$row['coursestatus'];
	$function=$row['function'];
	$bcat=$row['bcat'];
	$bscat=$row['bscat'];
	$bug=$row['bdr'];
	//$username=$row['username'];
    } 	

echo "Bug ID  ".$id;
?>
<TABLE>

<!--<TR>
<TD>Phase</TD><TD><select name="phase" size="1" id="phase">
<option value="select" selected>Select</option>
<option value="alpha" <?php if($phase=="alpha")echo " selected";?>>Alpha</option>
<option value="beta" <?php if($phase=="beta")echo " selected";?>>Beta</option>
<option value="gold" <?php if($phase=="gold")echo " selected";?>>Gold</option>
</select></TD>
</TR>-->


<TR>
<TD>Module Name</TD>
<TD><input type=text size=42 name="module" id="module" value="<?php echo $module;?>"></TD>
</TR>

<TR>
<TD>Topic Name</TD>
<TD><input type=text size=42 name="topic" id="topic" value="<?php echo $topic;?>"></TD>
</TR>

<TR>
<TD>Screen Details</TD>
<TD><input type=text size=42 name="screen" id="screen" value="<?php echo $screen;?>"></TD>
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

<!--<TR>
<TD>Project Received On</TD>
<TD><input type="Text" id="SDate" value="<?php echo $receivedate;?>" maxlength="20" size="9" name="SDate" readonly="readonly">
<a href="javascript:NewCal('SDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>-->

<TR>
<TD>Bowser Used</TD>
<?php
	$query = "select browser from tbl_browsers order by browser";
    $retval = mysql_query( $query, $con );
?>
<TD><select name="browser" size="1" id="browser">
<option value="select">Select</option>
<?php while($row = mysql_fetch_assoc($retval)) { ?>
	<option value="<?php echo $row['browser']?>" <?php if($browser == $row['browser']) echo "selected"; ?>><?php echo $row['browser']?></option>
<?php } ?>	
</select></TD>
</TR>

<!--<TR>
<TD>Course Status</TD>
<TD><select name="coursestatus" size="1" id="coursestatus">
<option value="select">Select</option>
<option value="accepted" <?php if($coursestatus=="accepted")echo " selected";?>>Accepted</option>
<option value="rejected" <?php if($coursestatus=="rejected")echo " selected";?>>Rejected</option>
</select></TD>
</TR>-->

<TR>
<TD>Function</TD>
<TD>
	<select name="function" size="1" id="function">
		<option value="">Select</option>
		<option <?php if($function == "Media") echo "selected" ?> value="Media">Media</option>
		<option <?php if($function == "Functionality") echo "selected" ?> value="Functionality">Functionality</option>
		<option <?php if($function == "Editorial") echo "selected" ?> value="Editorial">Editorial</option>
	</select>
</TD>
</TR>
<TD>Bug Category</TD>
<TD>
	<?php $query = "select id, category from tbl_category where parent_id = 0"; 
		  $res = mysql_query( $query, $con );
	?>
	<select name="bcat" size="1" id="bcat">
		<option value="">Select Category</option>
		<?php 
			while($row = mysql_fetch_assoc($res)) 
			{
			?>
				<option <?php if($bcat==$row['id']) echo " selected";?> value="<?php echo $row['id']?>"><?php echo $row['category'];?></option> 
			<?php			
			}
		?>
	</select>
</TD>
</TR>
<TR>
<TD>Bug Sub Category</TD>
<TD>
	<?php if(isset($bcat)) {
			  $query = "select id, category from tbl_category where parent_id = $bcat"; 
			  $res = mysql_query( $query, $con );
		}
	?>
	<select name="bscat" size="1" id="bscat">
		<option value="">Select</option>
		<?php 
			while($row = mysql_fetch_assoc($res)) 
			{
			?>
				<option <?php if($bscat==$row['id']) echo "selected";?> value="<?php echo $row['id']?>"><?php echo $row['category'];?></option> 
			<?php			
			}
		?>
	</select>
</TD>
</TR>
<TR>
<TD>Severity</TD>
<TD>
<select name="severity" id="severity">
	<option value="">Select</option>
	<option value="High" <?php if($severity == "High") echo "selected"?>>High</option>
	<option value="Low" <?php if($severity == "Low") echo "selected"?>>Low</option>
	<option value="Medium" <?php if($severity == "Medium") echo "selected"?>>Medium</option>
	<option value="Suggestion" <?php if($severity == "Suggestion") echo "selected"?>>Suggestion</option>
</select>
</TD>
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