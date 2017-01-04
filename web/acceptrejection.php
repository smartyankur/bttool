<head>
<script>
function goBack()
  {
  window.history.back()
  }
</script>
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
    session_start();
	include("class.phpmailer.php");
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location:index.php");
    }
	
	$con = mysql_connect("localhost","root","password");
    $user=$_SESSION['login'];

    if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }

	mysql_select_db("audit") or die(mysql_error());

    $masterid=$_POST["masterid"];
    $id=$_POST["id"];
	$project=$_POST["project"];
    $task=$_POST["task"];
	$user=$_POST["loggeduser"]; 
    $email=$_POST["email"]; 
	$whosent=$_POST["whosent"]; 
	$sendermail=$_POST["sendermail"];
	$reason=$_POST["reason"]; 
	$round=$_POST["round"];
	$ground=$round+1;
	$currentdate = date('Y-m-d h:i:s', time());
    
	$str  = '<html><body>';
	$str .= '<h4>Dear '.$whosent.'</h4>';
	$str .= '<h5>Please Find Rejection Details</h5>';
	$str .= '<table border=1>';
	$str .= '<tr><th>Project</th><th>Task</th><th>Reason</th><th>Round</th></tr>';
	$str .= '<tr>';
	$str .= "<td>".$project."</td>";
	$str .= "<td>".$task."</td>";
	$str .= "<td>".$reason."</td>";
    $str .= "<td>".$ground."</td>";
	$str .= '</tr>';
	$str .= '</table>';
	$str .= 'Thanks and Regards,  '.$user;
	$str .= '</body></html>';

	$rquery = "select * from reject where masterid='$masterid' AND round='$ground'";
	$cret = mysql_query( $rquery, $con );
	$count = mysql_num_rows($cret);
	
	if($count==0)
	{
	$insert = "insert into reject(masterid,indx,entrydate,user,email,round,whohadrequested,requestermail,reason) values('$masterid','$id','$currentdate','$user','$email','$ground','$whosent','$sendermail','$reason')";
			if (mysql_query($insert))
               {
                $upd="update projecttask set status='rejected',round='$ground' where id='$masterid'";
                $retup=mysql_query($upd, $con);

				$upqreq="update qcreq set status='rejected' where id='$masterid' AND indx='$id'";
                $reupreq=mysql_query($upqreq, $con);

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
		  
				$mailer->AddAddress($sendermail);
                $mailer->AddAddress($sendermail,$whosent);
				$mailer->AddCC($delhead,'Del Head');
				$mailer->AddCC($qcone,'Debasis');
				$mailer->AddCC($qctwo,'Vikas');
				$mailer->AddCC($qcthree,'Ashish');
				$mailer->AddCC($qcfour,'Vibha');
                $mailer->AddCC($qcfive,'Vivek');
				$mailer->AddCC($qcsix,'Nitish');
				$mailer->AddCC($qcseven,'Vineet');

				$mailer->Subject = "LMSQC Rejected";
				$mailer->Body = $str;
		
				$mailer->Send();
				echo $mailer->ErrorInfo."<br/>";
                echo "</br>";
				echo "</br>";
				echo "</br>";
				echo "Row created and Mail Sent....";
				echo "<br>";
				?>
                <input type="button" class="button" value="Back" onclick="goBack()"> 
                <?php
		       } 
            else
			   {	
                die (mysql_error());
				exit();
               }
	
	}

    else
    {   
        echo "</br>";
		echo "</br>";
		echo "</br>";
		echo "Already Rejected";
	}
	
?>
</body>