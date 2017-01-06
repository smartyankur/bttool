<head>
<style>
.button
{
background-color: #F7941C;
border-bottom:#F7941C;
border-left: #F7941C;
border-right:#F7941C;
border-top: #F7941C;
color: black;
font-family: Tahoma
box-shadow:2px 2px 0 0 #014D06,;
border-radius: 10px;
border: 1px outset #b37d00 ;
}
body
{
background:url('qcr.jpg') no-repeat;
}
</style>
</head>
<body>
<?php
error_reporting(0);
include("class.phpmailer.php");
include('config.php');
$user=$_SESSION['login'];


$user = $_POST['loggeduser'];
//echo "loggeduser :".$loggeduser;
//echo "<br>";
$email = $_POST['email'];
//echo "email :".$email;
//echo "<br>";
$id = $_POST['id'];
//echo "id :".$id;
//echo "<br>";
$mid = $_POST['mid'];
//echo "mid :".$mid;
//echo "<br>";
$whosent = $_POST['whosent'];
//echo "whosent :".$whosent;
//echo "<br>";
$sendermail = $_POST['sendermail'];
//echo "sendermail :".$sendermail;
//echo "<br>";

$curdate = date('Y-m-d H:i:s', time());

$qr="select count(*) from close where masterid='".$mid."' AND indx='".$id."'";
$retval = mysql_query( $qr, $con );
while($row = mysql_fetch_assoc($retval)) 
 {
  $count = $row['count(*)']; 
 } 

if($count>0)
{
 echo "</br>";
 echo "</br>";
 echo "</br>";
 die("Already Closed");
}

$proq = "select project,task,round from projecttask where id='$mid'";
$rproq = mysql_query( $proq, $con );
while($prow = mysql_fetch_assoc($rproq))
{
 $project = $prow['project'];
 $task = $prow['task'];
 $round = $prow['round'];
}

$ins="insert into close(indx,masterid,entrydate,user,email,round,whosent,sendermail) values('$id','$mid','$curdate','$user','$email','$round','$whosent','$sendermail')";
$rins = mysql_query($ins, $con);

$upd="update projecttask set status='closed' where id='$mid'";
//echo $upd;
$retup=mysql_query($upd, $con);

$upqreq="update qcreq set status='closed' where id='$mid' AND indx='$id'";
$reupreq=mysql_query($upqreq, $con);

$str  = '<html><body>';
$str .= '<h4>Dear '.$whosent.'</h4>';
$str .= '<h5>QC Has Completed For Following Work Packet</h5>';
$str .= '<table border=1>';
$str .= '<tr><th>Project</th><th>Task</th></tr>';
$str .= '<tr>';
$str .= "<td>".$project."</td>";
//$task=stripslashes($task);
$task=str_replace('\n',"&#10;",$task); $task=str_replace('\r'," ",$task);
$str .= "<td>".$task."</td>";
$str .= '</tr>';
$str .= '</table>';
$str .= 'Thanks and Regards,  '.$user;
$str .= '</body></html>';

$delhead="anuradhaj@gc-solutions.net";        
$qcone="debasisp@gc-solutions.net";
$qctwo="vikass@gc-solutions.net";
$qcthree="ashishk@gc-solutions.net";
$qcfour="vibhat@gc-solutions.net";
$qcfive="viveks@gc-solutions.net";
$qcsix="nitishs@gc-solutions.net";
$qcseven="vineetg@gc-solutions.net";

$mailer = new phpmailer();
$mailer->IsSMTP();
$mailer->IsHTML(true);

$mailer->Host = "smtp.emailsrvr.com";
$mailer->Username = "sepg@gc-solutions.net";
$mailer->Password = "pass@12";

$mailer->SMTPAuth = true;
$mailer->SMTPDebug = false;
 
$mailer->From = $email;
$mailer->FromName = $user;

$mailer->AddAddress($sendermail,$whosent);
$mailer->AddCC($delhead,'Del Head');
$mailer->AddCC($qcone,'Debasis');
$mailer->AddCC($qctwo,'Vikas');
$mailer->AddCC($qcthree,'Ashish');
$mailer->AddCC($qcfour,'Vibha');
$mailer->AddCC($qcfive,'Vivek');
$mailer->AddCC($qcsix,'Nitish');
$mailer->AddCC($qcseven,'Vineet');

$mailer->Subject = "LMSQC Completed";
$mailer->Body = $str;

$mailer->Send();
echo $mailer->ErrorInfo."<br/>";
echo "</br>";
echo "</br>";
echo "</br>";
echo "Row created and Mail Sent....";
echo "<br>";
?>
</body>