<body background="bg.gif">
<?php
error_reporting(0);
$project = $_POST['project'];
$lead = $_POST['lead'];
//echo "PM ".$lead;
$fmone = $_POST['fmone'];
$fmtwo = $_POST['fmtwo'];
$fmthree = $_POST['fmthree'];
$fmfour = $_POST['fmfour'];

include('config.php');

$cquery="update projectmaster set projectmanager='".$lead."',fmone='".$fmone."',fmtwo='".$fmtwo."',fmthree='".$fmthree."',fmfour='".$fmfour."' where projectname='".$project."'";
//echo $cquery;
$cresult=mysql_query($cquery) or die (mysql_error());
$adminuser=trim($_REQUEST['adminuser']);

echo "Row Updated";
?>
<br>
<br>
<?php
mysql_close($con);
?>
</body>