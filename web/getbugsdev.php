<?php
/*
 * @author Saurav Gupta
 */
require_once("pagination/configure.php");
$upload_path = './qcfiles/'; 
$q=$_GET["q"];
$project_id = $_GET['pro_id'];
$chd = explode("-", $_GET['chd_id']);
$asignee = $_GET['r'];
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
if(!empty($filter_name) && in_array(str_replace('filter_','',$filter_name),array("bcat","severity","bugstatus","qc","module")) && !empty($filter_value) && $filter_value != "select"){
	$sql = "SELECT * FROM qcuploadinfo WHERE project_id = '".$project_id."' and chd_id = '".$chd[0]."' and ".str_replace('filter_','',$filter_name)." = '".$filter_value."'";
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
	if(!empty($filter_name) && in_array(str_replace('filter_','',$filter_name),array("bcat","severity","bugstatus","qc","module")) && !empty($filter_value) && $filter_value != "select"){
		$sql2 = "SELECT qc.*,tc.category FROM qcuploadinfo qc INNER JOIN tbl_category tc  ON tc.id = qc.bscat WHERE qc.project_id = '".$project_id."' AND qc.".str_replace('filter_','',$filter_name)." = '".$filter_value."'";
		if($_GET['bscat'] != '' && $_GET['bscat'] != 'select') {
			$sql2 .= " AND qc.bscat = '".$_GET['bscat']."'";
		}
		$sql2 .= " and qc.chd_id='".$chd[0]."' limit ". ($lower_limit)." ,  ". ($page_limit). " "; 		
	} else {
		$sql2 = "SELECT qc.*,tc.category FROM qcuploadinfo qc INNER JOIN tbl_category tc ON tc.id = qc.bscat WHERE qc.project_id = '".$project_id."' and qc.chd_id = '".$chd[0]."' limit ". ($lower_limit)." ,  ". ($page_limit). " ";
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
	  echo "<td><textarea id=".$row['id']." rows="."4"." cols="."30".">".$row['devcomment']."</textarea>";
	  echo " Change Status ";
	  echo "<select id="."stat".$row['id'].">";
	  ?>
	  <option size=30 <?=$row['bugstatus']==''?'selected':''?>>Select</option>
	  <option value="fixed" <?=$row['bugstatus']=='fixed'?'selected':''?>>Fixed</option>
	  <option value="hold" <?=$row['bugstatus']=='hold'?'selected':''?>>Hold</option>
	  <option value="ok as is" <?=$row['bugstatus']=='ok as is'?'selected':''?>>Ok As Is</option>
	  </select>
	  <input type="button" value="Submit Response" onclick="submitresponse(<?php echo $row['id']?>)">
	  <?php
	  echo "</td></tr>";
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
