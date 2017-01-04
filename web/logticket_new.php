<?php
error_reporting(0);
session_start();

include("class.phpmailer.php");

if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
  header ("Location:index.php");
}
$user=$_SESSION['login'];

include("config.php");

$query = "select username,email from login where uniqueid='$user'";
$retval = mysql_query( $query, $con );
$count = mysql_num_rows($retval);

if($count==0){
  die('Data Not Found Please contact SEPG');
}
    
while($row = mysql_fetch_assoc($retval)){ 
  echo "</br>";
  echo "</br>";
  echo "</br>";
  echo "<h3>"."Hi ".$row['username']." ! Welcome To Ticket Log Interface."."</h3>";
  $username=$row['username'];
  $email=$row['email'];
}
	
  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  
    $errorMessage   = "";    
    $successMessage = "";    
    $max_filesize = 1048576; //Maximum filesize in BYTES (currently 1MB).
    $upload_path = './support/'; //The place the files will be uploaded to (currently a 'files' directory).
     
    $ticket = htmlentities(addslashes($_POST['ticket']), ENT_QUOTES | ENT_IGNORE, "UTF-8");
    
  	$user = $_POST['user'];
    
    if( isset($_POST['requestedby']) && !empty($_POST['requestedby']) ){
      $requested_by = $_POST['requestedby'];
    }else{
      $requested_by = 'kpmg_01';
    }
    
    if( isset($_POST['officialemail']) && !empty($_POST['officialemail']) ){
      $official_email = $_POST['officialemail'];
    }else{
      $official_email = '';
    }
            
    $filename = $_FILES['userfile']['name']; //Get the name of the file (including file extension).

    $ADate = date('Y-m-d H:i:s', time());
	
   if($filename<>""){
     //Now check the filesize, if it is too large then DIE and inform the user.
     if(filesize($_FILES['userfile']['tmp_name']) > $max_filesize)
     $errorMessage .= "The file you attempted to upload is too large.<br>";
   
     //Check if we can upload to the specified path, if not DIE and inform the user.
     if(!is_writable($upload_path))
     $errorMessage .= "You cannot upload to the specified directory, please CHMOD it to 777.";
     
     
     $date = date('m/d/Y h:i:s a', time());
     $mydate = date('Y-m-d h:i:s', time());
     $values = explode(" ", $date);
     $dates = explode("/", $values[0]);
     $times = explode(":", $values[1]);
     $timex=$dates[1]."_".$dates[0]."_".$dates[2]."_"."T".$times[0]."_".$times[1]."_".$times[2];
     $fstr=$user."_".$timex.$ext;
  
      if(move_uploaded_file($_FILES['userfile']['tmp_name'], $upload_path . $fstr)){
        $successMessage .= 'Your file '.$filename.' has been uploaded successfully. You can view the uploaded file <a href="' . $upload_path . $fstr . '" title="Your File">here</a>';
      }
    }else{
      $successMessage .= "Click on Show All Issues to see all the tickets";
    }	
		
    if( empty($errorMessage) ){
      $cquery = "insert into ticket(user, ticket, timestamp, requestedby, officialemail, filepath, status, statusreason, rootcause, subrootcause, worklog, assignee, priority, lastmodifiedon, lastmodifiedby) values('$user', '$ticket', '$ADate', '$requested_by', '$official_email', '$fstr', 2, 2, 2, 2, 'dsfsfsdf', 'Sunil Kumar', priority, '$ADate', '$requested_by')";
      
    	if(mysql_query($cquery, $con)){    
        $IncidentNo = mysql_insert_id();
              		
    		$str  = '<html><body>';
    		$str .= '<h4>Dear Support Team</h4>';
    		$str .= '<h5>Please Find Ticket</h5>';
    		$str .= '<table border=1>';
    		$str .= '<tr><th>Incident No.</th><th>Notes</th><th>Reported Date</th><th>Requested By</th><th>Email ID</th></tr>';
    		$str .= '<tr>';
    		$str .= "<td>".$IncidentNo."</td>";
    		$ticket=str_replace('\n',"&#10;",$ticket); $task=str_replace('\r'," ",$ticket);
    		$str .= "<td>".stripslashes($ticket)."</td>";
    		$str .= "<td>".$ADate."</td>";
    		$str .= "<td>".$requested_by."</td>";
    		$str .= "<td>".$official_email."</td>";            
    		$str .= '</tr>';
    		$str .= '</table>';
    		$str .= 'Thanks and Regards';
    		$str .= '</body></html>';
            
  		  $delhead = "anuradhaj@gc-solutions.net";        
    		$sone    = "somilg@gc-solutions.net";
    		$stwo    = "santoshk@gc-solutions.net";
    		$sthree  = "shalup@gc-solutions.net";
    		$sfour   = "sachinp@gc-solutions.net";
    		$testing = "debasisp@gc-solutions.net";
    		
    		$mailer = new phpmailer();
    		$mailer->IsSMTP();
    		$mailer->IsHTML(true);
    
    		$mailer->Host     = "smtp.emailsrvr.com";
    		$mailer->Username = "sepg@gc-solutions.net";
    		$mailer->Password = "pass@12";
    
    		$mailer->SMTPAuth  = true;
    		$mailer->SMTPDebug = false;
    
    		$email            ="somilg@gc-solutions.net";
    		$mailer->From     = $official_email;
    		$mailer->FromName = $user;
    	  
    		$mailer->AddAddress($sone);
    		$mailer->AddAddress($stwo);
    		$mailer->AddAddress($sthree);
    		//$mailer->AddAddress($sfour);
    		$mailer->AddAddress($testing);
    		$mailer->AddCC($delhead, 'Del Head');
        $mailer->AddCC($sfour, 'Dept Head'); 
    		
    		$mailer->Subject = "Wizdom Web Support - Incident No : " . $IncidentNo;
    		$mailer->Body    = $str;
    	
    		$mailer->Send();
    		echo $mailer->ErrorInfo."<br/>"; 
    
    		//$message="Request # " . $IncidentNo . " has been created successfully. Now click on Show All Issues button to get the Ticket Number";
    		header ("Location: logticket.php?message=".urlencode($successMessage));
        
    	}else{
        $message="Row couldn't be created";
      }
    }else{
    		header ("Location: logticket.php?message=".urlencode($errorMessage));    
    }
}
	?>
<html>
  <head>
<style type="text/css">
  body {
    background:url('qcr.jpg') no-repeat;
  }
  .button {
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
  
.table_text {
	font-family: Calibri;
	font-size: 12px;
	font-style: normal;
	line-height: normal;
	font-weight: normal;
	font-variant: normal;
	color: #000000;
	text-indent: 10px;
	vertical-align: middle;
}  
</style>
      
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />    
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>    
<script type="text/javascript" src="js/jquery.validate.js"></script>
    
<script type="text/javascript">
function showAll(){
  var user = trim(document.getElementById('user').value);  
  if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  }else{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function(){
    if (xmlhttp.readyState==4 && xmlhttp.status==200){
      document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
  user=encodeURIComponent(user);
  xmlhttp.open("GET", "colsup.php?q="+user, true);
  xmlhttp.send();
}

function trim(s){
	return rtrim(ltrim(s));
}

function ltrim(s){
	var l=0;
	while(l < s.length && s[l] == ' ')
	{	l++; }
	return s.substring(l, s.length);
}

function rtrim(s){
	var r=s.length -1;
	while(r > 0 && s[r] == ' ')
	{	r-=1;	}
	return s.substring(0, r+1);
}

</script>    
</head>
<body>

<?php
$message=$_REQUEST["message"];
?>
<script language="JavaScript" src="datetimepicker.js"></script>
<?php 
  if( isset($_REQUEST["message"]) && !empty($_REQUEST["message"]) ){
?> 
<table cellpading="0" cellspacing="0" class="table_text">
  <tr>
    <td valign="top">
      <font color="red"><?php echo $_REQUEST["message"]; ?></font>
    </td>
  </tr>
</table>
<?php
  }
?>
<form name="tstest" id="tstest" enctype="multipart/form-data" method="post" action="" accept-charset="utf-8">
  <table class="table_text">
    <tr>
      <td valign="top">Ticket</td>
      <td><textarea name="ticket" id="ticket" rows="6" cols="30" maxlength="700" class="required" title="<font color='red'>Please enter ticket.</font>"><?php echo $_POST['ticket']; ?></textarea>      
      </td>
    </tr>
	<TR>
		<TD valign="top">Select a file:</TD>
    <TD><input type="file" name="userfile" id="userfile" size="35" title="<font color='red'>This field is required with a valid extension.</font>" accept="doc|docx|xls|xlsx|jpg|jpeg|png|bmp|gif|msg" class="required" /> <font color="grey">&nbsp;&nbsp;&nbsp;&nbsp;Accepted file format: .doc, .docx, .xls, .xlsx, .jpg, .jpeg, .png, .bmp, .gif, .msg. Size up to 1MB.</font>    
    </TD>
	</TR>
    <tr>
      <td valign="top">Requested by</td>
      <td><input type="text" name="requestedby" id="requestedby" maxlength="50" size="30" class="required" title="<font color='red'>Please enter your name.</font>"></td>
    </tr>
    <tr>
      <td valign="top">Email ID</td>
      <td><input type="text" name="officialemail" id="officialemail" maxlength="50" size="30" class="required" email="true" title="<font color='red'>Enter valid email address.<br>&nbsp;&nbsp;&nbsp;&nbsp;For example mail_id@domain.com.</font>" value="<?php echo $email;?>"></td>
    </tr>        
  </table>
  <br>
  <?php
  echo "<input type ='hidden' id='user' value='$username' name='user'>";
  ?>
  <!--<input type="button" class="button" value="Log Out" onclick="location.href='slogout.php';">-->
  <!--<input type="Submit" class="button" value="Submit the Ticket">-->
  <input type="submit" name="saveTicket" value="Submit the Ticket" class="button" />  
  <input type="button" class="button" value="Show All Issues" onClick="showAll()">
  <input type="button" class="button" value="Log Out" onclick="location.href='supportlogout.php';">
  <button type="reset" id="reset_frm" name="Reset" size="20" class="button" value="Reset">Reset</button>  
</form>
<script type="text/javascript">

$(document).ready(function() {
	var validator	=	$("#tstest").validate();
	validator.resetForm();
	$("#reset_frm").click(function() {
		validator.resetForm();
	});
});

</script>
<br />
<div id="txtHint"><?php echo $message;?></div>
</body>
</html> 