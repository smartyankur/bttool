
<body>
<?php
error_reporting(0);
include("config.php");

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


//$query = "INSERT INTO blogs_table(blogger_name, comment, date) VALUES ('".$logged_in_user . "', '".$inputfromform  . "', " ." now() )";

$cquery="select pindatabaseid from projectmaster where projectname='$projectname'";
$cresult=mysql_query($cquery) or die (mysql_error());

if($row = mysql_fetch_array($cresult))
{
 echo "This Project Already Exists";
 
?>
 <br>
 <br>
 <input type="button" value="Enter Another Record" onclick="document.location = 'projectmaster.php?user=<?php echo $user;?>';">
 
<?php
exit();
}

$query="INSERT INTO projectmaster(pin,dateofissue,projectname,projectstartdate,projectenddate,projectcost,estimatedeffort,projectmanager,accountmanager,clientspoc,practice,remarks,accountname,buhead,practicehead,sepghead,sepglead,commercialdetailDealType,commercialdetailRate,commercialdetailPaymentTerm,currency) values('".$pin."','".$issuedate."','".$projectname."','".$startdate."','".$enddate."','".$cost."','".$effort."','".$projectmanager."','".$accountmanager."','".$clientspoc."','".$practice."','".$remarks."','".$accountname."','".$buhead."','".$practicehead."','".$sepghead."','".$sepglead."','".$CDT."','".$CRate."','".$CPT."','".$currency."')";

echo "<br>";
//echo $query;

mysql_query($query) or die (mysql_error());
echo "Row Inserted";
mysql_close($con);
?>
<br>
<br>
<?php
$adminuser=trim($_REQUEST['adminuser']);
?>
<input type="button" value="Enter Another Record" onclick="document.location = 'projectmaster.php?user=<?php echo $adminuser;?>';">
</body>