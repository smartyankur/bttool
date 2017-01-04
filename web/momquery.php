<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?php
$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
?>
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

<body>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="ttest" action="submitai.php" onsubmit="return validateForm()" method="post">
  <?php
//echo "Hi";
//echo "<br>";
$meetingdate=$_REQUEST['param3'];
$project=$_REQUEST['param4'];
//echo "<br>";

$Mtime = strtotime($meetingdate);
$meetingdate = date( 'Y-m-d', $Mtime );

  echo "<b>"."Meetingdate :"."</b>".$meetingdate;
  echo "<br>";
  echo "<b>"."Project :"."</b>".$project;
  echo "<br>";

//echo "Hi    :".$q;

$sql="SELECT * FROM mommaster WHERE projectname = '".$project."' and meetingdate='".$meetingdate."'";
//echo $sql;

$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('Data Not Found');
}

echo "---------------------------------------------------------------------------------------------------------------------";

while($row = mysql_fetch_array($result))
  {
  echo "<br>";
  echo "Agenda :".$row['agenda']."</br>";
  echo "Participants :".$row['participants']."</br>";
  echo "Discussion Point :".$row['discussionpoint']."</br>";
  echo "Action Item :".$row['actionitem']."</br>";
  echo "Target Date :".$row['targetdate']."</br>";
  echo "Owner :".$row['owner']."</br>";
  echo "--------------------------------------------------------------------------------------------------------------------";
  }
mysql_close($con);
?>
</form>
</body>
</html>
