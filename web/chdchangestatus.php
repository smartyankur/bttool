<?php
error_reporting(0);
session_start();

include("class.phpmailer.php");

$chdid      = $_GET["chdid"];
$chdstatus  = $_GET["chdstatus"];
$chdqccomnt = $_GET["chdqccomnt"];

if(!(isset($_SESSION['login']) && $_SESSION['login'] != '')){
  header("Location:index.php");
}
$user=$_SESSION['login'];

include("config.php");

$query = "select * from login where uniqueid='$user'";
$retval = mysql_query($query, $con);
$count = mysql_num_rows($retval);

if($count==0){
  die('Data Not Found Please contact SEPG');
}

while($row = mysql_fetch_assoc($retval)){
  $username = $row['username'];
  $email    = $row['email'];    
}

$selectFuncRvw  = "SELECT tfr.reviewer, tfr.course_title, lgn.email FROM tbl_functional_review AS tfr INNER JOIN login AS lgn ON tfr.reviewer = lgn.username WHERE tfr.id = '".$chdid."'";                                   
$queryFuncRvw   = mysql_query($selectFuncRvw);
$numrowsFuncRvw = mysql_num_rows($queryFuncRvw);
if( !empty($numrowsFuncRvw) ){  
  $fetchFuncRvw = mysql_fetch_array($queryFuncRvw);
}

$chdqccomnt = mysql_real_escape_string($chdqccomnt);
$MDate      = time();
$query = "UPDATE tbl_functional_review SET status='$chdstatus', qccomment='$chdqccomnt', modificationdate='$MDate' WHERE id='$chdid'";
//$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
if(mysql_query($query)){
//////////////////////////////////////////////////////////////////////
  	$str  = '<html><head><style type="text/css">body{background:url(\'qcr.jpg\') no-repeat;} .table_text{font-family:Calibri; font-size:12px; font-style:normal; line-height:normal; font-weight:normal; font-variant:normal; color:#000000; text-indent:10px; vertical-align:middle;}  
</style></head>';
  	$str .= '<body>';    
  	$str .= '<h4>Hi '.$fetchFuncRvw['reviewer'].', </h4>';
  	$str .= '<table border=0>';
  	$str .= '<tr>';
  	$str .= "<td>The CHD (".$fetchFuncRvw['course_title'].") has been ".$chdstatus." by ".$username." with remark '".$chdqccomnt."' on ".date('Y-m-d', $MDate).".</td>";            
  	$str .= '</tr>';
  	$str .= '</table>';
  	$str .= '<br /><br />Thanks and Regards, ';
  	$str .= '<br />BT Tool Administrator';    
  	$str .= '</body></html>';
        
    $qc1  = "manojk@gc-solutions.net";
    $qc2  = "gaurangbajpai@gc-solutions.net";
    $qc3  = "manojs@gc-solutions.net";
    $qc4  = "anuragm@gc-solutions.net";
    $qc5  = "amitk@gc-solutions.net";
    $qc6  = "bhavnam@gc-solutions.net";
    $qc7  = "aniruddhg@gc-solutions.net";
    $qc8  = "mahesht@gc-solutiones.net";
    $qc9  = "naveenc@gc-solutions.net";
    $qc10 = "kanchanr@gc-solutions.net";
    $qc11 = "ashwaniv@gc-solutions.net";
    $testing2 = "debasisp@gc-solutions.net";
//     $testing1 = "dharmendrak.v@gc-solutions.net";    
        
  	$mailer = new phpmailer();
  	$mailer->IsSMTP();
  	$mailer->IsHTML(true);
  
  	$mailer->Host     = "smtp.emailsrvr.com";
  	$mailer->Username = "sepg@gc-solutions.net";
  	$mailer->Password = "pass@12";
  
  	$mailer->SMTPAuth  = true;
  	$mailer->SMTPDebug = false;
  
  	$mailer->From     = $email;
  	$mailer->FromName = $user;
    
  	$mailer->AddAddress($fetchFuncRvw['email']);    
  	$mailer->AddCC($qc1);    
  	$mailer->AddCC($qc2);
  	$mailer->AddCC($qc3);
  	$mailer->AddCC($qc4);
  	$mailer->AddCC($qc5);
  	$mailer->AddCC($qc6);
  	$mailer->AddCC($qc7);
  	$mailer->AddCC($qc8);
  	$mailer->AddCC($qc9);
  	$mailer->AddCC($qc10);
  	$mailer->AddCC($qc11); 
    $mailer->AddCC($testing2, 'Debasis Pati');
//    $mailer->AddCC($testing1, 'Dharmendra Kumar');        
  	
  	$mailer->Subject = "Course Handover Document - Course name : " . $fetchFuncRvw['course_title'];
  	$mailer->Body    = $str;
  
   	$mailer->Send();
    if($mailer->ErrorInfo){
  	 echo $mailer->ErrorInfo."<br/>";
    }
//////////////////////////////////////////////////////////////////////
}

echo "<font color='green'>Row updated with new status for id :"."<b>".$chdid."</b></font><br />";

mysql_close($con);

?> 