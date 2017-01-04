<html>
<head>
<title>Change ticket details</title>
<?php	
	error_reporting(0);
	session_start();
	
$query_string = explode("&", $_SERVER['QUERY_STRING'], 2);
$finalqs = $query_string[1];
if( isset($_POST['querystring']) && !empty($_POST['querystring']) ){
  $finalqs = $_POST['querystring'];
}
//if( isset($_GET['querystring']) && !empty($_GET['querystring']) ){
//  $finalqs = $_GET['querystring'];
//}  
  
  include 'datediff.php';  
  
	if(!(isset($_SESSION['login']) && $_SESSION['login'] != '')){
	 header ("Location:index.php");
  }
  $user = $_SESSION['login'];
  	
  include("config.php");

  $query = "select username, uid from login where uniqueid='$user'";
  $retval = mysql_query($query, $con);
  $count = mysql_num_rows($retval);
	
  if($count==0){
    die('Data Not Found Please contact SEPG');
  }

  while($row = mysql_fetch_assoc($retval)){ 
    echo "</br>";
    echo "</br>";
    echo "</br>";
    echo "<h4>" . "Hi " . $row['username'] . " ! Welcome to Ticket Updation" . "</h4>";
    $username = $row['username'];
    $uid      = $row['uid'];    
  } 	

if( ($_SERVER['REQUEST_METHOD'] == 'POST') ){

  if( isset($_POST["gotocancel"]) && ($_POST["gotocancel"] == 'Back') ){
		$message = "Updation has been canceled.";     
    echo "<script>window.location.href='manageticket.php?message=".urlencode($message)."&".$finalqs."'</script>";
    exit;  
  }
  
  $t_id = $_POST["t_id"];
  $selectTicketInfoBefareUpdate = "SELECT ticket, assignee, priority, status, statusreason, rootcause, subrootcause, worklog FROM ticket WHERE id = $t_id";                                     
  $queryTicketInfoBefareUpdate = mysql_query($selectTicketInfoBefareUpdate);   
  $fetchTicketInfoBefareUpdate = mysql_fetch_array($queryTicketInfoBefareUpdate);  

  if( isset($_POST['reopen']) && ($_POST['reopen']=='open it') ){
    $t_id  = $_POST["t_id"];
    $query = "UPDATE `ticket` SET `status`=1, `reopendate`='".time()."', `statusreason`=0, `rootcause`=0, `subrootcause`=0 WHERE `id`=".$t_id;
    mysql_query($query); 
    
    $summary = ""; 
    $summary .= "Ticket \'".$fetchTicketInfoBefareUpdate['ticket']."\' have been reopened successfully.\n";
  
    $insertLog = "insert into tbl_ticket_log(ticket_id, modify_time, modified_by, summary) values($t_id, ".time().", $uid, '$summary')";    
  	mysql_query($insertLog);
    $logLastInsertId = mysql_insert_id();    
    
		$message="Record has been reopened successfully."; 

    echo "<script>window.location.href='manageticket.php?message=".urlencode($message)."&".$finalqs."'</script>";
    exit;     
  }else{

  $t_id         = $_POST["t_id"];
  $assignee     = $_POST["assignee"];
  $priority     = $_POST["priority"];      
  $status       = $_POST["status"];
  $statusreason = $_POST["statusreason"];
  $rootcause    = $_POST["rootcause"];  
  $subrootcause = $_POST["subrootcause"];    
  $worklog      = mysql_real_escape_string($_POST["worklog"]);
  $MDate        = date('Y-m-d H:i:s', time());  
  
  if(($fetchTicketInfoBefareUpdate['status'] == 4) || ($fetchTicketInfoBefareUpdate['status'] == 5) || ($fetchTicketInfoBefareUpdate['status'] == 6)){  
    $query="UPDATE `ticket` SET `status`='".$status."', 
    `lastmodifiedon`='".$MDate."',
    `lastmodifiedby`='".$username."'
    WHERE `id`=".$t_id;
  }else{
    $query="UPDATE `ticket` SET `assignee`='".$assignee."',
    `priority`='".$priority."',
    `status`='".$status."',
    `statusreason`='".$statusreason."',
    `rootcause`='".$rootcause."',
    `subrootcause`='".$subrootcause."',
    `worklog`='".$worklog."',
    `lastmodifiedon`='".$MDate."',
    `lastmodifiedby`='".$username."'
    WHERE `id`=".$t_id;
  }  
//echo 'Debugging1';
//die;
/////////////////////////////////////////  
    $errorMessage   = "";    
    $successMessage = "";    
    $max_filesize   = 1048576; //Maximum filesize in BYTES (currently 1MB).
    $upload_path    = './support/'; //The place the files will be uploaded to (currently a 'files' directory).
    $filename       = $_FILES['userfile']['name']; //Get the name of the file (including file extension).
    
    if($filename<>""){
//echo $finalqs;
//die;    
      $ext = substr($filename, strpos($filename, '.'), strlen($filename)-1); //Get the extension from the filename.
      //Now check the filesize, if it is too large then DIE and inform the user.
      if(filesize($_FILES['userfile']['tmp_name']) > $max_filesize)
      $errorMessage .= "The file you attempted to upload is too large.<br>";
      
      //Check if we can upload to the specified path, if not DIE and inform the user.
      if(!is_writable($upload_path))
      $errorMessage .= "You cannot upload to the specified directory. Please CHMOD it to 777.";
      
      $date   = date('m/d/Y h:i:s a', time());
      $mydate = date('Y-m-d h:i:s', time());
      $values = explode(" ", $date);
      $dates  = explode("/", $values[0]);
      $times  = explode(":", $values[1]);
      $timex  = $dates[1]."_".$dates[0]."_".$dates[2]."_"."T".$times[0]."_".$times[1]."_".$times[2];
      $fstr   = $username."_".$timex.$ext;
      
      if(empty($errorMessage)){
//echo "3".$finalqs;
//die;      
        if( !move_uploaded_file($_FILES['userfile']['tmp_name'], $upload_path . $fstr) ){
//echo "4".$finalqs;
//die;        
          $errorMessage .= 'Due to unknown reason, your file '.$filename.' has not been uploaded and also, other records are not saved in database. Please try again.';
          header ("Location: editticket.php?errorMessage=".urlencode($errorMessage)."&".$finalqs."&tid=".base64_encode($t_id));
          exit;          
        }
      }else{
//echo "5".$finalqs;
//die;      
        header ("Location: editticket.php?errorMessage=".urlencode($errorMessage)."&".$finalqs."&tid=".base64_encode($t_id));
        exit;
      }      
    }    
    
/////////////////////////////////////////////////
    if(empty($errorMessage)){
      if(mysql_query($query)){
        $selectTicketInfoAfterUpdate = "SELECT tckt.assignee, tckt.worklog, prty.priority_name, ts.status_name, tsr.sr_name, rc.rc_name, src.src_name 
                             FROM ticket AS tckt  
                             LEFT JOIN priority AS prty ON tckt.priority = prty.priority_id 
                             LEFT JOIN tbl_status AS ts ON tckt.status = ts.status_id                                    
                             LEFT JOIN tbl_status_reason AS tsr ON tckt.statusreason = tsr.sr_id 
                             LEFT JOIN rootcause AS rc ON tckt.rootcause = rc.rc_id 
                             LEFT JOIN subrootcause AS src ON tckt.subrootcause = src.src_id 
                             WHERE tckt.id = $t_id 
                            ";                                                           
        $queryTicketInfoAfterUpdate = mysql_query($selectTicketInfoAfterUpdate);  
        $fetchTicketInfoAfterUpdate = mysql_fetch_array($queryTicketInfoAfterUpdate);    
      
        $summary = ""; 
        $summary .= ( $fetchTicketInfoBefareUpdate['assignee'] != $assignee ) ? "Assignee have been changed with ".$fetchTicketInfoAfterUpdate['assignee'].".\n" : "";
        $summary .= ( $fetchTicketInfoBefareUpdate['priority'] != $priority ) ? "Priority have been changed with ".$fetchTicketInfoAfterUpdate['priority_name'].".\n" : "";
        $summary .= ( $fetchTicketInfoBefareUpdate['status'] != $status ) ? "Status have been changed with ".$fetchTicketInfoAfterUpdate['status_name'].".\n" : "";
        $summary .= ( $fetchTicketInfoBefareUpdate['statusreason'] != $statusreason ) ? "Status reason have been changed with ".$fetchTicketInfoAfterUpdate['sr_name'].".\n" : "";
        $summary .= ( $fetchTicketInfoBefareUpdate['rootcause'] != $rootcause ) ? "Root cause have been changed with ".$fetchTicketInfoAfterUpdate['rc_name'].".\n" : "";
        $summary .= ( $fetchTicketInfoBefareUpdate['subrootcause'] != $subrootcause ) ? "Sub root cause have been changed with ".$fetchTicketInfoAfterUpdate['src_name'].".\n" : "";
        $summary .= ( $fetchTicketInfoBefareUpdate['worklog'] != $worklog ) ? "Work log have been changed with ".$fetchTicketInfoAfterUpdate['worklog'].".\n" : "";
      
        $insertLog = "insert into tbl_ticket_log(ticket_id, modify_time, modified_by, summary, filepath) values($t_id, ".time().", $uid, '$summary', '".$fstr."')";    
      	mysql_query($insertLog);
        $logLastInsertId = mysql_insert_id();  
      
    		$message="Record has been updated."; 
        echo "<script>window.location.href='manageticket.php?message=".urlencode($message)."&".$finalqs."'</script>";
        exit;
      }else{
        echo "Row Not Updated";
        die(mysql_error());
      }	
     }else{
      echo "<script>window.location.href='editticket.php?errorMessage=".urlencode($errorMessage)."&tid=".base64_encode($t_id)."'</script>";
      exit;
     }  
}  
}

$selectTicketInfo = "select * from ticket where id='".base64_decode($_REQUEST['tid'])."'";
$queryTicketInfo = mysql_query($selectTicketInfo);
if(!(mysql_num_rows($queryTicketInfo))){
echo "5".$finalqs;
die; 
  header("Location:manageticket.php?".$finalqs);
}else{
  $fetchTicketInfo = mysql_fetch_array($queryTicketInfo);
  
  $ADate = date('Y-m-d', (time()-86400));
  $times = $fetchTicketInfo['timestamp'];
  $times = strtotime($times);
  $times = date('Y-m-d', $times);
  if( ($fetchTicketInfo['status'] == 4) || ($fetchTicketInfo['status'] == 5) || ($fetchTicketInfo['status'] == 6) ){  
    $diff      = 0;
    $dsbleCond = true;
  }else{
    $diff      = getWorkingDays($times, $ADate, $holidays);  
    $dsbleCond = false;
  } 
  
  $client           = $fetchTicketInfo["user"];
  $incidentid       = $fetchTicketInfo["id"];
  $assignee         = $fetchTicketInfo["assignee"];      
  $notes            = $fetchTicketInfo["ticket"];
  $priority         = $fetchTicketInfo["priority"];
  $submitdate       = $fetchTicketInfo["timestamp"];
  $pendingdays      = round($diff,2);
  $filepath         = $fetchTicketInfo["filepath"];  
  $status           = $fetchTicketInfo["status"];
  $statusreason     = $fetchTicketInfo["statusreason"];
  $rootcause        = $fetchTicketInfo["rootcause"];  
  $subrootcause     = $fetchTicketInfo["subrootcause"];  
  $worklog          = $fetchTicketInfo["worklog"];  
  $reportedby       = $fetchTicketInfo["requestedby"];
  $lastmodifieddate = $fetchTicketInfo["lastmodifiedon"];      
  $lastmodifiedby   = $fetchTicketInfo["lastmodifiedby"];  
}

?>
<style>
div.ex{
  height:350px;
  width:600px;
  background-color:white;
}

textarea.hide{
  visibility:none;
  display:none;
}

body{
  background:url('qcr.jpg') no-repeat;
}

.button{
  background-color: #F7941C;
  border-bottom:#F7941C;
  border-left: #F7941C;
  border-right:#F7941C;
  border-top: #F7941C;
  color: black;
  font-family: Tahoma
  box-shadow:2px 2px 0 0 #014D06,;
  border-radius: 10px;
  border: 1px outset #b37d00;
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
<script type="text/javascript" language="javascript">
function test(){

  var assignee = trim(document.getElementById('assignee').value);
  if(assignee=="Select"){alert("Please select the assignee."); return false;};
  
  var priority = trim(document.getElementById('priority').value);
  if(priority=="Select"){alert("Please select the priority."); return false;};

  var status = trim(document.getElementById('status').value);
  if(status=="Select"){alert("Please select the status."); return false;};
  
  if(status=="1"){
    var statusreason = trim(document.getElementById('statusreason').value);
    if(statusreason=="Select"){alert("Please select the status reason."); return false;};
  }
  
  if(status=="4"){  
    var rootcause = trim(document.getElementById('rootcause').value);
    if(rootcause=="Select"){alert("Please select the root cause."); return false;};
    
    var subrootcause = trim(document.getElementById('subrootcause').value);
    if(subrootcause=="Select"){alert("Please select the sub root cause."); return false;};        
  }
  
  var userfile = trim(document.getElementById('userfile').value);
  if(userfile!=""){
    var haystack = ["doc", "docx", "xls", "xlsx", "jpg", "jpeg", "png", "bmp", "gif", "msg"];
    var ext = userfile.split(".");
    var fileExt = ext[1];
    var posext = haystack.indexOf(fileExt);
    if( posext == -1){
      alert("This field is required with a valid extension.");
      return false;
    }
  }  
  
  //var worklog = trim(document.getElementById('worklog').value);
  //if(worklog==""){alert("Please give work log."); return false;};
  
  document.forms["tstest"].submit();
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

<body background="bg.gif">
<?php 
$message = "";  
$color   = "";

if( isset($_REQUEST["successMessage"]) && !empty($_REQUEST["successMessage"]) ){
  $message = $_REQUEST["successMessage"];  
  $color   = "green";    
}elseif( isset($_REQUEST["errorMessage"]) && !empty($_REQUEST["errorMessage"]) ){
  $message = $_REQUEST["errorMessage"];  
  $color   = "red";  
}

if( !empty($message) ){
?> 
<table cellpading="0" cellspacing="0" class="table_text">
  <tr>
    <td valign="top">
      <font color="<?php echo $color; ?>"><?php echo $message; ?></font>
      <br />
      <br />
    </td>
  </tr>  
</table>
<?php
}
?>
<form name="tstest" action="" method="post" enctype="multipart/form-data">
  <input type="hidden" id="t_id" name="t_id" value="<?php echo base64_decode($_REQUEST['tid']); ?>">  
  <input type="hidden" id="querystring" name="querystring" value="<?php echo $finalqs; ?>">
  <TABLE class="table_text">
    <TR>
    	<TD>Client : </TD>
    	<td><?php echo ( !empty($client) ) ? ucwords($client) : "None"; ?></td>
    </TR>
    
    <TR>
    	<TD>Incident ID : </TD>
    	<td><?php echo ( !empty($incidentid) ) ? $incidentid : "None"; ?></td>
    </TR>
    
    <TR>
    	<TD>Assignee : </TD>
    	<td>
        <select name='assignee' id='assignee' style="width:200px;" <?php echo ($dsbleCond) ? "disabled='true'" : ""; ?> > 
          <option selected value='Select'>Select</option>      
      <?php
        $selectAssignee = "select username from login where role='DEV' and dept='LMS'";
        $queryAssignee = mysql_query($selectAssignee, $con);
        $numrowsAssignee = mysql_num_rows($queryAssignee);
        
        if($numrowsAssignee==0){
          die('IDs Not Found; Contact SEPG');
        }
        if(mysql_num_rows($queryAssignee)){ 
          while($fetchAssignee = mysql_fetch_assoc($queryAssignee)){ 
            if(strlen($fetchAssignee['username'])<>0){
            ?>
            <option value='<?php echo $fetchAssignee['username']; ?>' <?php if($assignee==$fetchAssignee['username'])echo " selected"; ?>><?php echo ucwords($fetchAssignee['username']); ?></option> 
            <?php 
            }
          } 
        }else{
          echo "<option>No assignee</option>";  
        } 
      ?>
      </select>
      </td>
    </TR>
    
    <TR>
    	<TD>Notes : </TD>
    	<td><textarea rows="4" cols="30" disabled="true"><?php echo ( !empty($notes) ) ? ucfirst($notes) : "N/A"; ?></textarea></td>
    </TR>
    
    <TR>
    	<TD>Priority : </TD>
    	<td>
        <select name='priority' id='priority' style="width:200px;" <?php echo ($dsbleCond) ? "disabled='true'" : ""; ?> > 
        <option selected value='Select'>Select</option>      
        <?php
          $selectPriority = "select * from priority";
          $queryPriority = mysql_query($selectPriority);
          $numrowsPriority = mysql_num_rows($queryPriority);
          
          if(mysql_num_rows($queryPriority)){ 
            while($fetchPriority = mysql_fetch_assoc($queryPriority)){ 
              if( !empty($fetchPriority['priority_id']) ){
              ?>
              <option value="<?php echo $fetchPriority['priority_id']; ?>" <?php echo ($priority==$fetchPriority['priority_id']) ? " selected" : ""; ?> ><?php echo ucwords($fetchPriority['priority_name']); ?></option> 
              <?php 
              }
            } 
          }else{
            echo "<option>No priorities</option>";  
          }
        ?>
        </select>
      </td>
    </TR>                
    
    <TR>
    	<TD>Submit Date : </TD>
    	<td><?php echo ( !empty($submitdate) ) ? $submitdate : "N/A"; ?></td>
    </TR>
    
    <TR>
    	<TD>Pending Days : </TD>
    	<td><?php echo ( !empty($pendingdays) ) ? $pendingdays : "0"; ?></td>
    </TR>
    
    <TR>
    	<TD>Status : </TD>
    	<td>
        <select name='status' id='status' style="width:200px;" > 
        <option selected value='Select'>Select</option>      
        <?php
          $selectStatus = "select * from tbl_status";
          $queryStatus = mysql_query($selectStatus);
          $numrowsStatus = mysql_num_rows($queryStatus);
          
          if(mysql_num_rows($queryStatus)){ 
            while($fetchStatus = mysql_fetch_assoc($queryStatus)){ 
              if( !empty($fetchStatus['status_id']) ){
              ?>
              <option value="<?php echo $fetchStatus['status_id']; ?>" <?php echo ($status==$fetchStatus['status_id']) ? " selected" : ""; ?> ><?php echo ucwords($fetchStatus['status_name']); ?></option> 
              <?php 
              }
            } 
          }else{
            echo "<option>No status</option>";  
          }
        ?>
        </select>
      </td>
    </TR> 
    
    <TR>
    	<TD>Status Reason : </TD>
    	<td>
        <select name='statusreason' id='statusreason' style="width:200px;" <?php echo ($dsbleCond) ? "disabled='true'" : ""; ?> > 
          <option selected value='Select'>Select</option>      
          <?php
            $selectStatusReason = "select * from tbl_status_reason";
            $queryStatusReason = mysql_query($selectStatusReason);
            $numrowsStatusReason = mysql_num_rows($queryStatusReason);
            
            if(mysql_num_rows($queryStatusReason)){ 
              while($fetchStatusReason = mysql_fetch_assoc($queryStatusReason)){ 
                if( !empty($fetchStatusReason['sr_id']) ){
                ?>
                <option value="<?php echo $fetchStatusReason['sr_id']; ?>" <?php echo ($statusreason==$fetchStatusReason['sr_id']) ? " selected" : ""; ?> ><?php echo ucwords($fetchStatusReason['sr_name']); ?></option> 
                <?php 
                }
              } 
            }else{
              echo "<option>No status reason</option>";  
            }
          ?>
        </select>      
      </td>
    </TR>
    
    <TR>
    	<TD>Root Cause : </TD>
    	<td>
        <select name='rootcause' id='rootcause' style="width:200px;" <?php echo ($dsbleCond) ? "disabled='true'" : ""; ?> > 
        <option selected value='Select'>Select</option>      
        <?php
          $selectRootClause = "select * from rootcause";
          $queryRootClause = mysql_query($selectRootClause);
          $numrowsRootClause = mysql_num_rows($queryRootClause);
          
          if(mysql_num_rows($queryRootClause)){ 
            while($fetchRootClause = mysql_fetch_assoc($queryRootClause)){ 
              if(strlen($fetchRootClause['rc_id'])<>0){
              ?>
              <option value="<?php echo $fetchRootClause['rc_id']; ?>" <?php if($rootcause==$fetchRootClause['rc_id'])echo " selected"; ?> ><?php echo ucwords($fetchRootClause['rc_name']); ?></option> 
              <?php 
              }
            } 
          }else{
            echo "<option>No root causes</option>";  
          }
        ?>
        </select>      
      </td>
    </TR>
    
    <TR>
    	<TD>Sub Root Cause : </TD>
    	<td>
        <select name='subrootcause' id='subrootcause' style="width:200px;" <?php echo ($dsbleCond) ? "disabled='true'" : ""; ?> > 
          <option selected value='Select'>Select</option>      
          <?php
            $selectSubRootClause = "select * from subrootcause";
            $querySubRootClause = mysql_query($selectSubRootClause);
            $numrowsSubRootClause = mysql_num_rows($querySubRootClause);
            
            if(mysql_num_rows($querySubRootClause)){ 
              while($fetchSubRootClause = mysql_fetch_assoc($querySubRootClause)){ 
                if(strlen($fetchSubRootClause['src_id'])<>0){
                ?>
                <option value="<?php echo $fetchSubRootClause['src_id']; ?>" <?php if($subrootcause==$fetchSubRootClause['src_id'])echo " selected"; ?> ><?php echo ucwords($fetchSubRootClause['src_name']); ?></option> 
                <?php 
                }
              } 
            }else{
              echo "<option>No sub root causes</option>";  
            }
          ?>
        </select>      
      </td>
    </TR>
    
    <TR>
    	<TD>Work Log : </TD>
    	<td><textarea name='worklog' id='worklog' rows='4' cols='30' <?php echo ($dsbleCond) ? "disabled='true'" : ""; ?> ></textarea></td>
    </TR>
    
    <TR>
    	<TD>Reported By : </TD>
    	<td><?php echo ( !empty($reportedby) ) ? $reportedby : "None"; ?></td>
    </TR>
    
    <TR>
    	<TD>Last Modified Date : </TD>
    	<td><?php echo ( !empty($lastmodifieddate) ) ? $lastmodifieddate : "N/A"; ?></td>
    </TR>
    
    <TR>
    	<TD>Last Modified By : </TD>
    	<td><?php echo ( !empty($lastmodifiedby) ) ? $lastmodifiedby : "None"; ?></td>
    </TR>
    
    <TR>
    	<TD>File : </TD>
    	<td><?php echo ( !empty($filepath) ) ? '<a href="support/' . $filepath . '" title="Your File">' . $filepath . '</a>' : 'N/A'; ?></td>
    </TR>
    
  	<TR>
  		<TD valign="top">Select a file:</TD>
      <TD><input type="file" name="userfile" id="userfile" size="35" <?php echo ($dsbleCond) ? "disabled='true'" : ""; ?> /> <font color="grey">&nbsp;&nbsp;&nbsp;&nbsp;Accepted file format: .doc, .docx, .xls, .xlsx, .jpg, .jpeg, .png, .bmp, .gif, .msg. Size up to 1MB.</font>    
      </TD>
  	</TR>

    <?php if( ($fetchTicketInfo['status'] == 4) || ($fetchTicketInfo['status'] == 6) ){ ?>
    <TR>
      <TD>Re-open ticket : </TD>
      <TD><input type="checkbox" name="reopen" id="reopen" value="open it"></TD>
    </TR>
    <?php } ?>
    
  </TABLE>
  <br />
<div style="width:60%; height:235; overflow-y:auto;">
  <table width="100%" cellspacing="0" cellpading="0" border="1" class="table_text">
    <tr>
      <th>Modified Date/Time</th>
      <th>Modified By</th>
      <th>Action</th>
      <th>File</th>
    </tr>
<?php
$selectLogInfo = "SELECT ttl.*, ticket.ticket, login.username FROM tbl_ticket_log AS ttl 
                           INNER JOIN ticket ON ttl.ticket_id = ticket.id 
                           INNER JOIN login ON ttl.modified_by = login.uid 
WHERE ttl.ticket_id = ".base64_decode($_REQUEST['tid'])." ORDER BY ttl.modify_time DESC";
$queryLogInfo = mysql_query($selectLogInfo);
$numrowsLogInfo = mysql_num_rows($queryLogInfo);
if( !empty($numrowsLogInfo) ){
  while( $fetchLogInfo = mysql_fetch_array($queryLogInfo) ){
?>
    <tr>
      <td align='center'><?php echo ( !empty($fetchLogInfo['modify_time']) ) ? date("m/d/Y h:i A", $fetchLogInfo['modify_time']) : "N/A"; ?></td>
      <td align='center'><?php echo ( !empty($fetchLogInfo['username']) ) ? $fetchLogInfo['username'] : "N/A"; ?></td>
      <td align='center'><a href="JavaScript:newPopup('ticketlogdetails.php?logid=<?php echo $fetchLogInfo['id']; ?>');">View</a></td>
      <td align='center'><?php echo ( !empty($fetchLogInfo['filepath']) ) ? '<a href="support/' . $fetchLogInfo['filepath'] . '" title="Your File">' . $fetchLogInfo['filepath'] . '</a>' : 'N/A'; ?></td>
    </tr>
<?php  
  }
}else{
  echo "<tr><td colspan='3' align='center'>No logs for this ticket.</td></tr>";
}
?>
    
  </table>
</div>  
  <br />
  <?php if($fetchTicketInfo['status'] != 5){ ?>
  <input type="button" name="gotoupdate" class="button" value="Submit" onclick="test();">
  <?php } ?>
  <input type="submit" name="gotocancel" class="button" value="Back">
  <input type="button" name="gotologout" class="button" value="Log Out" onclick="location.href='logout.php';">
  <br />
  <br />
</form>
<script type="text/javascript">
function newPopup(url) {
	popupWindow = window.open(
		url,'popUpWindow','height=350,width=820,left=550,top=230,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no')
}
</script>

</body>
</html> 