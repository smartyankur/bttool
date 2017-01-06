<?php
$q=$_GET["q"];
$r=$_GET["r"];
$mode = isset($_REQUEST['mode'])? $_REQUEST['mode']: "display";

$upload_path = './files/';
include('config.php');
//echo "Hi    :".$q;

$sql="SELECT * FROM uploadinfo WHERE project = '".$q."'";
//echo $sql;
$where = "";
if(isset($_REQUEST['bcat']) && !empty($_REQUEST['bcat']) && $_REQUEST['bcat'] != 'All'){
	$where .= " AND category='".$_REQUEST['bcat']."'";
}

if(isset($_REQUEST['bugstatus']) && !empty($_REQUEST['bugstatus']) && $_REQUEST['bugstatus'] != 'All'){
	$where .= " AND status='".$_REQUEST['bugstatus']."'";
}

$sql .= $where;
$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('Data Not Found');
}

if($mode == "display") {

?>

<div style="width:100%;">
 <div style="width:60%;float:left;">
<?php

$firstArray = array("Open"=>0, "Closed"=>0, "Hold"=>0, "Reopened"=>0, "Ok as is"=>0, "Fixed"=>0);
$secondArray = array();
$selectBugsCount = "SELECT `status`, count(`status`) as bugstatuscounts FROM `uploadinfo` WHERE project = '".$q."' ".$where." GROUP BY `status`";
$queryBugsCount = mysql_query($selectBugsCount);
$numrowsBugsCount = mysql_num_rows($queryBugsCount);
if( $numrowsBugsCount != 0 ){
  while($fetchBugsCount = mysql_fetch_array($queryBugsCount)){  
    $secondArray[$fetchBugsCount['status']] = $fetchBugsCount['bugstatuscounts'];
  }
  $finalArray = array_merge($firstArray, $secondArray);  

  echo "<table width='500' cellspacing='0' cellpadding='0' border='0' class='table_text'>";
    echo "<tr>";
      echo "<td width='500'>";    
      $z = 1;  
      foreach($finalArray as $keyBugsCount => $valueBugsCount){  
        echo "<b>" . ucfirst($keyBugsCount) . " : </b>" . $valueBugsCount;
        if(count($finalArray) != $z){ echo ',&nbsp;&nbsp;'; }        
        $z++;    
      }
      echo "</td>";    
    echo "</tr>";
  echo "</table>";    
}

$sql_query = "SELECT category, count(category) as bcatcounts FROM uploadinfo WHERE project='".$q."' ".$where." GROUP BY category";
$bcatCountResult = mysql_query($sql_query);
$bcatRowCount = mysql_num_rows($bcatCountResult);

$bcatblankArray = array("Editorial"=>0, "Media"=>0, "Functionality"=>0, "Audio"=>0, "Simulation"=>0, "ID"=>0);
$bCatdbArray = array();

if($bcatRowCount != 0) {
	while($row = mysql_fetch_array($bcatCountResult)) {
		$bCatdbArray[$row['category']] = $row['bcatcounts'];
	}
	$bcatFinalArray = array_merge($bcatblankArray, $bCatdbArray);

  echo "<table width='700' cellspacing='0' cellpadding='0' border='0' class='table_text'>";
    echo "<tr>";
      echo "<td width='700'>";    
      $z = 1;  
      foreach($bcatFinalArray as $keyBugsCount => $valueBugsCount){  
        echo "<b>" . ucfirst($keyBugsCount) . " : </b>" . $valueBugsCount;
        if(count($bcatFinalArray) != $z){ echo ',&nbsp;&nbsp;'; }        
        $z++;    
      }
      echo "</td>";    
    echo "</tr>";
  echo "</table>";
}


?>
  </div>
  <div style="width:40%;float:right;">
    <a href="javascript:void(0);" onClick="showAll('export');">Export</a>
  </div>
</div>
<div style="width:100%;clear:both;height:10px;"></div>
<?php

} // display end

if($mode == "export"){
	ob_clean();
	ob_start();
	$now = gmdate("D, d M Y H:i:s");
	header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
	header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
	header("Last-Modified: {$now} GMT");
	
	// force download  
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	
	// disposition / encoding on response body
	header("Content-Disposition: attachment;filename=QC_Bugs.xls");
	header("Content-Transfer-Encoding: binary");

	//$output = fopen('php://output', 'w');
	//fputcsv($output, array('Project','Phase','Module','Topic','Screen','Browser','Bug Category','Reviewer','Description','Severity','Submission Date','Bug Status'));
}

//echo "---------------------------------------------------------------------------------------------------------------------";
echo "<table width='50%' border='1' cellspacing='0' cellpadding='0' bordercolor=\"orangered\">";
?>
<tr valign="middle" class="table_text"><th>ID</th><th>User</th><th>Phase</th><th>Bug Category</th><th>Module</th><th>Topic</th><th>Page</th><th>Bug Description</th><th>Edit Desc</th><th>Click to View File</th><th>Status</th><th>Reason</th><th>Change Status</th><th>Status Changed By</th><th>Time Stamp</th><th>Last Reason Updated</th><th>Bug Posting Date</th></tr>
<?php
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td valign=\"middle\" class=\"table_text\">"."<div style="."width:50;height:53;overflow:auto>".htmlentities($row['id'])."</div>"."</td>";
  echo "<td valign=\"middle\" class=\"table_text\">"."<div style="."width:50;height:53;overflow:auto>".htmlentities($row['user'])."</div>"."</td>";
  echo "<td valign=\"middle\" class=\"table_text\">"."<div style="."width:60;height:53;overflow:auto>".htmlentities($row['phase'])."</div>"."</td>";
  echo "<td valign=\"middle\" class=\"table_text\">"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['category'])."</div>"."</td>";
  echo "<td valign=\"middle\" class=\"table_text\">"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['module'])."</div>"."</td>";
  echo "<td valign=\"middle\" class=\"table_text\">"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['topic'])."</div>"."</td>";
  echo "<td valign=\"middle\" class=\"table_text\">"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['page'])."</div>"."</td>";
  echo "<td valign=\"middle\" class=\"table_text\">"."<div style="."width:500;height:53;overflow:auto>".htmlentities($row['description'])."</div>"."</td>";
  ?>
  <TD><input type="button" value="Edit" onclick="editbug(<?php echo $row['id'] ?>)"></TD>
  
  <?php
  echo "<td valign=\"middle\" class=\"table_text\">"."<div style="."width:100;height:53;overflow:auto>".'<a href="'.htmlentities($upload_path).htmlentities($row['filepath']).'" target="_blank" title="Right Click To Open in New Window">'.$row['filename'].'</a>'."</div>"."</td>";
  echo "<td valign=\"middle\" class=\"table_text\">"."<div style="."width:70;height:53;overflow:auto>".htmlentities($row['status'])."</div>"."</td>";
  ?>
  <TD><textarea name="<?php echo "reason".$row['id'];?>" rows="2" cols="10" id="<?php echo "reason".$row['id'];?>"></textarea></TD>
  <TD align="center" class="table_text"><select id="<?php echo $row['id'];?>" size="1">
  <?php
  if($r="CLIENT")
  { 
  ?>
  <option value="select" selected>Select</option>
  <option value="Reopened">Reopen</option>
  <option value="Ok As Is">Ok As Is</option>
  <option value="Hold">Hold</option>
  <option value="Fixed">Fixed</option>
  <option value="Closed">Closed</option>
  <?php
  }
  ?>
  
  </select>&nbsp;&nbsp;<input type="button" value="Change" onclick="submitresponse(<?php echo $row['id'] ?>)" class="button"></TD>
  <?php
  echo "<td valign=\"middle\" class=\"table_text\">"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['whochangedstatus'])."</div>"."</td>";
  echo "<td valign=\"middle\" class=\"table_text\">"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['whenchangedstatus'])."</div>"."</td>";
  echo "<td valign=\"middle\" class=\"table_text\">"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['reason'])."</div>"."</td>";
  echo "<td valign=\"middle\" class=\"table_text\">"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['bug_posting_date'])."</div>"."</td>";
  }
echo "</table>";
if($emode=="export"){
	//fclose($output);
	echo ob_get_clean();
	die();
}
mysql_close($con);
?> 