<?php

include('config.php');

$agenda = mysql_real_escape_string($_REQUEST["agenda"]);
$participants = mysql_real_escape_string($_REQUEST["participants"]);
$actionitem = mysql_real_escape_string($_REQUEST["actionitem"]);
$owner = mysql_real_escape_string($_REQUEST["owner"]);
$project = $_POST['project'];
$impact = $_POST['impact'];

$mdate = $_POST['MDate']; 
$mtime = strtotime($mdate);
$mtimemyformat = date( 'Y-m-d', $mtime );

$tdate = $_POST['TDate']; 
$ttime = strtotime($tdate);
$ttimemyformat = date( 'Y-m-d', $ttime );

echo $agenda;
echo "<br>";
echo $participants;
echo "<br>";
echo $actionitem;
echo "<br>";
echo $project;
echo "<br>";
echo $mtimemyformat;
echo "<br>";
echo $ttimemyformat;
echo "<br>";
echo $owner;
echo "<br>";
echo $impact;

$query="INSERT INTO mommaster(projectname,agenda,participants,actionitem,meetingdate,targetdate,impact,owner) values('".$project."','".$agenda."','".$participants."','".$actionitem."','".$mtimemyformat."','".$ttimemyformat."','".$impact."','".$owner."')";

echo $query;

mysql_query($query) or die (mysql_error());
header( 'Location: momframe.html' ) ;

?>
