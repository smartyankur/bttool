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

    $project=$_POST["project"];
	$task=trim($_POST["task"]);
	$str=str_replace('\n',"&#10;",$task);
    $strfin=str_replace('\r'," ",$str);
	$mailstr=$strfin;
    $strfin=mysql_real_escape_string(trim($strfin));
	$SDate=$_POST["SDate"];
	$EDate=$_POST["EDate"];
    $qc=$_POST["qc"];
	$effort=$_POST["effort"];
	$masterid=$_POST["masterid"];
    $id=$_POST["id"];
	$user=$_POST["loggeduser"];
	$email=$_POST["email"];
	$round=$_POST["round"];
    $deldate=$_POST["deldate"];
	$currentdate = date('Y-m-d h:i:s', time());
	$remaining=$_POST["remaining"];

    $equery = "select email from login where username='$qc'";    
	$eret = mysql_query( $equery, $con );
	$erow = mysql_fetch_assoc($eret);
    $qcmail  = $erow['email'];

	$EDate=strtotime($EDate);
    $EDate = date( 'Y-m-d H:i:s', $EDate );

	$SDate=strtotime($SDate);
    $SDate = date( 'Y-m-d H:i:s', $SDate );
	
    If($SDate>$deldate || $EDate>$deldate) {echo "<br>"; echo "<br>"; echo "<br>"; echo "Start Date or End Date cannot be after Delivery Date"; exit();}
    If($SDate>$EDate) {echo "<br>"; echo "<br>"; echo "<br>"; echo "Start Date cannot be after End Date"; exit();}
    if($effort>$remaining) {echo "<br>"; echo "<br>"; echo "<br>"; echo "Effort exhausted"; exit();}

    $str  = '<html><body>';
	$str .= '<h4>Dear '.$qc.'</h4>';
	$str .= '<h5>Task Allocation</h5>';
	$str .= '<table border=1>';
	$str .= '<tr><th>Project</th><th>Task</th><th>Start Date</th><th>End Date</th><th>Round</th><th>Delivery Date</th></tr>';
	$str .= '<tr>';
	$str .= "<td>".$project."</td>";
	$str .= "<td>".$mailstr."</td>";
	$str .= "<td>".$SDate."</td>";
	$str .= "<td>".$EDate."</td>";
	$str .= "<td>".$round."</td>";
    $str .= "<td>".$deldate."</td>";
	$str .= '</tr>';
	$str .= '</table>';
	$str .= 'Thanks and Regards,  '.$user;
	$str .= '</body></html>';

    $aquery="select * from qcplan where masterid='$masterid' AND indx='$id' AND task='$strfin'";
    $aqval = mysql_query( $aquery, $con );
    $count = mysql_num_rows($aqval);

    if($count==0)
    {
	$insert = "insert into qcplan(masterid,indx,project,task,qc,SDate,EDate,timestamp,whocreated,effort) values('$masterid','$id','$project','$strfin','$qc','$SDate','$EDate','$currentdate','$user',$effort)";
			
      //echo $insert;
      if (mysql_query($insert))
               {
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
		  
				$mailer->AddAddress($qcmail);
				$mailer->Subject = "Task Allocation";
				$mailer->Body = $str;
		
				$mailer->Send();
				echo "</br>";
                echo "</br>";
                echo "</br>";
				echo $mailer->ErrorInfo."<br/>";
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
	   die("This record already exists....");
     }	
  ?>
</body>