
<body>
<?php
include('config.php');

$systemuser=sha1(mysql_real_escape_string(trim($_POST["sysuser"])));
$name=mysql_real_escape_string(trim($_POST["personname"]));
$pwd=mysql_real_escape_string(trim($_POST["sysuser"]));

$cquery = "select * from adminlogin where uniqueid='".$systemuser. "' or username='".$name. "'";
//echo $cquery;
$cresult=mysql_query($cquery) or die (mysql_error());

if($crow = mysql_fetch_array($cresult))
{
 echo "This User Already Exists";
 
?>
 <br>
 <br>
 <input type="button" value="Enter Another Record" onclick="document.location = 'loginmaster.html';">
 
<?php
exit();
}

$query = "INSERT INTO adminlogin(uniqueid,username,pwd) VALUES ('".$systemuser."', '".$name."', '".$pwd."')";
$result=mysql_query($query) or die (mysql_error());
echo "Row Inserted";
mysql_close($con);
?>
<br>
<br>
<br>
<input type="button" value="Enter Another Record" onclick="document.location = 'adminloginmaster.html';">
</body>