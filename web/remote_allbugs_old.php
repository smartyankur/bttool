<?php
ob_start();
session_start();
include_once("lib/pagination.class.php");
include('config.php');

$page = !isset($_REQUEST['page']) ? 1 : $_REQUEST['page'];
$sb = !isset($_REQUEST['sb']) ? 'uploaddate' : $_REQUEST['sb'];
$so = !isset($_REQUEST['so']) ? 'd' : $_REQUEST['so'];
$project = isset($_REQUEST['project_name'])?$_REQUEST['project_name']: $_REQUEST['project'];
$filter_name = isset($_REQUEST['filter_name']) ? $_REQUEST['filter_name'] : '';
$filter_value = isset($_REQUEST[str_replace('filter_','',$filter_name)]) ? $_REQUEST[str_replace('filter_','',$filter_name)] : '';
$export = isset($_REQUEST['export']) && $_REQUEST['export']=="true" ? true : false;

?>
<html>
<head>
	<title></title>
	<style>
		body{
			margin:10px 0px;
			font-family:Arial;
			font-size:12px;
		}
		td{
			font-family:Arial;
			font-size:12px;
		}
		th{
			font-family:Arial;
			font-size:12px;
		}
	</style>
</head>
<body>
	<?php
	$user=$_SESSION['login'];
	$query = "select username from login where uniqueid='$user'";
	$retval = mysql_query( $query, $con );
	$count = mysql_num_rows($retval);
	
	if($count==0){
		die('Data Not Found Please contact SEPG');
	}


	while($row = mysql_fetch_assoc($retval)) { 
		$username=$row['username'];
	} 	

	if(isset($_REQUEST['project_name']) && $_REQUEST['project_name'] != ''){
		$username = $_SESSION['username'];
		$project_name = $_REQUEST['project_name'];

	}

	?>

	<div style='width:100%;height:32px;'>
		<div style='width:50%;float:left;height:32px;text-indent:10px;'><img src="images/G_Cube_logo1.png" style="margin-bottom:4px;"></div>
		<div style='width:46%;float:right;margin-right:10px;height:32px;text-align:left;'>Hi <?=$username?> !<br/> Welcome to QC bug logging Tool </div>
	</div>
	<div style="width:100%;height:5px;line-height:5px;text-indent:10px;background-color:rgb(247,148,28);color:#FFFFFF"></div>
	<div style="width:100%;height:5px;line-height:5px;text-indent:10px;background-color:rgb(251,192,122);"></div>
	<div style="width:100%;height:10px;"></div>
	<div style="width:10%;float:left;text-indent:5%;">
		<a href="javascript:void(0);" onClick="window.open(location.href+'&export=true')">Export</a>
	</div>
	<div id="filters" style="width:85%;margin:0 auto;text-align:right">
		<script src="js/jquery.js"></script>
		<script>
			var active_filter = '<?=$filter_name?>';
			$(document).ready(function(){
				if(active_filter != '') {
					$('#filter_name').val(active_filter);
					$('#'+active_filter).show();
					$('#'+active_filter.replace('filter_','')).val('<?=$filter_value?>');
					$('#filter_submit').show();
				}

				$('#filter_name').change(function(){

					if(active_filter != '') {
						$('#'+active_filter).hide();
						$('#'+active_filter.replace('filter_','')).val('');	
					} 


					if($(this).val() != ''){
						$('#filter_submit').show();
					} else {
						$('#filter_submit').hide();
					}

					if($(this).val() != ''){
						$('#'+$(this).val()).show();
					}
					active_filter = $(this).val();

					if(active_filter == '')  {
						location.href='?project_name=<?=$project_name?>';
					}
				});
			});
			function verify(){
				if(active_filter != ''){
					if($('#'+active_filter.replace('filter_','')).val()==''){
						alert('Please enter '+active_filter.replace('filter_','')+'  value');
						return false;
					}
				} else {
					return false;
				}
				return true;
			}
		</script>
		<form action="remote_allbugs.php" metod="post" onSubmit="return verify();">
			<input type="hidden" name="project_name" value="<?=$project?>">
			<input type="hidden" name="sb" value="<?=$sb?>">
			<input type="hidden" name="so" value="<?=$so?>">
			<input type="hidden" name="page" value="<?=$page?>">
			<select id="filter_name" name="filter_name" style="width:140px;">
				<option value="">Select Filter</option>
				<option value="filter_phase">Phase</option>
				<option value="filter_module">Module</option>
				<option value="filter_topic">Topic</option>
				<option value="filter_screen">Screen</option>
				<option value="filter_browser">Browser</option>
				<option value="filter_bcat">Bug Category</option>
				<option value="filter_severity">Severity</option>
				<option value="filter_bugstatus">Bug Status</option>
			</select>
			<span id="filter_values" style="width:175px;display:inline-block;">
				<span id="filter_phase" style="display:none;">
					<select id="phase" name="phase" style="width:140px">
						<option value="">Select Phase</option>
						<option value="alpha">Alpha</option>
						<option value="beta">Beta</option>
						<option value="gold">Gold</option>
						<option value="POC">POC</option>
					</select>
				</span>
				<span id="filter_module" style="display:none;">
					<select id="module" name="module" style="width:140px">
						<option value="">Select Module</option>
					<?php
						// generate all module names
						$sql_query = "SELECT DISTINCT module FROM qcuploadinfo WHERE qc='".$username."' AND project='".$project_name."'";
						$result_module = mysql_query($sql_query);
						if(mysql_num_rows($result_module) > 0) {
							while($row = mysql_fetch_row($result_module)) {
								echo "<option value='".$row[0]."'>".$row[0]."</option>";
							}
						}
					?>
					</select>


					<!--
						<input type="text" name="module" id="module" value="" maxlength="100" style="width:140px" placeholder="Type Module name">
					-->
				</span>
				<span id="filter_topic" style="display:none;">
					<select id="topic" name="topic" style="width:140px">
						<option value="">Select Topic</option>
					<?php
						// generate all module names
						$sql_query = "SELECT DISTINCT topic FROM qcuploadinfo WHERE qc='".$username."' AND project='".$project_name."'";
						$result_topic = mysql_query($sql_query);
						if(mysql_num_rows($result_topic) > 0) {
							while($row = mysql_fetch_row($result_topic)) {
								echo "<option value='".$row[0]."'>".$row[0]."</option>";
							}
						}
					?>
					</select>
					<!--
						<input type="text" name="topic" id="topic" value="" maxlength="100" style="width:140px" placeholder="Type Topic name">
					-->
				</span>
				<span id="filter_screen" style="display:none;">
					<select id="screen" name="screen" style="width:140px">
						<option value="">Select screen</option>
					<?php
						// generate all module names
						$sql_query = "SELECT DISTINCT screen FROM qcuploadinfo WHERE qc='".$username."' AND project='".$project_name."'";
						$result_screen = mysql_query($sql_query);
						if(mysql_num_rows($result_screen) > 0) {
							while($row = mysql_fetch_row($result_screen)) {
								echo "<option value='".$row[0]."'>".$row[0]."</option>";
							}
						}
					?>
					</select>

					<!--
						<input type="text" name="screen" id="screen" value="" maxlength="100" style="width:140px" placeholder="Type Screen name">
					-->
				</span>
				<span id="filter_browser" style="display:none;">
					<select id="browser" name="browser" style="width:140px">
						<option value="">Select Browser</option>
						<option value="IE6">IE6</option>
						<option value="IE7">IE7</option>
						<option value="IE8">IE8</option>
						<option value="IE9">IE9</option>
						<option value="IE10">IE10</option>
						<option value="IE11">IE11</option>
						<option value="IE12">IE12</option>
						<option value="Chrome">Chrome</option>
						<option value="Firefox">Firefox</option>
						<option value="Ipad2">Ipad2</option>
						<option value="Ipad3">Ipad3</option>
						<option value="Ipad4">Ipad4</option>
						<option value="Android Phone">Android Phone</option>
						<option value="Android Tablet">Android Tablet</option>
						<option value="Safari">Safari</option>
						<option value="IPhone">IPhone</option>
					</select>
				</span>
				<span id="filter_bcat" style="display:none;">
					<select id="bcat" name="bcat" style="width:140px">
						<option value="">Select Bug Category</option>
						<option value="global">Global</option>
						<option value="editorial">Editorial</option>
						<option value="media">Media</option>
						<option value="functionality">Functionality</option>
						<option value="audio">Audio</option>
						<option value="suggestion">Suggestion</option>
					</select>
				</span>
				<span id="filter_severity" style="display:none;">
					<select id="severity" name="severity" style="width:140px">
						<option value="">Select Severity</option>
						<option value="High">High</option>
						<option value="Medium">Medium</option>
						<option value="Low">Low</option>
					</select>
				</span>
				<span id="filter_bugstatus" style="display:none;">
					<select id="bugstatus" name="bugstatus" style="width:140px">
						<option value="">Select Bug Status</option>
						<option value="hold">hold</option>
						<option value="open">open</option>
						<option value="closed">closed</option>
						<option value="ok as is">ok as is</option>
						<option value="reopened">reopened</option>
						<option value="fixed">fixed</option>
					</select>
				</span>
				<span id="filter_submit" style="display:none;">
					<input type="submit" name="submit" value="&raquo;">
				<span>
			</span>
		</form>
	</div>
	<table cellspacing="0" cellpadding="2" width="95%" border="1" style="border-collapse:collapse" align="center">
			<tr>
				<th width="15%"><a href="remote_allbugs.php?project_name=<?=$project?>&page=<?=$page?>&sb=project&so=<?=($so=="a")?"d":"a"?>&filter_name=<?=$filter_name?>&<?=str_replace('filter_','',$filter_name)?>=<?=$filter_value?>">Project</a></th>
				<th width="5%"><a href="remote_allbugs.php?project_name=<?=$project?>&page=<?=$page?>&sb=phase&so=<?=($so=="a")?"d":"a"?>&filter_name=<?=$filter_name?>&<?=str_replace('filter_','',$filter_name)?>=<?=$filter_value?>">Phase</a></th>
				<th width="6%"><a href="remote_allbugs.php?project_name=<?=$project?>&page=<?=$page?>&sb=module&so=<?=($so=="a")?"d":"a"?>&filter_name=<?=$filter_name?>&<?=str_replace('filter_','',$filter_name)?>=<?=$filter_value?>">Module</a></th>
				<th width="6%"><a href="remote_allbugs.php?project_name=<?=$project?>&page=<?=$page?>&sb=topic&so=<?=($so=="a")?"d":"a"?>&filter_name=<?=$filter_name?>&<?=str_replace('filter_','',$filter_name)?>=<?=$filter_value?>">Topic</a></th>
				<th width="6%"><a href="remote_allbugs.php?project_name=<?=$project?>&page=<?=$page?>&sb=screen&so=<?=($so=="a")?"d":"a"?>&filter_name=<?=$filter_name?>&<?=str_replace('filter_','',$filter_name)?>=<?=$filter_value?>">Screen</a></th>
				<th width="7%"><a href="remote_allbugs.php?project_name=<?=$project?>&page=<?=$page?>&sb=browser&so=<?=($so=="a")?"d":"a"?>&filter_name=<?=$filter_name?>&<?=str_replace('filter_','',$filter_name)?>=<?=$filter_value?>">Browser</a></th>
				<th width="7%"><a href="remote_allbugs.php?project_name=<?=$project?>&page=<?=$page?>&sb=bcat&so=<?=($so=="a")?"d":"a"?>&filter_name=<?=$filter_name?>&<?=str_replace('filter_','',$filter_name)?>=<?=$filter_value?>">Bug Category</a></th>
				<th width="7%"><a href="remote_allbugs.php?project_name=<?=$project?>&page=<?=$page?>&sb=reviewer&so=<?=($so=="a")?"d":"a"?>&filter_name=<?=$filter_name?>&<?=str_replace('filter_','',$filter_name)?>=<?=$filter_value?>">Reviewer</a></th>
				<th width="25%">Description</th>
				<th width="6%"><a href="remote_allbugs.php?project_name=<?=$project?>&page=<?=$page?>&sb=severity&so=<?=($so=="a")?"d":"a"?>&filter_name=<?=$filter_name?>&<?=str_replace('filter_','',$filter_name)?>=<?=$filter_value?>">Severity</a></th>
				<th width="11%"><a href="remote_allbugs.php?project_name=<?=$project?>&page=<?=$page?>&sb=uploaddate&so=<?=($so=="a")?"d":"a"?>&filter_name=<?=$filter_name?>&<?=str_replace('filter_','',$filter_name)?>=<?=$filter_value?>">Submission Date</a></th>
				<th width="6%"><a href="remote_allbugs.php?project_name=<?=$project?>&page=<?=$page?>&sb=bugstatus&so=<?=($so=="a")?"d":"a"?>&filter_name=<?=$filter_name?>&<?=str_replace('filter_','',$filter_name)?>=<?=$filter_value?>">Bug Status</a></th>
			</tr>
<?php
if(isset($_REQUEST['project_name']) && $_REQUEST['project_name'] != ''){
	
	//filter conditions
	$sql_where = '';
	if($filter_name != '') {
		$sql_where = " AND ".str_replace('filter_','',$filter_name)." = '". $filter_value ."'";
	}

	// for total record count
	$sql_query = "SELECT project, phase, module, topic, screen, browser, bcat, reviewer, bdr, severity, uploaddate, bugstatus FROM qcuploadinfo WHERE qc='".$username."' AND project='".$project_name."'". $sql_where;
	$result1 = mysql_query($sql_query);
	$total_records = mysql_num_rows($result1);

	// for page records
	$sql_query = "SELECT project, phase, module, topic, screen, browser, bcat, reviewer, bdr, severity, uploaddate, bugstatus FROM qcuploadinfo WHERE qc='".$username."' AND project='".$project_name."' ". $sql_where ." order by ".$sb." ".(($so=="a")?"asc":"desc");
	if(!$export){
		$sql_query.=" LIMIT ".(($page-1)*20).",20";
	}
	$result = mysql_query($sql_query);


	if(mysql_num_rows($result) > 0){
		$p = new pagination();
		$p->Items($total_records);
		$p->limit(20);
		$p->target("remote_allbugs.php?project_name=".$project_name."&sb=".$sb."&so=".$so."&filter_name=".$filter_name."&".str_replace('filter_','',$filter_name)."=".$filter_value);
		$p->currentPage(($page));
		$p->adjacents(1);

		if($export){
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
			header("Content-Disposition: attachment;filename=QC_Bugs.csv");
			header("Content-Transfer-Encoding: binary");

			$output = fopen('php://output', 'w');
			fputcsv($output, array('Project','Phase','Module','Topic','Screen','Browser','Bug Category','Reviewer','Description','Severity','Submission Date','Bug Status'));
		}

		while($row = mysql_fetch_assoc($result)){
			if(!$export) {
		?>
			<tr>
				<td><?=$row['project']?></td>
				<td><?=$row['phase']?></td>
				<td><?=$row['module']?></td>
				<td><?=$row['topic']?></td>
				<td><?=$row['screen']?></td>
				<td><?=$row['browser']?></td>
				<td><?=$row['bcat']?></td>
				<td><?=$row['reviewer']?></td>
				<td><?=$row['bdr']?></td>
				<td><?=$row['severity']?></td>
				<td><?=$row['uploaddate']?></td>
				<td><?=$row['bugstatus']?></td>
			</tr>
		<?php
			} else {
				fputcsv($output, $row);
			}
		}
		if($export){
			fclose($output);
			echo ob_get_clean();
			die();
		}
	} else {
		?>
			<tr>
				<td colspan="11" height="100px" align="center">No Comments found</td>
			</tr>
		<?php
	}
}
?>
	</table>
	<style>
	.pagination{
		margin-top:5px;
	}
	.pagination span, .pagination a{
		margin:5px;
	}
	</style>
	<div style="width:95%;text-align:center;margin-top:10px">
		<?php if($total_records > 0) { ?>
		<div id="records" style="color:gray;">
			<i>Displaying <?=($page==1)?1:(($page-1)*20)+1 ?>-<?=((($page-1)*20)+20 > $total_records)?$total_records: (($page-1)*20)+20 ?> out of <?=$total_records ?> records</i>
		</div>
		<?php } ?>
		<?= $p->show() ?>
	</div>
</body>
</html>