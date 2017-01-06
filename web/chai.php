<?PHP
error_reporting(0);
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
    $actionitem = $_POST['actionitem'];
    $owner = $_POST['owner'];
    $TDate = $_POST['TDate'];
	$discussionpoint = $_POST['discussionpoint'];
	$participants = $_POST['participants'];
    $momid=$_POST['param'];
    
	$actionitem= mysql_real_escape_string($actionitem);
    $owner= mysql_real_escape_string($owner);
	$discussionpoint= mysql_real_escape_string($discussionpoint);
	$participant= mysql_real_escape_string($participant);
	//$query = "select username from login where uniqueid='$str'";

	$Ttime = strtotime($TDate);
    $TDate = date( 'Y-m-d', $Ttime );
	
	$query = "update mommaster set actionitem='".$actionitem."',owner='".$owner."',targetdate='".$TDate."',participants='".$participants."',discussionpoint='".$discussionpoint."' where momid='".$momid."'";  
    $result=mysql_query($query) or die (mysql_error());
	$message="Row Edited With The Values You Provided (Check Below)";
	$again="If you want to again modify; you can do so, the same way";
    echo "<b>"."<u>".$message."</u>"."</b>"."</br>";
?>
<font face="verdana" size="2" color="red"><?php echo $again;?></font>
<?php
	}
?>
<html>
<head>
<title> Edit MoM Record </title>
<script>
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

function validateForm() {

var x= trim(document.forms["ttest"]["actionitem"].value);
var y= trim(document.forms["ttest"]["owner"].value);
var e= trim(document.forms["ttest"]["TDate"].value);
var f= trim(document.forms["ttest"]["dp"].value);
var g= trim(document.forms["ttest"]["participant"].value);


if (g=="")
  {
  alert("Participant details must be filled");
  document.forms["ttest"]["participant"].focus();
  return false;
  }

if (f=="")
  {
  alert("Discussion point must be filled");
  document.forms["ttest"]["dp"].focus();
  return false;
  }

if (x=="")
  {
  alert("Action Item must be filled");
  document.forms["ttest"]["actionitem"].focus();
  return false;
  }

if (y=="")
  {
  alert("Owner must be filled");
  document.forms["ttest"]["owner"].focus();
  return false;
  }

if (e=="")
  {
  alert("Target Date must be filled");
  document.forms["ttest"]["TDate"].focus();
  return false;
  }


}
</script>
</head>

<body background="bg.gif">
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="ttest" action="chai.php" onsubmit="return validateForm()" method="post">
<?php
$momid=$_REQUEST['param'];
$query = "select * from mommaster where momid='$momid'";
$retval = mysql_query( $query, $con );
$count = mysql_num_rows($retval);
	
if($count==0)
{
 die('No MOM record found');
}

if($row = mysql_fetch_array($retval))
{
 $agenda=$row['agenda']; 
 $participants=$row['participants'];
 $discussionpoint=$row['discussionpoint'];
 $actionitem=$row['actionitem'];
 $meetingdate=$row['meetingdate'];
 $targetdate=$row['targetdate'];
 $owner=$row['owner'];
 $status=$row['status'];
 $risk= $row['risk'];
 $type= $row['type'];
 }
else
{
 die('Something Wrong With Your Data. Please Contact SEPG');
}

//echo "<br>";
  echo "<b>"."Agenda :"."</b>".$agenda;
  echo "<br>";
  echo "<b>"."Participant :"."</b>".$participants;
  echo "<br>";
  echo "<b>"."Discussionpoint :"."</b>".$discussionpoint;
  echo "<br>";
  echo "<b>"."Actionitem :"."</b>".$actionitem;
  echo "<br>";
  echo "<b>"."Meetingdate :"."</b>".$meetingdate;
  echo "<br>";
  echo "<b>"."Targetdate :"."</b>".$targetdate;
  echo "<br>";
  echo "<b>"."Owner :"."</b>".$owner;
  echo "<br>";
  echo "<b>"."Status :"."</b>".$status;
  echo "<br>";
  echo "<b>"."Risk :"."</b>".$risk;
  echo "<br>";
  echo "<b>"."Meetingtype :"."</b>".$type;
  echo "<br>";
?>
</br>

<Table>

<TR>
<TD>Participants*</TD>
<TD><textarea name="participants" rows="4" cols="30" id="participants"><?php echo $participants; ?></textarea></TD>
</TR>

<TR>
<TD>Discussion Point*</TD>
<TD><textarea name="discussionpoint" rows="4" cols="30" id="discussionpoint"><?php echo $discussionpoint; ?></textarea></TD>
</TR>

<TR>
<TD>Action Item*</TD>
<TD><textarea name="actionitem" rows="4" cols="30" id="actionitem"><?php echo $actionitem; ?></textarea></TD>
</TR>

<TR>
<TD>Owner/Owners*</TD>
<TD><textarea name="owner" rows="4" cols="30" id="owner"><?php echo $owner; ?></textarea></TD>
</TR>

<TR>
<TD>Target Closure Date*</TD>
<TD><input type="Text" readonly="readonly" id="TDate" value="<?php echo $targetdate;  ?>" maxlength="20" size="9" name="TDate">
<a href="javascript:NewCal('TDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>
</Table>

<?php
echo "<input type ='hidden' name='param' value='$momid'>";
?>
<br>
<input type="submit" />
</form>
</body>
</html>
