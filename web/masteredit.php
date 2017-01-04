
<body>
<?php

$con = mysql_connect("localhost","root","password");

if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

$pin=trim($_POST["pin"]);
$projectname=mysql_real_escape_string(trim($_POST["projectname"]));
$IDate=$_POST["IDate"];
$SDate=$_POST["SDate"];
$EDate=$_POST["EDate"];
$cost=mysql_real_escape_string(trim($_POST["cost"]));
$effort=mysql_real_escape_string(trim($_POST["effort"]));
$projectmanager=mysql_real_escape_string(trim($_POST["projectmanager"]));
$accountmanager=mysql_real_escape_string(trim($_POST["accountmanager"]));
$clientspoc=mysql_real_escape_string(trim($_POST["clientspoc"]));
$practice=mysql_real_escape_string(trim($_POST["practice"]));
$remarks=mysql_real_escape_string(trim($_POST["remarks"]));
$accountname=mysql_real_escape_string(trim($_POST["accountname"]));
$buhead=mysql_real_escape_string(trim($_POST["buhead"]));
$practicehead=mysql_real_escape_string(trim($_POST["practicehead"]));
$sepghead=mysql_real_escape_string(trim($_POST["sepghead"]));
$sepglead=mysql_real_escape_string(trim($_POST["sepglead"]));
$CDT=mysql_real_escape_string(trim($_POST["CDT"]));
$CRate=mysql_real_escape_string(trim($_POST["CRate"]));
$CPT=mysql_real_escape_string(trim($_POST["CPT"]));
$currency=trim($_POST["currency"]);

$issuetime=strtotime($IDate);
$issuedate=date( 'Y-m-d', $issuetime);

$starttime = strtotime($SDate);
$startdate = date( 'Y-m-d', $starttime );

$endtime = strtotime($EDate);
$enddate = date( 'Y-m-d', $endtime );

//$finding = mysql_real_escape_string($_REQUEST["finding"]);
/*
echo $pin."<br>";
echo $issuedate."<br>";
echo $projectname."<br>";
echo $startdate."<br>";
echo $enddate."<br>";
echo $cost."<br>";
echo $effort."<br>";
echo $projectmanager."<br>";
echo $accountmanager."<br>";
echo $clientspoc."<br>";
echo $commercialdetail."<br>";
echo $practice."<br>";
echo $remarks."<br>";
echo $buhead."<br>";
echo $practicehead."<br>";
echo $accountname."<br>";
echo $sepghead."<br>";
echo $sepglead."<br>";
*/
mysql_select_db("audit") or die(mysql_error());

$query="UPDATE projectmaster SET pin='$pin',dateofissue='$issuedate',projectstartdate='$startdate',projectenddate='$enddate',projectcost='$cost',estimatedeffort='$effort',projectmanager='$projectmanager',accountmanager='$accountmanager',clientspoc='$clientspoc',practice='$practice',remarks='$remarks',accountname='$accountname',buhead='$buhead',practicehead='$practicehead',sepghead='$sepghead',sepglead='$sepglead',commercialdetailDealType='$CDT',commercialdetailRate='$CRate',commercialdetailPaymentTerm='$CPT',currency='$currency' where projectname='$projectname'";

echo "<br>";
//echo $query;

mysql_query($query) or die (mysql_error());
echo "Row Updated";
mysql_close($con);
?>
<br>
<br>
<?php
$adminuser=trim($_REQUEST['adminuser']);
?>
<input type="button" value="Select Another Project" onclick="document.location = 'selectproject.php?user=<?php echo $adminuser;?>';">
<input type="button" value="Main Menu" onclick="document.location = 'admin.php?ruser=<?php echo $adminuser;?>';">
</body>