<?php
require_once("pagination/configure.php");
$upload_path = './qcfiles/';
$issuetype = $_GET["issuetype"]; 
$q         = $_GET["q"];
$auditee   = $_GET["r"];
$pro_id   = $_GET["pro_id"];
$chd   = explode("-", $_GET["chd_id"]);
if (!(isset($_GET['pagenum']))) { 
	$pagenum = 1; 
} else {
	$pagenum = intval($_GET['pagenum']); 		
}

$page_limit =  ($_GET["show"] != "All") ? intval($_GET["show"]) : 100000;

if($issuetype != 'any'){
  $sql1 = "SELECT count(*) as count FROM qcuploadinfo WHERE project_id = '".$pro_id."' and chd_id = '".$chd[0]."' and bugstatus = '".$issuetype."'";
}else{
  $sql1 = "SELECT count(*) as count FROM qcuploadinfo WHERE project_id = '".$pro_id."' and chd_id = '".$chd[0]."'";
}
try {
    $stmt = $DB->prepare($sql1);
    $stmt->execute();
    $tresults = $stmt->fetchAll();
} catch (Exception $ex) {
    echo($ex->getMessage());
}
$cnt = $tresults[0]['count'];
//Calculate the last page based on total number of rows and rows per page. 
if($cnt > 0) {
$last = ceil($cnt/$page_limit); 

//this makes sure the page number isn't below one, or more than our maximum pages 
if ($pagenum < 1) { 
	$pagenum = 1; 
} elseif ($pagenum > $last)  { 
	$pagenum = $last; 
}
$lower_limit = ($pagenum - 1) * $page_limit;

if($issuetype != 'any'){
  $sql = "SELECT *, c.category FROM qcuploadinfo left join tbl_category as c on bcat = c.id WHERE project_id = '".$pro_id."' and chd_id = '".$chd[0]."' and bugstatus = '".$issuetype."' limit ". ($lower_limit)." ,  ". ($page_limit). "";
}else{
  $sql = "SELECT *, c.category FROM qcuploadinfo left join tbl_category as c on bcat = c.id WHERE project_id = '".$pro_id."' and chd_id = '".$chd[0]."' limit ". ($lower_limit)." ,  ". ($page_limit). "";
}
try {
		$stmt = $DB->prepare($sql);
		$stmt->execute();
		$results = $stmt->fetchAll();
	} catch (Exception $ex) {
		echo($ex->getMessage());
	}
}

?>
<div style="width:100%;margin:10px;">
	
	<div id="exportPanel" style="width:48%;height:30px;float:right;text-align:right;">
		<input type="button" name="export" id="export" value="Export" style="margin-right:10px" onClick="export123();">
	</div>
</div>
<?php 
if(count($results) == 0){
  die('No '.$issuetype.' item was found with this project name.');
} else {
echo "<table cellpadding='0' cellspacing='0' border='1'>
	<tr>
	  <th>Bug ID</th>
	  <th>Severity</th>
	  <th>Phase</th>
	  <th>Module</th>
	  <th>Topic</th>
	  <th>Screen</th>
	  <th>Environment</th>
	  <th>Description</th>
	  <th>QC</th>
	  <th>Asignee</th>
	  <th>QC Comment</th>
	  <th>Round</th>
	  <th>Dev Comment</th>
	  <th>Status</th>
	  <th>Category</th>
	  <th>View attachment</th>
	  <th>Submit Response</th>
	</tr>
	";
	foreach($results as $row)
	  {
	  echo "<tr>";
	  echo "<td>".$row['id']."</td>";
	  echo "<td>".$row['severity']."</td>";
	  //echo "Auditee :".$auditee."</br>";
	  echo "<td>".$row['phase']."</td>";
	  echo "<td>".$row['module']."</td>";
	  echo "<td>".$row['topic']."</td>";
	  echo "<td>".$row['screen']."</td>";
	  echo "<td>".$row['browser']."</td>";
	  echo "<td>".htmlspecialchars ($row['bdr'])."</td>";
	  echo "<td>".$row['qc']."</td>";
	  echo "<td>".$row['asignee']."</td>";
	  echo "<td>".$row['qccomment']."</td>";
	  echo "<td>"."<b>".$row['round']."</b>"."</td>";
	  echo "<td>".$row['devcomment']."</td>";
	  echo "<td>".$row['bugstatus']."</td>";
	  echo "<td>"."<b>".$row['category']."</b>"."</td>";
	  echo "<td>".'<a target="_blank" href="'.$upload_path.$row['filepath'].'" title="Your File">'.$row['filepath'].'</a>'."</td>";
	  echo "<td><textarea id=".$row['id']." rows="."4"." cols="."30"."></textarea>";
	  echo " Change Status ";
	  echo "<select id="."stat".$row['id'].">";
	  ?>
	  <option size=30 selected>Select</option>
	  <option value="fixed">Fixed</option>
	  <option value="hold">Hold</option>
	  <option value="ok as is">Ok As Is</option>
	  </select>
	  <input type="button" value="Submit Response" onclick="submitresponse(<?php echo $row['id']?>)">
	  <?php
	  echo "</td>";
	  }
  echo "</table>";
}
?>
<table width="50%" border="0" cellspacing="0" cellpadding="2"  align="center">
<tr>
  <td valign="top" align="left">
	
<label> Rows Limit: 
<select name="show" onChange="changeDisplayRowCount(this.value);">
  <option value="10" <?php if ($_GET["show"] == 10 || $_GET["show"] == "" ) { echo ' selected="selected"'; }  ?> >10</option>
  <option value="20" <?php if ($_GET["show"] == 20) { echo ' selected="selected"'; }  ?> >20</option>
  <option value="50" <?php if ($_GET["show"] == 50) { echo ' selected="selected"'; }  ?> >50</option>
  <option value="100" <?php if ($_GET["show"] == 100) { echo ' selected="selected"'; }  ?> >100</option>
  <option value="All" <?php if ($_GET["show"] == 'All') { echo ' selected="selected"'; }  ?> >All</option>
</select>
</label>

	</td>
  <td valign="top" align="center" >
 
	<?php
	if ( ($pagenum-1) > 0) {
	?>	
	 <a href="javascript:void(0);" class="links" onclick="displayRecords('<?php echo $page_limit;  ?>', '<?php echo 1; ?>');">First</a>
	<a href="javascript:void(0);" class="links"  onclick="displayRecords('<?php echo $page_limit;  ?>', '<?php echo $pagenum-1; ?>');">Previous</a>
	<?php
	}
	//Show page links
	$c = 0;
	for($i=$pagenum; $i<=$last; $i++) {
		if($c==9) break;
		if ($i == $pagenum ) {
?>
		<a href="javascript:void(0);" class="selected" ><?php echo $i ?></a>
<?php
	} else {
		
?>
	<a href="javascript:void(0);" class="links"  onclick="displayRecords('<?php echo $page_limit;  ?>', '<?php echo $i; ?>');" ><?php echo $i ?></a>
<?php 
	}
	$c++;
} 
if ( ($pagenum+1) <= $last) {
?>
	<a href="javascript:void(0);" onclick="displayRecords('<?php echo $page_limit;  ?>', '<?php echo $pagenum+1; ?>');" class="links">Next</a>
<?php } if ( ($pagenum) != $last) { ?>	
	<a href="javascript:void(0);" onclick="displayRecords('<?php echo $page_limit;  ?>', '<?php echo $last; ?>');" class="links" >Last</a> 
<?php
	} 
?>
</td>
	<td align="right" valign="top">
	Page <?php echo $pagenum; ?> of <?php echo $last; ?>
	</td>
</tr>
</table>
