<?php
//error_reporting(0);
$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);

include("class.phpmailer.php");

$project = $_GET["q"];
$sql="SELECT pmemail FROM projectmaster where projectname='$project'";
//echo $sql;
$result = mysql_query($sql);

$count = mysql_num_rows($result);

//if($count==0)
//{
  //die('Mail ID Not Found');
//}

while($row = mysql_fetch_array($result))
{
 $tomail=$row['pmemail'];
 if (trim($tomail)=="")
 die('Mail ID Not Found'); 
}
echo $tomail;
$mailer = new phpmailer();
$mailer->IsSMTP();
$mailer->IsHTML(true);

$mailer->Host = "smtp.emailsrvr.com";
$mailer->Username = "sepg@gc-solutions.net";
$mailer->Password = "pass@12";

$mailer->SMTPAuth = true;
$mailer->SMTPDebug = false;

$mailer->From = "sepg@gc-solutions.net";
$mailer->FromName = "QC";

$mailer->AddAddress($tomail);
$mailer->Subject = "QC Testing Alert";
$mailer->Body = "QC Teting issues have been logged in tool for project :".$project." - QC & SEPG Team";
echo "Hello";
$mailer->Send();
echo $mailer->ErrorInfo."<br/>";
echo "Mail Sent";
?>