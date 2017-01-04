<body background="bg.gif">
<?php
error_reporting(0);
$mailid=trim($_POST['pmmail']);
$message=trim($_POST['msg']);
$id=trim($_POST['fmonemail']);
$med=trim($_POST['fmtwomail']);
$scr=trim($_POST['fmthreemail']);
$qc=trim($_POST['fmfouremail']);
$project=trim($_POST['project']);
$dm="anuradhaj@gc-solutions.net";

echo "Mailid :".$mailid;
echo "</br>";
echo "Message :".$message;

include("class.phpmailer.php");

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

//$mailer->AddAddress("debasisp@gc-solutions.net");
$mailer->AddAddress($mailid);
$mailer->AddCC($dm,'DM');
if($id<>"") $mailer->AddCC($id,'ID FM');
if($med<>"") $mailer->AddCC($med,'MED FM');
if($scr<>"") $mailer->AddCC($scr,'SCR FM');
if($qc<>"") $mailer->AddCC($qc,'QC FM');

$mailer->Subject = $project." : QC Testing Alert";
$mailer->Body = $message;

$mailer->Send();
echo $mailer->ErrorInfo."<br/>";
echo "<u>"."<b>"."Mail Sent"."</b>"."</u>";
?>
</body>