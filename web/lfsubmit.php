<?php
error_reporting(0);
$project = $_POST['project'];
$lead = $_POST['lead'];
$fmone = $_POST['fmone'];
$fmtwo = $_POST['fmtwo'];
$fmthree = $_POST['fmthree'];
$fmfour = $_POST['fmfour'];
$ceo = $_POST['ceo'];
$md = $_POST['md'];
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

$cquery="update projectmaster set lead='".$lead."',fmone='".$fmone."',fmtwo='".$fmtwo."',fmthree='".$fmthree."',fmfour='".$fmfour."',ceo='".$ceo."',md='".$md."' where pindatabaseid='".$project."'";
//echo $cquery;
$cresult=mysql_query($cquery) or die (mysql_error());
$adminuser=trim($_REQUEST['adminuser']);

echo "Row Inserted";
?>
<br>
<br>
<input type="button" value="Enter Another Record" onclick="document.location = 'addleadfm.php?user=<?php echo $adminuser;?>';">
<?php
mysql_close($con);
?>