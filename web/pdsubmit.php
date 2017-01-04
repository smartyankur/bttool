<?php
error_reporting(0);
$project = $_POST['project'];
$pm = $_POST['pm'];
$am = $_POST['am'];
$buh = $_POST['buh'];
$ph = $_POST['ph'];
$sh = $_POST['sh'];
$sl = $_POST['sl'];
/*
echo "project :".$project;
echo "</br>";
echo "lead :".$lead;
echo "</br>";
echo "fmone :".$fmone;
echo "</br>";
echo "fmtwo :".$fmtwo;
echo "</br>";
echo "fmthree :".$fmthree;
echo "</br>";
echo "fmfour :".$fmfour;
*/
include("config.php");

$cquery="update projectmaster set 
projectmanager='".$pm."',accountmanager='".$am."',buhead='".$buh."',practicehead='".$ph."',sepghead='".$sh."',sepglead='".$sl."' where projectname='".$project."'";


$cresult=mysql_query($cquery) or die (mysql_error());
$adminuser=trim($_REQUEST['adminuser']);

echo "Row Inserted";
?>
<br>
<br>
<input type="button" value="Enter Another Record" onclick="document.location = 'updpmdm.php?user=<?php echo $adminuser;?>';">
<?php
mysql_close($con);
?>