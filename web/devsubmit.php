<?php
error_reporting(0);
$project = $_POST['project'];
$devone = $_POST['devone'];
$devtwo = $_POST['devtwo'];
$devthree = $_POST['devthree'];
$devfour = $_POST['devfour'];
$devfive = $_POST['devfive'];
$devsix = $_POST['devsix'];
$devseven = $_POST['devseven'];
$deveight = $_POST['deveight'];
$devnine = $_POST['devnine'];
$devten = $_POST['devten'];
$develeven = $_POST['develeven'];
$devtwelve = $_POST['devtwelve'];
$devthirteen = $_POST['devthirteen'];
$devfourteen = $_POST['devfourteen'];
$devfifteen = $_POST['devfifteen'];
$devsixteen = $_POST['devsixteen'];
$devseventeen = $_POST['devseventeen'];
$deveighteen = $_POST['deveighteen'];
$devninteen = $_POST['devninteen'];
$devtwenty = $_POST['devtwenty'];
$devtwentyone = $_POST['devtwentyone'];
$devtwentytwo = $_POST['devtwentytwo'];
$devtwentythree = $_POST['devtwentythree'];
$devtwentyfour = $_POST['devtwentyfour'];
$devtwentyfive = $_POST['devtwentyfive'];



echo "project :".$project;
echo "</br>";
//echo "devone :".$devone;
//echo "</br>";
//echo "devtwo :".$devtwo;
//echo "</br>";
//echo "devthree :".$devthree;
//echo "</br>";
//echo "devfour :".$devfour;
//echo "</br>";
//echo "devfive :".$devfive;
//echo "</br>";
//echo "devsix :".$devsix;
//echo "</br>";
//echo "devseven :".$devseven;
//echo "</br>";
//echo "deveight :".$deveight;

include("config.php");

$cquery="update projectmaster set dev1='".$devone."',dev2='".$devtwo."',dev3='".$devthree."',dev4='".$devfour."',dev5='".$devfive."',dev6='".$devsix."',dev7='".$devseven."',dev8='".$deveight."',dev9='".$devnine."',dev10='".$devten."',dev11='".$develeven."',dev12='".$devtwelve."',dev13='".$devthirteen."', dev14='".$devfourteen."',dev15='".$devfifteen."',dev16='".$devsixteen."',dev17='".$devseventeen."',dev18='".$deveighteen."',dev19='".$devninteen."',dev20='".$devtwenty."',dev21='".$devtwentyone."',dev22='".$devtwentytwo."',dev23='".$devtwentythree."',dev24='".$devtwentyfour."',dev25='".$devtwentyfive."' where pindatabaseid='".$project."'";
//echo $cquery;
$cresult=mysql_query($cquery) or die (mysql_error());
$adminuser=trim($_REQUEST['adminuser']);

echo "Row Inserted";

?>
<br>
<br>
<input type="button" value="Enter Another Record" onclick="document.location = 'adddevs.php?user=<?php echo $adminuser;?>';">
<?php
mysql_close($con);
?>