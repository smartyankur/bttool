<?php	
	error_reporting(0);
      session_start();
	include("class.phpmailer.php");
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location:index.php");
    }
	
    $user=$_SESSION['login'];

    include('config.php');

    $query = "select username,email from login where uniqueid='$user'";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
	{
			die('Data Not Found Please contact SEPG');
	}

    
    while($row = mysql_fetch_assoc($retval)) 
    { 
     echo "<br>";
	 echo "<br>";
	 echo "<h3>"."Hi ".$row['username']." ! Send Test Request Interface"."</h3>";
	 $username=$row['username'];
	 $email=$row['email'];
    } 	

?>
<html>
<head>
<style type="text/css">
body
{
background:url('qcr.jpg') no-repeat;
}
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
</style>
<script type="text/javascript">
window.onunload = unloadPage;
function unloadPage()
{
 //alert("unload event detected!");
 newwindow.close();
 //chwindow.close();
}

function verify()
{
 var DDate = trim(document.getElementById('DDate').value);
 
 if(document.getElementById('fsimpact'))
 {
  var fsimpact = trim(document.getElementById('fsimpact').value);
 }
 
 if(document.getElementById('path'))
 {
  var path = trim(document.getElementById('path').value);
 }
 
 if(document.getElementById('build'))
 {
  var build = trim(document.getElementById('build').value);
 } 
 
 var remark = trim(document.getElementById('remark').value);
 
 if(DDate == ""){alert("Please mention develivery date"); return false;}
 if(fsimpact == "select"){alert("Please mention impact"); return false;}
 if(path == ""){alert("Please mention path to FS"); return false;}
 if(build == ""){alert("Please mention path to Build"); return false;}
 if(remark == ""){alert("Please provide remark"); return false;}
}

function trim(s)
{
	return rtrim(ltrim(s));
}

function ltrim(s)
{
	var l=0;
	while(l < s.length && s[l] == ' ')
	{	l++; }
	return s.substring(l, s.length);
}

function rtrim(s)
{
	var r=s.length -1;
	while(r > 0 && s[r] == ' ')
	{	r-=1;	}
	return s.substring(0, r+1);
}

</script>
<style type="text/css">
body
{
 background:url('qcr.jpg') no-repeat;
}
</style>
</head>
<body>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" method="post" onsubmit="return verify()" action="testrequest.php">
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
 $id = $_POST['id'];
 $project = $_POST['project'];
 $task = $_POST['task'];
 $fround = $_POST['round'];
 $ADate = date('Y-m-d H:i:s', time());
 $DDate = $_POST['DDate'];
 $whosent = $_POST['loggeduser'];
 $email = $_POST['email'];
 $fsimpact = $_POST['fsimpact'];
 $status = $_POST['status'];
 $ttype = mysql_real_escape_string($_POST['ttype']);
 $tenv = mysql_real_escape_string($_POST['tenv']);
 $path = mysql_real_escape_string(trim($_POST['path']));
 $build = mysql_real_escape_string(trim($_POST['build']));
 $remarks=mysql_real_escape_string(trim($_POST['remark']));

 $DDate=strtotime($DDate);
 $DDate = date( 'Y-m-d H:i:s', $DDate );

 if($ADate>$DDate) 
 {
  header ("Location:check.html");	 
  exit();
 }

 $str  = '<html><body>';
 $str .= '<h4>Dear QC Team</h4>';
 $str .= '<h5>Please Find Work Request</h5>';
 $str .= '<table border=1>';
 $str .= '<tr><th>Project</th><th>Task</th><th>Request For Round</th><th>Delivery Date</th><th>FS Impacted</th><th>FS Path</th><th>Build Path</th><th>Remark</th><th>Env</th><th>Type Of Test</th></tr>';
 $str .= '<tr>';
 $str .= "<td>".$project."</td>";
 $task=str_replace('\n',"&#10;",$task); $task=str_replace('\r'," ",$task);
 $str .= "<td>".stripslashes($task)."</td>";
 $str .= "<td>".$fround."</td>";
 $str .= "<td>".$DDate."</td>";
 $str .= "<td>".$fsimpact."</td>";
 $str .= "<td>".$path."</td>";
 $str .= "<td>".$build."</td>";
 $remarks=str_replace('\n',"&#10;",$remarks); $remarks=str_replace('\r'," ",$remarks);
 $str .= "<td>".stripslashes($remarks)."</td>";
 $str .= "<td>".$tenv."</td>";
 $str .= "<td>".$ttype."</td>";
 $str .= '</tr>';
 $str .= '</table>';
 $str .= 'Thanks and Regards,  '.$whosent;
 $str .= '</body></html>';

 $rquery = "select * from qcreq where id='$id' AND forround='$fround'";
 $cret = mysql_query( $rquery, $con );
 $count = mysql_num_rows($cret);

 if($count==0)
 {
 $newstat="sent to qc";

 $cquery="insert into qcreq(id,status,forround,fsimpact,ADate,DDate,path,build,whosent,sendermail,remark,env,ttype) values('$id','$newstat','$fround','$fsimpact','$ADate','$DDate','$path','$build','$whosent','$email','$remarks','$tenv','$ttype')";
 
 $chkstat="select status from projecttask where id='$id'";
 $crstat = mysql_query( $chkstat, $con );
 $rowstat = mysql_fetch_assoc($crstat);
 $stat=$rowstat['status'];
 
 if($stat=="accepted")
   {
    die("The request is in accepted state. Wait till it is closed or rejected...");   
   }
 
 if (mysql_query($cquery))
       {
		$update="update projecttask set status='sent to qc',whentoqc='$ADate' where id='$id'";
        $upret = mysql_query( $update, $con ); 
		      
        //$delhead="anuradhaj@gc-solutions.net";        
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
		$mailer->FromName = $whosent;
		  
        $mailer->AddAddress($qcone);
		$mailer->AddAddress($qctwo);
		$mailer->AddAddress($qcthree);
		$mailer->AddAddress($qcfour);
		$mailer->AddAddress($qcfive);
		$mailer->AddAddress($qcsix);
        $mailer->AddAddress($qcseven);

		//$mailer->AddCC($delhead,'Del Head');
		$mailer->AddCC($email,$whosent);

        $mailer->Subject = "LMSQC Request";
		$mailer->Body = $str;
		
		$mailer->Send();
		echo $mailer->ErrorInfo."<br/>";
				 
	    $message="Test request sent to QC for:".$project."  Task : ".$task." For Round".$fround;
		header ("Location: testrequest.php?message=".urlencode($message)."&id=".urlencode($id)."&remarks=".urlencode($remarks));
	   }
    else
       {
        //echo "Uploadinfo table couldn't be updated.";
		die (mysql_error());
		exit();
	   }
  }

 else
 { 
  $message="Already Sent";  
  header ("Location: testrequest.php?message=".urlencode($message)."&id=".urlencode($id));
 }
}

$id=$_REQUEST["id"];
$qr="select project,task,round,type,status from projecttask where id='".$id."'";
$retval = mysql_query( $qr, $con );
while($row = mysql_fetch_assoc($retval)) 
 {
  $project = $row['project'];
  $task = $row['task'];
  $type = $row['type'];
  $status = $row['status'];
  $round=$row['round'];
  $fround= $round+1;
 } 

if($status=='rejected' || $status=='closed')
{
$qpath ="select path,build,remark,fsimpact,DDate from qcreq where id='$id'";
$retpath = mysql_query( $qpath, $con );
$rowpath = mysql_fetch_assoc($retpath);
$build = $rowpath['build'];
$path = $rowpath['path'];
$remark = $rowpath['remark'];
$impact = $rowpath['fsimpact'];
$DDate = $rowpath['DDate'];
$DDate = strtotime($DDate);
$DDate = date( 'd-M-Y H:i:s', $DDate );
}

echo "Project :".$project." Request for round :".$fround;
echo "</br>";
echo "</br>";
?>
<TABLE>
<TR>
<TD>*Planned Delivery Date</TD>
<TD><input type="Text" readonly="readonly" id="DDate" value="<?php echo $DDate;?>" maxlength="20" size="17" name="DDate">
<a href="javascript:NewCal('DDate','ddmmmyyyy',true,24)"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>
<?php
if($type=="testing")
{
?>
<TR>
<TD>*FS has been impacted</TD>
<TD><select name="fsimpact" size="1" id="fsimpact">
<option value="select">Select</option>
<option value="Y" <?php if($impact=="Y") echo "selected";?>>Yes</option>
<option value="N" <?php if($impact=="N") echo "selected";?>>No</option>
</select></TD>
</TR>

<TR>
<TD>*FS Path</TD>
<TD><input type="Text" id="path" maxlength="100" size="40" name="path" value="<?php echo $path;?>"></TD>
</TR>

<TR>
<TD>*Build Path</TD>
<TD><input type="Text" id="build" maxlength="100" size="40" name="build" value="<?php echo $build;?>"></TD>
</TR>

<TR>
<TD>Test Environment</TD>
<TD><textarea name="tenv" rows="4" cols="30" id="tenv"><?php if($tenv<>""){echo $tenv;} else {echo "Put Browser and Resolution details here";}?></textarea></TD>
</TR>

<TR>
<TD>Test Type</TD>
<TD><textarea name="ttype" rows="4" cols="30" id="ttype"><?php if($ttype<>""){echo $ttype;} else {echo "Put type of testing here. Stress or Functionality or Security etc.";}?></textarea></TD>
</TR>

<?php
}
?>
<TR>
<TD>Remarks</TD>
<TD><textarea name="remark" rows="4" cols="30" id="remark"><?php if($remarks<>""){echo $remark;} else {echo "Put Remarks Here";}?></textarea></TD>
</TR>

</TABLE>
<?php
echo "<input type ='hidden' name='loggeduser' value='$username'>";
echo "<input type ='hidden' name='email' value='$email'>";
echo "<input type ='hidden' name='id' value='$id'>";
echo "<input type ='hidden' name='project' value='$project'>";
echo "<input type ='hidden' name='task' value='$task'>";
echo "<input type ='hidden' name='round' value='$fround'>";
echo "<input type ='hidden' name='status' value='$status'>";
if($type=="nontesting")
{
 echo "<input type ='hidden' name='fsimpact' value='NA'>";
 echo "<input type ='hidden' name='path' value='NA'>";
 echo "<input type ='hidden' name='build' value='NA'>";
}
?>
<input type="submit" value="Send QC Request" class="button">
</form>
<div id="txtHint"></i><?php $message=$_REQUEST["message"]; $str=str_replace('\n',"&#10;",$message); $strfin=str_replace('\r'," ",$str); if($strfin<>"") {echo stripslashes($strfin);}?></i></div>
</body>
</html> 