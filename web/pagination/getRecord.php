<?php
/*
 * @author Saurav Gupta
 */
require_once("configure.php");
$q=$_GET["q"];
$project_id = $_GET['id'];
$chd = explode("-", $_GET['chd_id']);
// Very important to set the page number first.
if (!(isset($_GET['pagenum']))) { 
	 $pagenum = 1; 
} else {
	$pagenum = intval($_GET['pagenum']); 		
}
$filter_name = isset($_REQUEST['filter_name']) ? $_REQUEST['filter_name'] : '';
$filter_value = isset($_REQUEST[str_replace('filter_','',$filter_name)."1"]) ? $_REQUEST[str_replace('filter_','',$filter_name)."1"] : '';
//Number of results displayed per page 	by default its 10.
$page_limit =  ($_GET["show"] != "All") ? intval($_GET["show"]) : 100000;

// Get the total number of rows in the table
if(!empty($filter_name) && in_array(str_replace('filter_','',$filter_name),array("bcat","severity","bugstatus","asignee","qc","module")) && !empty($filter_value) && $filter_value != "select"){
	$sql = "SELECT * FROM qcuploadinfo WHERE project_id = '".$project_id."' and chd_id = '".$chd[0]."' AND ".str_replace('filter_','',$filter_name)." = '".$filter_value."'";
	if($_GET['bscat'] != '' && $_GET['bscat'] != 'select') {
		$sql .= " AND bscat = '".$_GET['bscat']."'";
	}
} else {
	$sql = "SELECT * FROM qcuploadinfo WHERE project_id = '".$project_id."' and chd_id = '".$chd[0]."'";
}

try {
    $stmt = $DB->prepare($sql);
    $stmt->execute();
    $tresults = $stmt->fetchAll();
} catch (Exception $ex) {
    echo($ex->getMessage());
}

$cnt = count($tresults);
if($cnt > 0){
	$firstArray = array("open"=> 0, "closed"=> 0, "fixed"=> 0, "hold"=> 0, "reopened"=> 0, "ok as is"=> 0, "Editorial"=>0, "Media"=>0, "Functionality"=>0);
$tmp = array();
foreach($tresults as $val){
	$tmp[] = $val;
	if(array_key_exists($val['bugstatus'], $firstArray)) {
		$firstArray[$val['bugstatus']] = $firstArray[$val['bugstatus']] + 1;
	} if(array_key_exists($val['function'], $firstArray)) {
		$firstArray[$val['function']] = $firstArray[$val['function']] + 1;
	}
}
	
	echo "<table width='700' cellspacing='0' cellpadding='0' border='0'>";
    echo "<tr>";
      echo "<td width='700'>";    
      $z = 1;  
      foreach($firstArray as $keyBugsCount => $valueBugsCount){  
        //if($valueBugsCount == 0) continue;
		if($keyBugsCount == "Editorial") echo "<br><br>";
		echo "<b>" . ucfirst($keyBugsCount) . " : </b>" . $valueBugsCount;
        if(count($firstArray) != $z){ echo ',&nbsp;&nbsp;'; }        
        $z++;    
      } 
	  echo ", <b> Total : </b>" . $cnt; 
      echo "</td>";    
    echo "</tr>";
  echo "</table>";
}

//Calculate the last page based on total number of rows and rows per page. 
$last = ceil($cnt/$page_limit); 

//this makes sure the page number isn't below one, or more than our maximum pages 
if ($pagenum < 1) { 
	$pagenum = 1; 
} elseif ($pagenum > $last)  { 
	$pagenum = $last; 
}
$lower_limit = ($pagenum - 1) * $page_limit;

//$sql2 = " SELECT * FROM qcuploadinfo WHERE project_id = '3125' limit ". ($lower_limit)." ,  ". ($page_limit). " ";

$filter_name = isset($_REQUEST['filter_name']) ? $_REQUEST['filter_name'] : '';
$filter_value = isset($_REQUEST[str_replace('filter_','',$filter_name)."1"]) ? $_REQUEST[str_replace('filter_','',$filter_name)."1"] : '';

if(!empty($q) && $cnt > 0) {
	if(!empty($filter_name) && in_array(str_replace('filter_','',$filter_name),array("bcat","severity","bugstatus","asignee","qc","module")) && !empty($filter_value) && $filter_value != "select"){
		$sql2 = "SELECT * FROM qcuploadinfo WHERE project_id = '".$project_id."' AND ".str_replace('filter_','',$filter_name)." = '".$filter_value."'";
		if($_GET['bscat'] != '' && $_GET['bscat'] != 'select') {
			$sql2 .= " AND bscat = '".$_GET['bscat']."'";
		}
		$sql2 .= " and chd_id='".$chd[0]."' limit ". ($lower_limit)." ,  ". ($page_limit). " "; 		
	} else {
		$sql2 = "SELECT * FROM qcuploadinfo WHERE project_id = '".$project_id."' and chd_id = '".$chd[0]."' limit ". ($lower_limit)." ,  ". ($page_limit). " ";
	}

	try {
		$stmt = $DB->prepare($sql2);
		$stmt->execute();
		$results = $stmt->fetchAll();
	} catch (Exception $ex) {
		echo($ex->getMessage());
	}
}
?>
<div style="width:100%;margin:10px;">
	
	<div id="exportPanel" style="width:48%;height:30px;float:right;text-align:right;">
		<!--<input type="button" name="exportall" id="exportall" value="ExportAll" style="margin-right:10px" onClick="exportAll();">&nbsp;&nbsp;-->
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
  <th>Asignee (Developer)</th>
  <th>Function (Developer)</th>
  <th>Asignee (Reviewer)</th>
  <th>Function (Reviewer)</th>
  <th>Bug Cat</th>
  <th>Bug Sub Cat</th>
  <th>Severity</th>
  <th>Bug Desc</th>
  <th>Bug Status</th>
  <th>Select New Bug Status</th>
  <th>Submit Bug Status</th>
  <th>View</th>
  <th>Upload Date</th>
  <!-- th>Last time when bug status was assigned</th -->
  <!-- th>Last time who assigned bug status</th -->
  
  
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

<tbody>
<?php
if(count($results) > 0) {
foreach($results as $row)
  {
   $cat_query = "select category from tbl_category where id = '".$row['bcat']."'";
   $category = $DB->prepare($cat_query);
   $category->execute();
   $cat_res = $category->fetch();
   
   $subcat_query = "select category from tbl_category where id = '".$row['bscat']."'";
   $subcategory = $DB->prepare($subcat_query);
   $subcategory->execute();
   $subcat_res = $subcategory->fetch();
  echo "<tr>";
  echo "<td>"."<div align=center style="."width:50;height:40;overflow:auto>".htmlentities($row['id'])."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:80;height:40;overflow:auto>".htmlentities($row['browser'])."</div>"."</td>";
  // echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['project'])."</div>"."</td>";
  // echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['phase'])."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:80;height:40;overflow:auto>".htmlentities($row['module'])."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:80;height:40;overflow:auto>".htmlentities($row['topic'])."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:40;overflow:auto>".htmlentities($row['screen'])."</div>"."</td>";
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
  echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['asignee'])."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:40;overflow:auto>".htmlentities($row['function'])."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['asignee_reviewer'])."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:40;overflow:auto>".htmlentities($row['function_reviewer'])."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:40;overflow:auto>".htmlentities($cat_res['category'])."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:200;height:40;overflow:auto>".htmlentities($subcat_res['category'])."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:80;height:40;overflow:auto>".htmlentities($row['severity'])."</div>"."</td>"; 
  echo "<td>"."<div align=left style="."width:300;height:100;overflow:auto>".htmlentities($row['bdr'])."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:80;height:40;overflow:auto>".htmlentities($row['bugstatus'])."</div>"."</td>";
  ?>
  <TD><select id="<?php echo "bug".$row['id'];?>" size="1">
  <option value="select" selected>Select</option>
  <option value="open">Open</option>
  <option value="closed">Closed</option>
  <option value="fixed">Fixed</option>
  <option value="hold">Hold</option>
  <option value="reopened">Reopened</option>
  <option value="ok as is">Ok As Is</option>
  </select></TD>
  <TD><input type="button" value="Change Status" onclick="submitbugresponse(<?php echo $row['id'] ?>)"></TD>
  <?php
  echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".'<a href="'.htmlentities('qcfiles/').htmlentities($row['filepath']).'" title="Your File" target="new">'.$row['filepath'].'</a>'."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['uploaddate'])."</div>"."</td>";
  // echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['whenchangedstatus'])."</div>"."</td>";
  // echo "<td>"."<div align=center style="."width:100;height:53;overflow:auto>".htmlentities($row['whochangedstatus'])."</div>"."</td>";
  
  
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
  echo "<td><textarea id=".$row['id']." rows="."4"." cols="."30"."></textarea>";
  echo "	<select id="."round".$row['id'].">
		  <option size=30 selected>Select</option>
		  <option value='R2'>R2</option>
		  <option value='R3'>R3</option>
		  <option value='R4'>R4</option>
		</select>
		<input type='button' value='Submit Response' onclick='submitresponse_devcomment(".$row['id'].")'></td>";
  echo "</tr>";
  }
} else {
	echo "<tr><td colspan='26' style='text-align:center;'>No Record Found</td></tr>";
}
  ?>
  </tbody>
</table>
<div class="height30"></div>
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
