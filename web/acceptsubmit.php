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
	
	$user=$_SESSION['login'];
	include('config.php');

    $SDate=$_POST["SDate"];
	$EDate=$_POST["EDate"];
	$status=$_POST["status"];
	$masterid=$_POST["masterid"];
    $id=$_POST["id"];
	$user=$_POST["loggeduser"];
    $email=$_POST["email"];
	$round=$_POST["round"];
	$whosent=$_POST["whosent"];
	$sendermail=$_POST["sendermail"];
	$effort=$_POST["effort"];
	$currentdate = date('Y-m-d h:i:s', time());

	$SDate=strtotime($SDate);
    $SDate = date( 'Y-m-d H:i:s', $SDate );
	
	$EDate=strtotime($EDate);
    $EDate = date( 'Y-m-d H:i:s', $EDate );

    $protask = "select project,task from projecttask where id='$masterid'";
    $rprot = mysql_query( $protask, $con );
    $rowt = mysql_fetch_assoc($rprot);
	$project = $rowt['project'];
	$task = $rowt['task'];
    
    $date="select ADate,DDate from qcreq where id='$masterid' and indx='$id'";
    $rdate = mysql_query( $date, $con );
    $row = mysql_fetch_assoc($rdate);
	$deldate=$row['DDate'];
	$recdate=$row['ADate'];
	
	If($SDate>$EDate) {echo "<br>"; echo "<br>"; echo "<br>"; echo "Start Date cannot be on or after End Date"; exit();}
    If($EDate>$deldate || $SDate>$deldate) {echo "<br>"; echo "<br>"; echo "<br>"; echo "Start Date or End Date cannot be after Delivery Date"; exit();}
    If($EDate<$recdate || $SDate<$recdate) {echo "<br>"; echo "<br>"; echo "<br>"; echo "Start Date or End Date cannot be before Received Date"; exit();}

    $str  = '<html><body>';
	$str .= '<h4>Dear '.$whosent.'</h4>';
	$str .= '<h5>Please Find QC Plan</h5>';
	$str .= '<table border=1>';
	$str .= '<tr><th>Project</th><th>Task</th><th>Test Start Date</th><th>Test End Date</th><th>Round</th></tr>';
	$str .= '<tr>';
	$str .= "<td>".$project."</td>";
	//$task=stripslashes($task);
	$task=str_replace('\n',"&#10;",$task); $task=str_replace('\r'," ",$task);
	$str .= "<td>".$task."</td>";
	$str .= "<td>".$SDate."</td>";
	$str .= "<td>".$EDate."</td>";
	$str .= "<td>".$round."</td>";
	$str .= '</tr>';
	$str .= '</table>';
	$str .= 'Thanks and Regards,  '.$user;
	$str .= '</body></html>';

	$rquery = "select * from accept where masterid='$masterid' AND indx='$id' AND round='$round'";
	$cret = mysql_query( $rquery, $con );
	$count = mysql_num_rows($cret);		

	if($count==0)
	{
	$insert = "insert into accept(masterid,indx,SDate,DDate,entrydate,user,effort,round) values('$masterid','$id','$SDate','$EDate','$currentdate','$user','$effort','$round')";
			if (mysql_query($insert))
               {

                $upd="update projecttask set status='accepted',round='$round' where id='$masterid'";
                $retup=mysql_query($upd, $con);

				$upqreq="update qcreq set status='accepted' where id='$masterid' AND indx='$id'";
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
		  
				$mailer->AddAddress($sendermail,$whosent);
				$mailer->AddCC($delhead,'Del Head');
				$mailer->AddCC($qcone,'Debasis');
				$mailer->AddCC($qctwo,'Vikas');
				$mailer->AddCC($qcthree,'Ashish');
				$mailer->AddCC($qcfour,'Vibha');
                $mailer->AddCC($qcfive,'Vivek');
				$mailer->AddCC($qcsix,'Nitish');
				$mailer->AddCC($qcseven,'Vineet');

				$mailer->Subject = "LMSQC Accepted";
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
		echo "Already Accepted";
	}
	
?>
</body>