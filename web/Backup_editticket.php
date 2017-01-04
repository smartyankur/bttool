<html>
<head>
<title>Change ticket details</title>
<?php	
	error_reporting(0);
	session_start();
	
  include 'datediff.php';  
  
	if(!(isset($_SESSION['login']) && $_SESSION['login'] != '')){
	 header ("Location:index.php");
  }
  $user = $_SESSION['login'];
  	
  include("config.php");

  $query = "select username from login where uniqueid='$user'";
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
  } 	

if( ($_SERVER['REQUEST_METHOD'] == 'POST') ){

  if( isset($_POST["gotocancel"]) && ($_POST["gotocancel"] == 'Cancel') ){
		$message = "Updation has been canceled."; 
    echo "<script>window.location.href='manageticket.php?message=".urlencode($message)."'</script>";
    exit;  
  }

  $t_id         = $_POST["t_id"];
  $assignee     = $_POST["assignee"];    
  $status       = $_POST["status"];
  $statusreason = $_POST["statusreason"];
  $rootcause    = $_POST["rootcause"];  
  $subrootcause = $_POST["subrootcause"];    
  $worklog      = mysql_real_escape_string($_POST["worklog"]);
  $query="UPDATE `ticket` SET `assignee` = '".$assignee."',
`status` = '".$status."',
`statusreason` = '".$statusreason."',
`rootcause` = '".$rootcause."',
`subrootcause` = '".$subrootcause."',
`worklog` = '".$worklog."'
WHERE `id` = " . $t_id;

  if(mysql_query($query)){
		$message="Record has been updated."; 
    echo "<script>window.location.href='manageticket.php'</script>";
    exit;
  }else{
    echo "Row Not Updated";
    die(mysql_error());
  }	
}

$selectTicketInfo = "select * from ticket where id='".base64_decode($_REQUEST['tid'])."'";
$queryTicketInfo = mysql_query($selectTicketInfo);
if(!(mysql_num_rows($queryTicketInfo))){ 
  header("Location:lmsbt.php");
}else{
  $fetchTicketInfo = mysql_fetch_array($queryTicketInfo);
  
  $ADate = date('Y-m-d', time());
  $times = $fetchTicketInfo['timestamp'];
  $times = strtotime($times);
  $times = date('Y-m-d', $times);
  $diff  = getWorkingDays($times, $ADate, $holidays);
  
  $client           = $fetchTicketInfo["user"];
  $incidentid       = $fetchTicketInfo["id"];
  $assignee         = $fetchTicketInfo["assignee"];      
  $notes            = $fetchTicketInfo["ticket"];
  $priority         = $fetchTicketInfo["priority"];
  $submitdate       = $fetchTicketInfo["timestamp"];
  $pendingdays      = round($diff,2);
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
  
  var status = trim(document.getElementById('status').value);
  if(status=="Select"){alert("Please select the status."); return false;};
  
  var statusreason = trim(document.getElementById('statusreason').value);
  if(statusreason=="Select"){alert("Please select the status reason."); return false;};
  
  var rootcause = trim(document.getElementById('rootcause').value);
  if(rootcause=="Select"){alert("Please select the root cause."); return false;};
  
  var subrootcause = trim(document.getElementById('subrootcause').value);
  if(subrootcause=="Select"){alert("Please select the sub root cause."); return false;};        
  
  var worklog = trim(document.getElementById('worklog').value);
  if(worklog==""){alert("Please give work log."); return false;};
  
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
<form name="tstest" action="./editticket.php" onsubmit="return verify()" method="post" enctype="multipart/form-data">
  <input type="hidden" id="t_id" name="t_id" value="<?php echo base64_decode($_REQUEST['tid']); ?>">  
  <TABLE>
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
        <select name='assignee' id='assignee'> 
          <option size=30 selected value='Select'>Select</option>      
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
            <option <?php if($assignee==$fetchAssignee['username'])echo " selected"; ?>><?php echo ucwords($fetchAssignee['username']); ?></option> 
            <?php 
            }
          } 
        }else{
          echo "<option>No assignee</option>";  
        } 
      ?>
      </td>
    </TR>
    
    <TR>
    	<TD>Notes : </TD>
    	<td><?php echo ( !empty($notes) ) ? ucfirst($notes) : "N/A"; ?></td>
    </TR>
    
    <TR>
    	<TD>Priority : </TD>
    	<td><?php echo ( !empty($priority) ) ? ucwords($priority) : "None"; ?></td>
    </TR>                
    
    <TR>
    	<TD>Submit Date : </TD>
    	<td><?php echo ( !empty($submitdate) ) ? $submitdate : "N/A"; ?></td>
    </TR>
    
    <TR>
    	<TD>Pending Days : </TD>
    	<td><?php echo ( !empty($pendingdays) ) ? $pendingdays : "N/A"; ?></td>
    </TR>
    
    <TR>
    	<TD>Status : </TD>
    	<td>
        <select name="status" size="1" id="status">
          <option value="Select" selected>Select</option>
          <option value="high" <?php if($status=="high")echo " selected";?>>High</option>
          <option value="medium" <?php if($status=="medium")echo " selected";?>>Medium</option>
          <option value="low" <?php if($status=="low")echo " selected";?>>Low</option>
          <option value="none" <?php if($status=="none")echo " selected";?>>None</option>
        </select>      
      </td>
    </TR> 
    
    <TR>
    	<TD>Status Reason : </TD>
    	<td>
        <select name="statusreason" size="1" id="statusreason">
          <option value="Select" selected>Select</option>
          <option value="Pending Under Observation" <?php if($statusreason=="Pending Under Observation")echo " selected"; ?> >Pending Under Observation</option>
          <option value="Pending For Client Information" <?php if($statusreason=="Pending For Client Information")echo " selected"; ?> >Pending For Client Information</option>
          <option value="Pending For Closure Confirmation" <?php if($statusreason=="Pending For Closure Confirmation")echo " selected"; ?> >Pending For Closure Confirmation</option>
          <option value="Pending With Other Department" <?php if($statusreason=="Pending With Other Department")echo " selected"; ?> >Pending With Other Department</option>
          <option value="Pending For Web Session" <?php if($statusreason=="Pending For Web Session")echo " selected"; ?> >Pending For Web Session</option>          
        </select>      
      </td>
    </TR>
    
    <TR>
    	<TD>Root Cause : </TD>
    	<td>
        <select name='rootcause' id='rootcause'> 
        <option size=30 selected value='Select'>Select</option>      
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
        <select name='subrootcause' id='subrootcause'> 
          <option size=30 selected value='Select'>Select</option>      
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
    	<td><textarea name="worklog" rows="4" cols="30" id="worklog"><?php echo stripslashes($worklog); ?></textarea></td>
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
    
  </TABLE>
  <br />
  <input type="button" name="gotoupdate" class="button" value="Submit" onclick="test();">
  <input type="submit" name="gotocancel" class="button" value="Cancel">
  <input type="button" name="gotologout" class="button" value="Log Out" onclick="location.href='logout.php';">
  <br />
  <br />
</form>
</body>
</html> 