<body>
<?php
error_reporting(0);
include("config.php");
$mailid=trim($_POST['pmmail']);
$message=trim($_POST['msg']);
$id=trim($_POST['fmonemail']);
$med=trim($_POST['fmtwomail']);
$scr=trim($_POST['fmthreemail']);
$dev=explode(',',$_POST['dev']);
$qc=trim(isset($_POST['qc']) ? $_POST['qc'] : '');
$rev=trim(isset($_POST['rev']) ? $_POST['rev'] : '');
$project=trim($_POST['project']);
$subject=trim($_POST['subject']);
$status = isset($_POST['status']) ? $_POST['status'] : '';
$chd_id = $_POST['chd_id'];
if(!empty($status)) {
	$query = "update tbl_functional_review set status='".$status."', qccomment='".$message."' where id = $chd_id";
	mysql_query($query);
}

$dm="rachnad@gc-solutions.net";

//echo "Mailid :".$mailid;
//echo "</br>";
//echo "Message :".$message;

include("class.phpmailer.php");

$mailer = new phpmailer();
$mailer->IsSMTP();
$mailer->IsHTML(true);

  	$mailer->Host     = "98.129.185.2";
	$mailer->Port     = 587;
  	$mailer->Username = "sepg@gc-solutions.net";
  	//$mailer->Password = "Gcube!123";

$mailer->SMTPAuth = true;

$mailer->SMTPDebug = false;

$mailer->From = "sepg@gc-solutions.net";
$mailer->FromName = "QC";

$mailer->AddAddress($mailid);
$mailer->AddCC($dm,'');
if($id<>"") $mailer->AddCC($id,'ID FM');
if($med<>"") $mailer->AddCC($med,'MED FM');
if($scr<>"") $mailer->AddCC($scr,'SCR FM');
if($qc<>"") $mailer->AddCC($qc,'QC FM');
if($rev<>"") $mailer->AddCC($rev,'REVIEWER');
if(count($dev) > 0) {
	foreach($dev as $val) {
		$mailer->AddCC($val,$val);
	}
}


$mailer->Subject = $subject;
$mailer->Body = $message;
$mailer->Send();
if($mailer->ErrorInfo) {
	echo $mailer->ErrorInfo."<br/>";
} else {
	echo "<u>"."<b>"."Mail Sent Successfully"."</b>"."</u>";
}
?>
</body>