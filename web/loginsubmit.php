<body>
<?php
error_reporting(0);
include("config.php");

$systemuser=sha1(mysql_real_escape_string(trim($_POST["sysuser"])));
$name=mysql_real_escape_string(trim($_POST["personname"]));
$pwd=mysql_real_escape_string(trim($_POST["sysuser"]));
$email=mysql_real_escape_string(trim($_POST["email"]));
$role=mysql_real_escape_string(trim($_POST["role"]));
$dept=mysql_real_escape_string(trim($_POST["dept"]));


$cquery = "select * from login where uniqueid='".$systemuser. "' or username='".$name. "'";
//echo $cquery;
$cresult=mysql_query($cquery) or die (mysql_error());

if($crow = mysql_fetch_array($cresult))
{
 echo "This User Already Exists. Either username or unique id exists.";
 
?>
 <br>
 <br>
 <input type="button" value="Enter Another Record" onclick="document.location = 'loginmaster.html';">
 
<?php
exit();
}

$query = "INSERT INTO login(uniqueid,username,pwd,email,role,dept) VALUES ('".$systemuser."', '".$name."', '".$pwd."', '".$email."', '".$role."', '".$dept."')";
$result=mysql_query($query) or die (mysql_error());
echo "Row Inserted";
mysql_close($con);
?>
<br>
<br>
<?php
$adminuser=trim($_REQUEST['adminuser']);
?>
<input type="button" value="Enter Another Record" onclick="document.location = 'loginmaster.php?user=<?php echo $adminuser;?>';">
</body>