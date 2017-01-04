<?php
$con = mysql_connect("localhost","root","password");

if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

$actionitem = $_POST['actionitem'];
$owner = $_POST['owner'];
$TDate = $_POST['TDate'];
$agenda = $_POST['param1'];
$participant = $_POST['param2'];
$meetingdate = $_POST['param3'];
$project = $_POST['param4'];
$discussionpoint=$_POST['param5'];
$loggeduser=$_POST['param6'];
$type=$_POST['param7'];

//header("Location: window-child.php?param1=".$agenda."&&param2=".$participant."&&param3=".$meetingdate."&&param4=".$project);

$actionitem= mysql_real_escape_string($actionitem);
$owner= mysql_real_escape_string($owner);
$TDate= mysql_real_escape_string($TDate);
$agenda= mysql_real_escape_string($agenda);
$participant= mysql_real_escape_string($participant);
$meetingdate= mysql_real_escape_string($meetingdate);
$project= mysql_real_escape_string($project);
$discussionpoint= mysql_real_escape_string($discussionpoint);
$loggeduser= mysql_real_escape_string($loggeduser);
$risk= mysql_real_escape_string($_POST['risk']);
$status=mysql_real_escape_string($_POST['status']);
$type=mysql_real_escape_string($type);

$Ttime = strtotime($TDate);
$TDate = date( 'Y-m-d', $Ttime );

$Mtime=strtotime($meetingdate);
$meetingdate = date( 'Y-m-d', $Mtime );

echo "Action Item :".$actionitem."<br>";
echo "Owner :".$owner."<br>";
echo "Target Date :".$TDate."<br>";
echo "Agenda :".$agenda."<br>";
echo "Participant :".$participant."<br>";
echo "Meeting Date :".$meetingdate."<br>";
echo "Project :".$project."<br>";
echo "Discussion Point :".$discussionpoint."<br>";

echo "<br>";
mysql_select_db("audit") or die(mysql_error());

$query = "INSERT INTO mommaster(projectname,agenda,participants,actionitem,meetingdate,targetdate,owner,discussionpoint,loggeduser,risk,status,type) VALUES ('".$project."', '".$agenda."', '".$participant."','".$actionitem."','".$meetingdate."','".$TDate."','".$owner."','".$discussionpoint."','".$loggeduser."','".$risk."','".$status."','".$type."')";
$result=mysql_query($query) or die (mysql_error());
header("Location: window-child.php?param1=".$agenda."&&param2=".$participant."&&param3=".$meetingdate."&&param4=".$project."&&param5=".$discussionpoint."&&param6=".$loggeduser."&&param7=".$type);
?>