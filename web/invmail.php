<body background="bg.gif">
<?php
error_reporting(0);
$mailid=trim($_POST['pmmail']);
$message=trim($_POST['details']);
$admin="accounts@gc-solutions.net";

//echo "Mailid :".$mailid;
//echo "</br>";
echo $message;

include("class.phpmailer.php");

$mailer = new phpmailer();
$mailer->IsSMTP();
$mailer->IsHTML(true);

$mailer->Host = "smtp.emailsrvr.com";
$mailer->Username = "sepg@gc-solutions.net";
$mailer->Password = "pass@12";

$mailer->SMTPAuth = true;
$mailer->SMTPDebug = false;

$mailer->From = "admin@gc-solutions.net";
$mailer->FromName = "ADMIN";

//$mailer->AddAddress("debasisp@gc-solutions.net");
$mailer->AddAddress($mailid);
$mailer->AddCC($admin,'Accounts');
$mailer->Subject = "Travel Invoice Expenses";
$mailer->Body = $message;

$mailer->Send();
echo $mailer->ErrorInfo."<br/>";
echo "<u>"."<b>"."Mail Sent"."</b>"."</u>";
?>
</body>