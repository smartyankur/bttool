<html>
<head>
<meta http-equiv="refresh" content="300">
<title>Manage Tickets</title>
<?php
include 'datediff.php';
error_reporting(0);
session_start();

if(!(isset($_SESSION['login']) && $_SESSION['login'] != '')){
  header ("Location:index.php");
}
$user = $_SESSION['login'];

include("config.php");
include_once("page.inc.php");

$query = "select username from login where uniqueid='$user'";
$retval = mysql_query( $query, $con );
$count = mysql_num_rows($retval);

if($count==0){
  die('Data Not Found Please contact SEPG');
}

while($row = mysql_fetch_assoc($retval)){ 
  echo "</br>";
  echo "</br>";
  echo "</br>";
  echo "<h4>" . "Hi " . $row['username'] . " ! Welcome to Manage Ticket Interface" . "</h4>";
  $username = $row['username'];
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qry_string = "";
$qry_string_paging = "";

if( isset($_GET['Search']) || isset($_GET['tassignee']) || isset($_GET['tstatus']) || isset($_GET['tclient']) || isset($_GET['tfromDate']) || isset($_GET['ttoDate']) ){	

$fromDate = date("Y-m-d 00:00:00", strtotime($_GET['tfromDate']));
$toDate   = date("Y-m-d 23:59:59", strtotime($_GET['ttoDate']));

  $whereclause = "";
  $qryArr  = array();
  $qryArr1 = array();  
  if( isset($_GET['tassignee']) && !empty($_GET['tassignee']) ){
    $qryArr[]  = "assignee='" . trim(urldecode($_GET['tassignee']), "'") . "'";
    $qryArr1[] = "tassignee=" . urlencode(trim($_GET['tassignee'], "'")) . "";    
  }
  
  if( isset($_GET['tstatus']) && !empty($_GET['tstatus']) ){    
    $qryArr[]  = "status='" . $_GET['tstatus'] . "'";
    $qryArr1[] = "tstatus=" . urlencode(trim($_GET['tstatus'], "'")) . "";
  }
  
  if( isset($_GET['tclient']) && !empty($_GET['tclient']) ){
    $qryArr[]  = "user='" . trim(urldecode($_GET['tclient']), "'") . "'";
    $qryArr1[] = "tclient=" . urlencode(trim($_GET['tclient'], "'")) . "";
  }  
    
  if( isset($_GET['tfromDate']) && isset($_GET['ttoDate']) && !empty($_GET['tfromDate']) && !empty($_GET['ttoDate']) ){
    $qryArr[]  = "timestamp BETWEEN '".$fromDate."' AND '".$toDate."'";
    $qryArr1[] = "tfromDate=" . urlencode(trim($_GET['tfromDate'], "'")) . "";    
    $qryArr1[] = "ttoDate=" . urlencode(trim($_GET['ttoDate'], "'")) . "";    
  }
    
  $qry = "SELECT tckt.*, prty.priority_name, ts.status_name, tsr.sr_name FROM ticket AS tckt 
                                   LEFT JOIN priority AS prty ON tckt.priority = prty.priority_id
                                   LEFT JOIN tbl_status AS ts ON tckt.status = ts.status_id                                   
                                   LEFT JOIN tbl_status_reason AS tsr ON tckt.statusreason = tsr.sr_id ";
                                     
  $whereClause = implode(" and ", $qryArr);   
  $qry_string = implode("&", $qryArr1);        
  		
  if( $whereClause != "" ){
  $qry .= "WHERE " . $whereClause;	
  }else{
  $qry .= "WHERE tckt.status NOT IN (4, 5, 6)";
  }
  
  $qry = $qry . $whereclause;    
} else {
  $qry = "SELECT tckt.*, prty.priority_name, ts.status_name, tsr.sr_name FROM ticket AS tckt 
                                   LEFT JOIN priority AS prty ON tckt.priority = prty.priority_id
                                   LEFT JOIN tbl_status AS ts ON tckt.status = ts.status_id                                   
                                   LEFT JOIN tbl_status_reason AS tsr ON tckt.statusreason = tsr.sr_id
                                   WHERE tckt.status NOT IN (4, 5, 6)";
}

// if( isset($_GET['sortby']) && !empty($_GET['sortby']) && isset($_GET['sortdirc']) && !empty($_GET['sortdirc']) ){
//   $qry = $qry . " ORDER BY " . $_GET['sortby'] . " " . $_GET['sortdirc'];
//   if( !empty($qry_string)){
//     $qry_string_paging .= "&sortby=" . $_GET['sortby'] . "&sortdirc=" . $_GET['sortdirc'];
//   }else{
//     $qry_string_paging .= "sortby=" . $_GET['sortby'] . "&sortdirc=" . $_GET['sortdirc'];  
//   }  
// } else {
//   $qry = $qry . " ORDER BY id DESC";
// }
  $qry = $qry . " ORDER BY id ASC";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
<script>
function testSearch(){
  var tfromDate = trim(document.getElementById('tfromDate').value);
  var ttoDate = trim(document.getElementById('ttoDate').value);
  
  if(tfromDate!=""){
    if(ttoDate==""){alert("Please select To date!"); return false;};
  }
  
  if(ttoDate!=""){
    if(tfromDate==""){alert("Please select From date!"); return false;};
  }
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
<script language="JavaScript" src="datetimepicker.js"></script>
<table width="80%" border="0" cellspacing="0" cellpadding="0" border="0">
<tr>
  <td>
  <?php 
    if( isset($_REQUEST["message"]) && ($_REQUEST["message"] <> "") ){
      echo $_REQUEST["message"];
    }
  ?>
  </td>  
</tr>
</table>
<form name="searchForm" method="GET" action="manageticket.php?module=reports" onsubmit="return testSearch()">
<table width="100%" border="0" cellspacing="0" cellpadding="0" border="0" class="table_text">
  <tr>
    <td>Assignee : </td>
  	<td>
      <select name="tassignee" id="tassignee">
      	<option value="">All</option>
      <?php
        $asg = '';                         
        $selectAssignee = "SELECT DISTINCT(assignee) FROM ticket WHERE assignee!='none' AND trim(assignee)!='' ORDER BY assignee ASC";
        $queryAssignee = mysql_query($selectAssignee);                          
        $numrowsAssignee = mysql_numrows($queryAssignee);
        if( !empty($numrowsAssignee) ){
          while( $fetchAssignee = mysql_fetch_array($queryAssignee) ){
          $asg = ( isset($_GET['tassignee']) && ($fetchAssignee['assignee'] == trim(urldecode($_GET['tassignee']), "'")) ) ? "selected='selected'" : "";
      ?>
      	<option value='<?php echo urlencode($fetchAssignee['assignee']); ?>' <?php echo $asg; ?> ><?php echo ucfirst($fetchAssignee['assignee']); ?></option>
      <?php                                                      
          }
        }
      ?>  
      	<option value="none" <?php echo ( isset($_GET['tassignee']) && ($_GET['tassignee'] == "none") ) ? "selected='selected'" : ""; ?> >Unassigned</option>
    	</select>
  	</td>
    <td>Status : </td>
  	<td>
      <select name="tstatus" id="tstatus" style="width:200px;"> 
      <option selected value="">All</option>      
      <?php
        $selectStatus = "select * from tbl_status";
        $queryStatus = mysql_query($selectStatus);
        $numrowsStatus = mysql_num_rows($queryStatus);
        
        if(mysql_num_rows($queryStatus)){ 
          while($fetchStatus = mysql_fetch_assoc($queryStatus)){ 
            $tst = ( isset($_GET['tstatus']) && ($fetchStatus['status_id'] == $_GET['tstatus']) ) ? "selected='selected'" : "";
            ?>
            <option value="<?php echo $fetchStatus['status_id']; ?>" <?php echo $tst; ?> ><?php echo ucwords($fetchStatus['status_name']); ?></option> 
            <?php 
          } 
        }
      ?>
      </select>
    </td>
    <td>Client : </td>
  	<td>
      <select name="tclient" id="tclient" style="width:200px;"> 
      	<option value="">All</option>
      <?php
        $cslctd = '';                         
        $selectClient = "SELECT DISTINCT(user) FROM ticket WHERE user!='none' ORDER BY user ASC";
        $queryClient = mysql_query($selectClient);                          
        $numrowsClient = mysql_numrows($queryClient);
        if( !empty($numrowsClient) ){
          while( $fetchClient = mysql_fetch_array($queryClient) ){
          $cslctd = ( isset($_GET['tclient']) && ($fetchClient['user'] == trim(urldecode($_GET['tclient']), "'")) ) ? "selected='selected'" : "";           
      ?>
      	<option value='<?php echo urlencode($fetchClient['user']); ?>' <?php echo $cslctd; ?> ><?php echo ucfirst($fetchClient['user']); ?></option>
      <?php
          }
        }
      ?>  
    	</select>
    </td>
    <td>Submit : From <input type="text" name="tfromDate" id="tfromDate" value="<?php echo $_REQUEST['tfromDate']; ?>" maxlength="20" size="15"><a href="javascript:NewCal('tfromDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a> To <input type="text" name="ttoDate" id="ttoDate" value="<?php echo $_REQUEST['ttoDate']; ?>" maxlength="20" size="15"><a href="javascript:NewCal('ttoDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></td>
    <td><input type="submit" class="button" value="Search" name="Search">&nbsp;&nbsp;<input type="button" name="reset" class="button" value="Reset" onclick="location.href='manageticket.php';"></td>
  </tr>
</table>
</form>

<table class="table_text" width="80%" border="1" cellspacing="0" cellpadding="0" bordercolor="orangered">
<tr>
  <th>S. No.</th>
  <th>Client</th>
  <th>Incident ID</th>  
  <th>Assignee</th>
  <th>Notes</th>
  <th>Priority</th>
  <th>Submit Date</th>
  <th>Pending Days</th>
  <th>Status</th>
  <th>Status Reason</th>
  <th>Reported By</th>
  <th>Last Modified Date</th>
  <th>Last Modified By</th>
  <th>File</th>  
  <th>Action</th>  
</tr>
<?php
$ADate = date('Y-m-d', (time()-86400));

$queryResults = @mysql_query($qry);
$numrowsResults = @mysql_numrows($queryResults);
$totalRecords = @mysql_numrows($queryResults);                        
$page = new Page();
$per_page = 10;
$page->set_page_data('', $numrowsResults, $per_page, 0, true, false, false);
$page->set_qry_string( $qry_string . $qry_string_paging );
$qry = $page->get_limit_query($qry);
$queryResults = @mysql_query($qry);
$numrowsResults = @mysql_numrows($queryResults);                        

if( $numrowsResults > 0 ) {
  $loop	=	0;        
  while( $fetchRecords = @mysql_fetch_array($queryResults) ) {                                                                                            
                 
  $page1 = isset($_GET['page']) ? $_GET['page'] : 0;
  $srNo1	=	$page1 * $per_page + $loop + 1;                        
  $css = ($loop%2 == 0) ? 'altClr' : 'altClrSecond';
  
  $times = $fetchRecords['timestamp'];
  $times = strtotime($times);
  $times = date('Y-m-d', $times);
  if( ($fetchRecords['status_name'] == 'Closed') || ($fetchRecords['status_name'] == 'Resolved') || ($fetchRecords['status_name'] == 'Cancelled') ){  
    $diff = 0;
  }else{
    $diff = getWorkingDays($times, $ADate, $holidays);  
  }                            
?>
<?php
  echo "<tr>";
  echo "<td>"."<div align=center style="."width:30;height:100;overflow:auto>".$srNo1."</div>"."</td>"; 
  echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$fetchRecords['user']."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:30;height:100;overflow:auto>".$fetchRecords['id']."</div>"."</td>";  
  echo "<td>"."<div align=center style="."width:70;height:100;overflow:auto>".$fetchRecords['assignee']."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:180;height:100;overflow:auto>".$fetchRecords['ticket']."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:60;height:100;overflow:auto>".$fetchRecords['priority_name']."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:70;height:100;overflow:auto>".$fetchRecords['timestamp']."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:50;height:100;overflow:auto>".round($diff,2)."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:60;height:100;overflow:auto>".$fetchRecords['status_name']."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$fetchRecords['sr_name']."</div>"."</td>"; 
  echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$fetchRecords['requestedby']."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$fetchRecords['lastmodifiedon']."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:60;height:100;overflow:auto>".$fetchRecords['lastmodifiedby']."</div>"."</td>";  
?>
  <td>
<?php if(!empty($fetchRecords['filepath'])){ ?>  
  <div id='linkid<?php echo $fetchRecords['id']; ?>' onmouseover="mOver(<?php echo $fetchRecords['id']; ?>, '<?php echo $fetchRecords[filepath]; ?>')" onmouseout="mOut(<?php echo $fetchRecords['id']; ?>, '<?php echo $fetchRecords[filepath]; ?>')" align='center' style='width:150;height:100;overflow:auto;'><img src="attachment.jpg" width="25" height="25"></div>
<?php }else{ ?>
  <div align='center' style='width:150;height:100;overflow:auto;'>N/A</div>  
<?php } ?>
  </td>
<?php
  echo "<td align='center'><a href='editticket.php?tid=".base64_encode($fetchRecords['id'])."&page=".$_GET['page']."&".$qry_string."'>Edit</a></td>";   
  echo "</tr>";
?>
<?php
      $loop++;                    
    }
?>
<tr height="20" bgcolor="white">
	<td colspan="15"><span class="Heading" style="float:left"><?php echo "Results: " . (($_GET['page']*$per_page)+1) . " - " . (($_GET['page']*$per_page)+$numrowsResults) . " of " . $totalRecords; ?></span><span class="Heading" style="float:right"><?php $page->get_page_nav(); ?></span>
  </td>
</tr>                                             
<?php                        
} else {
?>
<tr>
	<td colspan="15" class="mandatoryFild" align="center"><br /><br /> No Record Found. <br /><br /></td>
</tr>
<?php
}
?> 

</table>
<br />
<br />
<input type="button" name="gotologout" class="button" value="Log Out" onclick="location.href='logout.php';">
</body>
</html>
<script>
function mOver(rowid, filename){
  document.getElementById('linkid'+rowid).innerHTML = "<a href='support/" + filename + "' title='Your File'>" + filename + "</a>";
}

function mOut(rowid, filename){
  document.getElementById('linkid'+rowid).innerHTML = '<img src="attachment.jpg" width="25" height="25">';
}
</script>
 