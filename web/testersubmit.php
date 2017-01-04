<?php
error_reporting(0);
$project = $_POST['project'];
$tone = $_POST['tone'];
$ttwo = $_POST['ttwo'];
$tthree = $_POST['tthree'];
$tfour = $_POST['tfour'];
$tfive = $_POST['tfive'];
$tsix = $_POST['tsix'];
$tseven = $_POST['tseven'];
$teight = $_POST['teight'];

echo "project :".$project;
//echo "</br>";
//echo "tone :".$tone;
//echo "</br>";
//echo "ttwo :".$ttwo;
//echo "</br>";
//echo "tthree :".$tthree;
//echo "</br>";
//echo "tfour :".$tfour;
//echo "</br>";
//echo "tfive :".$tfive;
//echo "</br>";
//echo "tsix :".$tsix;
//echo "</br>";
//echo "tseven :".$tseven;
echo "</br>";
//echo "teight :".$teight;

include("config.php");
$cquery="update projectmaster set tester1='".$tone."',tester2='".$ttwo."',tester3='".$tthree."',tester4='".$tfour."',tester5='".$tfive."',tester6='".$tsix."',tester7='".$tseven."',tester8='".$teight."' where projectname='".$project."'";
//echo $cquery;
$cresult=mysql_query($cquery) or die (mysql_error());
$adminuser=trim($_REQUEST['adminuser']);

echo "Row Inserted";

?>
<br>
<br>
<input type="button" value="Enter Another Record" onclick="document.location = 'addtesters.php?user=<?php echo $adminuser;?>';">
<?php
mysql_close($con);
?>