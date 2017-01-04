<?php
error_reporting(0);
$project = $_POST['project'];
$scm = $_POST['scm'];
$scmtwo = $_POST['scmtwo'];

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

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
    die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit") or die(mysql_error());

$cquery="update projectmaster set scm='".$scm."',scmtwo='".$scmtwo."' where projectname='".$project."'";
//echo $cquery;
$cresult=mysql_query($cquery) or die (mysql_error());
$adminuser=trim($_REQUEST['adminuser']);

echo "Row Updated";
?>
<br>
<br>
<input type="button" value="Enter Another Record" onclick="document.location = 'addleadfm.php?user=<?php echo $adminuser;?>';">
<?php
mysql_close($con);
?>