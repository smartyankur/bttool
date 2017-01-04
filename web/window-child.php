<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title> New Document </title>
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
<form name="ttest" action="submitai.php" onsubmit="return validateForm()" method="post">
  <?php
//echo "Hi";
//echo "<br>";
$agenda=$_REQUEST['param1'];
$participant=$_REQUEST['param2'];
$meetingdate=$_REQUEST['param3'];
$project=$_REQUEST['param4'];
$discussionpoint=$_REQUEST['param5'];
$loggeduser=$_REQUEST['param6'];
$type=$_REQUEST['param7'];
//echo "<br>";

$agenda=stripslashes($agenda);
$participant=stripslashes($participant);
$discussionpoint=stripslashes($discussionpoint);

  echo "<b>"."Agenda :"."</b>".$agenda;
  echo "<br>";
  echo "<b>"."Participant :"."</b>".$participant;
  echo "<br>";
  echo "<b>"."Meetingdate :"."</b>".$meetingdate;
  echo "<br>";
  echo "<b>"."Project :"."</b>".$project;
  echo "<br>";
  echo "<b>"."Discussionpoint :"."</b>".$discussionpoint;
  echo "<br>";
  echo "<b>"."Loggeduser :"."</b>".$loggeduser;
  echo "<br>";
  echo "<b>"."Meeting Type :"."</b>".$type; 
  echo "<br>";
//echo $_REQUEST['param3'];
?>
</br>
<table>
<TR>
<TD>Action Item*</TD>
<TD><textarea name="actionitem" rows="4" cols="30" id="actionitem">No action Items</textarea></TD>
</TR>

<TR>
<TD>Owner/Owners*</TD>
<TD><textarea name="owner" rows="4" cols="30" id="owner">No owners</textarea></TD>
</TR>

<TR>
<TD>Risk or Dependency or Obstacle*</TD>
<TD><textarea name="risk" rows="4" cols="30" id="risk">There are no Risks</textarea></TD>
</TR>

<TR>
<TD>Status*</TD>
<TD><select name="status" size="1">
<option value="open">open</option>
<option value="close">close</option>
<option value="wip">work in progress</option>
</select></TD>
</TR>

<TR>
<b>PLEASE NOTE   :</b>If not sure about the Target Closure Date, let the default value 1970-01-01 remain as it is. 
</TR>

<TR>
<TD>Target Closure Date*</TD>
<TD><input type="Text" readonly="readonly" id="TDate" value="1970-01-01" maxlength="20" size="9" name="TDate">
<a href="javascript:NewCal('TDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>
</table>
<?php
echo "<input type ='hidden' name='param1' value='$agenda'>";
echo "<input type ='hidden' name='param2' value='$participant'>";
echo "<input type ='hidden' name='param3' value='$meetingdate'>";
echo "<input type ='hidden' name='param4' value='$project'>";
echo "<input type ='hidden' name='param5' value='$discussionpoint'>";
echo "<input type ='hidden' name='param6' value='$loggeduser'>";
echo "<input type ='hidden' name='param7' value='$type'>";
?>
<br>
<input type="submit" />
</form>
</body>
</html>
