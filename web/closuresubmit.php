<body>
<?php
$project = $_POST['project'];
$actionid = trim($_POST['actionid']);
$closuredate = $_POST['CDate'];
$status = $_POST['status'];
$feedback = trim($_POST['feedback']);
$ctime = strtotime($closuredate);
$ctimemyformat = date( 'Y-m-d', $ctime );


include('config.php');

$feedback = mysql_real_escape_string($_REQUEST["feedback"]);

$cquery="select * from actionitem where actionid='$actionid'";
$cresult=mysql_query($cquery) or die (mysql_error());

if(!$row = mysql_fetch_array($cresult))
{
 echo "No Such Entry Exists";
 
?>
 <br>
 <br>
 <input type="button" value="Enter Another Record" onclick="document.location = 'closure.php';">
 
<?php
exit();
}

$query = "UPDATE actionitem SET closuredate = '$ctimemyformat', status = '$status', sepgcomment = '$feedback' WHERE actionid = '$actionid'";
$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "Row updated with actionid".$actionid;
?>
<br>
<input type="button" value="Update Another Record" onclick="document.location = 'closure.php';">
</body>