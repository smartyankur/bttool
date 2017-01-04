<?php
$q=$_GET["q"];
$project_id = $_GET['id'];
$chd = explode("-", $_GET['chd_id']);
$upload_path = './qcfiles/';
include("config.php");

$filter_name = isset($_REQUEST['filter_name']) ? $_REQUEST['filter_name'] : '';
$filter_value = isset($_REQUEST[str_replace('filter_','',$filter_name)."1"]) ? $_REQUEST[str_replace('filter_','',$filter_name)."1"] : '';

if(!empty($q)) {
	if(!empty($filter_name) && in_array(str_replace('filter_','',$filter_name),array("bcat","severity","bugstatus","asignee","qc","module")) && !empty($filter_value)){
		$sql = "SELECT * FROM qcuploadinfo WHERE project_id = '".$project_id."' AND ".str_replace('filter_','',$filter_name)." = '".$filter_value."' and chd_id='".$chd[0]."'";
	} else {
		$sql = "SELECT * FROM qcuploadinfo WHERE project_id = '".$project_id."' and chd_id = '".$chd[0]."'";
	}
	
	$result = mysql_query($sql);
	$count = mysql_num_rows($result);
	
	if($count==0){
	  die('Data Not Found');
	}
}
$firstArray = array("open"=> 0, "closed"=> 0, "hold"=> 0, "reopened"=> 0, "ok as is"=> 0, "global" => 0, "editorial"=>0, "media"=>0, "functionality"=>0, "audio"=>0, "suggesstion"=>0);
$tmp = array();
while($row = mysql_fetch_array($result)){
	$tmp[] = $row;
	if(array_key_exists($row['bugstatus'], $firstArray)) {
		$firstArray[$row['bugstatus']] = $firstArray[$row['bugstatus']] + 1;
	} if(array_key_exists($row['bcat'], $firstArray)) {
		$firstArray[$row['bcat']] = $firstArray[$row['bcat']] + 1;
	}
}
	
	echo "<table width='700' cellspacing='0' cellpadding='0' border='0'>";
    echo "<tr>";
      echo "<td width='700'>";    
      $z = 1;  
      foreach($firstArray as $keyBugsCount => $valueBugsCount){  
        if($valueBugsCount == 0) continue;
		echo "<b>" . ucfirst($keyBugsCount) . " : </b>" . $valueBugsCount;
        if(count($firstArray) != $z){ echo ',&nbsp;&nbsp;'; }        
        $z++;    
      } 
	  echo "<b> Total : </b>" . $count; 
      echo "</td>";    
    echo "</tr>";
  echo "</table>";
	




/*$firstArray = array("open"=> 0, "closed"=> 0, "hold"=> 0, "reopened"=> 0, "ok as is"=> 0, "global" => 0, "editorial"=>0, "media"=>0, "functionality"=>0, "audio"=>0, "suggestion"=>0);
$secondArray = array();
$selectBugsCount = "SELECT `bugstatus`, count(`bugstatus`) as bugstatuscounts FROM `qcuploadinfo` WHERE project_id = '".$project_id."' GROUP BY `bugstatus`";
$queryBugsCount = mysql_query($selectBugsCount);
$numrowsBugsCount = mysql_num_rows($queryBugsCount);
if( $numrowsBugsCount != 0 ){
  while($fetchBugsCount = mysql_fetch_array($queryBugsCount)){  
    $secondArray[$fetchBugsCount['bugstatus']] = $fetchBugsCount['bugstatuscounts'];
    $secondArray[$fetchBugsCount['bcat']] = $fetchBugsCount['bcatcounts'];
  }
  $finalArray = array_merge($firstArray, $secondArray);  
  //echo '<pre>'; print_r($finalArray); die;
  echo "<table width='700' cellspacing='0' cellpadding='0' border='0'>";
    echo "<tr>";
      echo "<td width='700'>";    
      $z = 1;  
      foreach($finalArray as $keyBugsCount => $valueBugsCount){  
        echo "<b>" . ucfirst($keyBugsCount) . " : </b>" . $valueBugsCount;
        if(count($finalArray) != $z){ echo ',&nbsp;&nbsp;'; }        
        $z++;    
      }
      echo "</td>";    
    echo "</tr>";
  echo "</table>";    
}*/

/*$sql_query = "SELECT bcat, count(bcat) as bcatcounts FROM qcuploadinfo WHERE project_id='".$project_id."' GROUP BY bcat";
$bcatCountResult = mysql_query($sql_query);
$bcatRowCount = mysql_num_rows($bcatCountResult);

$bcatblankArray = array("global"=>0, "editorial"=>0, "media"=>0, "functionality"=>0, "audio"=>0, "suggestion"=>0);
$bCatdbArray = array();

if($bcatRowCount != 0) {
	while($row = mysql_fetch_array($bcatCountResult)) {
		$bCatdbArray[$row['bcat']] = $row['bcatcounts'];
	}
	$bcatFinalArray = array_merge($bcatblankArray, $bCatdbArray);

  echo "<table width='700' cellspacing='0' cellpadding='0' border='0'>";
    echo "<tr>";
      echo "<td width='700'>";    
      $z = 1;  
      foreach($bcatFinalArray as $keyBugsCount => $valueBugsCount){  
        if($keyBugsCount == "suggestion") continue;
		echo "<b>" . ucfirst($keyBugsCount) . " : </b>" . $valueBugsCount;
        if(count($bcatFinalArray) != $z){ echo ',&nbsp;&nbsp;'; }        
        $z++;    
      }
      echo "</td>";    
    echo "</tr>";
  echo "</table>";
}*/

?>
<!--<script src="js/jquery.js"></script>-->
<!--<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" media="screen" />
<script>
$(document).ready(function() {
    $('#qcinfo').DataTable( {
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    } );
} );
</script>-->
<div style="width:100%;margin:10px;">
	
	<div id="exportPanel" style="width:48%;height:30px;float:right;text-align:right;">
		<input type="button" name="export" id="export" value="Export" style="margin-right:10px" onClick="export123();">
	</div>
</div>

<table width="50%" border="1" class="display" cellspacing="0" cellpadding="0" id="qcinfo">
<thead>
<tr>
  <th>ID</th>
  <th>Browser</th>
  <!-- th>Phase</th -->
  <th>Module</th>
  <th>Topic</th>
  <th>Screen</th>
  <!-- th>Receive Date</th -->
  <!-- th>Course Status</th -->
  <!-- th>Select New Course Status</th -->
  <!-- th>Submit Course Status</th -->
  <th>Bug Cat</th>
  <th>Severity</th>
  <th>Bug Desc</th>
  <th>Bug Status</th>
  <th>Select New Bug Status</th>
  <th>Submit Bug Status</th>
  <th>View</th>
  <th>Upload Date</th>
  <!-- th>Last time when bug status was assigned</th -->
  <!-- th>Last time who assigned bug status</th -->
  <th>Asignee</th>
  <th>QC</th>
  <th>Round</th>
  <!-- th>Uploaded File</th -->
  <th>Edit Bug detail</th>
  <th>Dev Comment</th>
  <th>Dev Name</th>
  <th>Dev Comment Date</th>
  <th>QC Comment</th>
  <th>QC Name</th>
  <th>QC Comment Date</th>
  <th>Response to Dev Comments</th>
</tr>
</thead>
<tfoot>
<tr>
  <th>ID</th>
  <th>Browser</th>
  <!-- th>Phase</th -->
  <th>Module</th>
  <th>Topic</th>
  <th>Screen</th>
  <!-- th>Receive Date</th -->
  <!-- th>Course Status</th -->
  <!-- th>Select New Course Status</th -->
  <!-- th>Submit Course Status</th -->
  <th>Bug Cat</th>
  <th>Severity</th>
  <th>Bug Desc</th>
  <th>Bug Status</th>
  <th>Select New Bug Status</th>
  <th>Submit Bug Status</th>
  <th>View</th>
  <th>Upload Date</th>
  <!-- th>Last time when bug status was assigned</th -->
  <!-- th>Last time who assigned bug status</th -->
  <th>Asignee</th>
  <th>QC</th>
  <th>Round</th>
  <!-- th>Uploaded File</th -->
  <th>Edit Bug detail</th>
  <th>Dev Comment</th>
  <th>Dev Name</th>
  <th>Dev Comment Date</th>
  <th>QC Comment</th>
  <th>QC Name</th>
  <th>QC Comment Date</th>
  <th>Response to Dev Comments</th>
</tr>
</tfoot>
<tbody>
<?php
foreach($tmp as $row)
  {
  echo "<tr>";
  echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['id'])."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['browser'])."</div>"."</td>";
  // echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['project'])."</div>"."</td>";
  // echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['phase'])."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['module'])."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['topic'])."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['screen'])."</div>"."</td>";
  // echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['receivedate'])."</div>"."</td>";
  // echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['coursestatus'])."</div>"."</td>";
  ?>
  <!-- TD><select id="<?php echo $row['id'];?>" size="1">
  <option value="select" selected>Select</option>
  <option value="accepted">Accepted</option>
  <option value="rejected">Rejected</option>
  </select></TD>
  <TD><input type="button" value="Change Status" onclick="submitresponse(<?php echo $row['id'] ?>)"></TD -->
  <?php
  echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['bcat'])."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['severity'])."</div>"."</td>"; 
  echo "<td>"."<div align=left style="."width:350;height:160;overflow:auto>".htmlentities($row['bdr'])."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['bugstatus'])."</div>"."</td>";
  ?>
  <TD><select id="<?php echo "bug".$row['id'];?>" size="1">
  <option value="select" selected>Select</option>
  <option value="open">Open</option>
  <option value="closed">Closed</option>
  <option value="hold">Hold</option>
  <option value="reopened">Reopened</option>
  <option value="ok as is">Ok As Is</option>
  </select></TD>
  <TD><input type="button" value="Change Status" onclick="submitbugresponse(<?php echo $row['id'] ?>)"></TD>
  <?php
  echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".'<a href="'.htmlentities($upload_path).htmlentities($row['filepath']).'" title="Your File" target="new">'.$row['filepath'].'</a>'."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['uploaddate'])."</div>"."</td>";
  // echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['whenchangedstatus'])."</div>"."</td>";
  // echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['whochangedstatus'])."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['asignee'])."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['qc'])."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['round'])."</div>"."</td>";
  // echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['filename'])."</div>"."</td>";
  ?>
  <TD><input type="button" value="Edit" onclick="editbug(<?php echo $row['id'] ?>)"></TD>
  <?php
  echo "<td>"."<div align=center style="."width:130;height:53;overflow:auto>".htmlentities($row['devcomment'])."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['devresponding'])."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['devrespdate'])."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['qccomment'])."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['qcresponding'])."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['qcrespdate'])."</div>"."</td>";
  echo "<td><textarea id=".$row['id']." rows="."4"." maxlength="."160"." cols="."30"."></textarea>";
  echo "	<select id="."round".$row['id'].">
		  <option size=30 selected>Select</option>
		  <option value='R2'>R2</option>
		  <option value='R3'>R3</option>
		  <option value='R4'>R4</option>
		</select>
		<input type='button' value='Submit Response' onclick='submitresponse_devcomment(".$row['id'].")'></td>";
  echo "</tr>";
  }
  ?>
  </tbody>
</table>
<?php  
  mysql_close($con);
?> 