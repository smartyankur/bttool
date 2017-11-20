<?php
include('config.php');
if(isset($_POST["id"])) {
	$pro_id = $_POST["id"];
}
if (!(isset($_POST['pagenum']))) { 
	$pagenum = 1; 
} else {
	$pagenum = intval($_POST['pagenum']); 		
}

$page_limit =  ($_POST["show"] != "All") ? intval($_POST["show"]) : 100000;

$sql1 = "SELECT count(*) as count FROM tbl_sbreview";
if(isset($_POST["id"])) {
	$sql1 .= " WHERE project_id = '".$pro_id."'";
}

try {
    $stmt = mysql_query($sql1);
    $cnt = mysql_num_rows($stmt);
} catch (Exception $ex) {
    echo $ex->getMessage();
}

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
$sql = "SELECT * FROM tbl_sbreview"; 
if(isset($_POST["id"])) {
	$sql .= " WHERE project_id = ".$pro_id;
}
$sql .= " limit ". ($lower_limit)." ,  ". ($page_limit). "";
try {
		$stmt1 =  mysql_query($sql);
		$results = mysql_num_rows($stmt1);
	} catch (Exception $ex) {
		echo $ex->getMessage();
	}
}

if($results == 0){
  die('No item was found with this project name.');
} else {
?>
<div style="width:100%;margin:10px;">
	
	<div id="exportPanel" style="width:48%;height:30px;float:right;text-align:right;">
		<input type="button" name="export" id="export" value="Export" style="margin-right:10px" onClick="export12();">
	</div>
</div>
<?php 
echo "<table cellpadding='5' cellspacing='0' border='1'>
	<tr>
	  <th>Review Date</th>
	  <th>Project Name</th>
	  <th>Course Name</th>
	  <th>Learning Hours</th>
	  <th>Author</th>
	  <th>Reviewer</th>
	  <th>SB Review Round</th>
	  <th>No. of L1 Issues</th>
	  <th>No. of L2 Issues</th>
	  <th>No. of L3 Issues</th>
	  <th>Comment</th>
	  <th>SVN Path of the Reviewed SB</th>
	  <th>Attachment</th>
	  <th>Review Submit Date</th>
	</tr>
	";
	while($row = mysql_fetch_assoc($stmt1))
	{
	  echo "<tr>";
	  echo "<td>".$row['review_date']."</td>";
	  echo "<td>".$row['project_name']."</td>";
	 
	  echo "<td>".$row['course_name']."</td>";
	  echo "<td>".$row['learning_hours']."</td>";
	  echo "<td>".$row['author']."</td>";
	  echo "<td>".$row['reviewer']."</td>";
	  echo "<td>".$row['sb_review_round']."</td>";
	  echo "<td>".$row['l1_issues']."</td>";
	  echo "<td>".$row['l2_issues']."</td>";
	  echo "<td>".$row['l3_issues']."</td>";
	  echo "<td>".$row['comment']."</td>";
	  echo "<td>".$row['svn_path_reviewe']."</td>";
	  echo "<td>".($row['attachment'] ? "<a href='support/".$row['attachment']."' target='_blank'>Click here</a>" : '')."</td>";
	  echo "<td>".$row['review_submit_date']."</td>";
	}
  echo "</table>";
}
?>
<table width="50%" border="0" cellspacing="0" cellpadding="2"  align="center">
<tr>
  <td valign="top" align="left">
	
<label> Rows Limit: 
<?php $_GET["show"] = isset($_GET["show"]) ? $_GET["show"] : ''; ?>
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
