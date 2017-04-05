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

$cquery="update projectmaster set dev1='".$devone."',dev2='".$devtwo."',dev3='".$devthree."',dev4='".$devfour."',dev5='".$devfive."',dev6='".$devsix."',dev7='".$devseven."',dev8='".$deveight."',dev9='".$devnine."',dev10='".$devten."',dev11='".$develeven."',dev12='".$devtwelve."' where pindatabaseid='".$project."'";
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