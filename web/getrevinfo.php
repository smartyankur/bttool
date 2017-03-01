<?php
require_once("pagination/configure.php");
$q         = $_GET["q"];
$pro_id    = $_GET["pro_id"];
$bugCat    = $_GET["bugCat"];
$bugStatus = $_GET["bugStatus"];

include("config.php");

if (!(isset($_GET['pagenum']))) { 
	$pagenum = 1; 
} else {
	$pagenum = intval($_GET['pagenum']); 		
}

$page_limit =  ($_GET["show"] != "All") ? intval($_GET["show"]) : 100000;

$sql = "SELECT cat, status FROM blobt where project_id='$pro_id'";

if( !empty($bugCat) && $bugCat != "select" && $bugCat != "all"){
  $sql .= " and cat='".$bugCat."'";
}

if( !empty($bugStatus) && ($bugStatus != "select") && ($bugStatus != "all") ){
  $sql .= " and status='".$bugStatus."'";
}

try {
    $stmt = $DB->prepare($sql);
    $stmt->execute();
    $tresults = $stmt->fetchAll();
} catch (Exception $ex) {
    echo($ex->getMessage());
}
$cnt = count($tresults);

if($cnt > 0) {

$firstArray = array("open"=> 0, "closed"=> 0, "hold"=> 0, "reopened"=> 0, "ok as is"=> 0, "fixed" => 0, "global" => 0, "editorial"=>0, "Media"=>0, "Functionality"=>0, "audio"=>0, "suggesstion"=>0);

foreach($tresults as $val){
	if(array_key_exists($val['status'], $firstArray)) {
		$firstArray[$val['status']] = $firstArray[$val['status']] + 1;
	} if(array_key_exists($val['cat'], $firstArray)) {
		$firstArray[$val['cat']] = $firstArray[$val['cat']] + 1;
	}
}
	
	echo "<table width='700' cellspacing='0' cellpadding='0' border='0'>";
    echo "<tr>";
      echo "<td width='700'>";    
      $z = 1;  
      foreach($firstArray as $keyBugsCount => $valueBugsCount){  
        //if($valueBugsCount == 0) continue;
		if($keyBugsCount == "global") echo "<br><br>";
		echo "<b>" . ucfirst($keyBugsCount) . " : </b>" . $valueBugsCount;
        if(count($firstArray) != $z){ echo ',&nbsp;&nbsp;'; }        
        $z++;    
      } 
	  echo ", <b> Total : </b>" . $cnt; 
      echo "</td>";    
    echo "</tr>";
  echo "</table>";


$last = ceil($cnt/$page_limit); 

//this makes sure the page number isn't below one, or more than our maximum pages 
if ($pagenum < 1) { 
	$pagenum = 1; 
} elseif ($pagenum > $last)  { 
	$pagenum = $last; 
}
$lower_limit = ($pagenum - 1) * $page_limit;


  $sql1 = "SELECT * FROM blobt WHERE project_id = ".$pro_id;
    if( !empty($bugCat) && $bugCat != "select" && $bugCat != "all"){
		$sql1 .= " and cat='".$bugCat."'";
    }

	if( !empty($bugStatus) && ($bugStatus != "select") && ($bugStatus != "all") ){
		$sql1 .= " and status='".$bugStatus."'";
	}
	$sql1 .=  " limit ". ($lower_limit)." ,  ". ($page_limit). "";
	try {
		$stmt = $DB->prepare($sql1);
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

<table width='100%' border='1' cellspacing='0' cellpadding='0'>

<tr><th>ID</th><!--<th>Project</th>--><th>Phase</th><th>Reviewee</th><th>Cat</th><th>SubCat</th><th>Bug</th><th>Image</th><th>Reviewer</th><th>Status</th><th>Last Comment</th><th>Select Status</th><th>Comment</th><th>Click-Change</th><th>Change Reviewee</th><th>Creation Date</th></tr>
<?php
if($cnt > 0) {
foreach($results as $row)
  {
  echo "<tr>";
  echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$row['id']."</div>"."</td>";
  //echo "<td>"."<div align=center style="."width:150;height:100;overflow:auto>".$row['project']."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$row['phase']."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$row['reviewee']."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$row['cat']."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$row['subcat']."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:200;height:100;overflow:auto>".$row['desc1']."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:300;height:100;overflow:auto>".$row['grab']."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:150;height:100;overflow:auto>".$row['reviewer']."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$row['status']."</div>"."</td>";
  echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$row['comment']."</div>"."</td>";
  ?>
  <TD><select id="<?php echo $row['id'];?>" size="1">
  <option value="select" selected>Select</option>
  <option value="fixed">Fixed</option>
  <option value="ok as is">Ok As IS</option>
  <option value="hold">Hold</option>
  <option value="reopened">Reopen</option>
  <option value="closed">Close</option>
  </select></TD>
  <TD><textarea name="<?php echo "txt".$row['id'];?>" rows="2" cols="10" id="<?php echo "txt".$row['id'];?>"></textarea></TD>
  <TD><input type="button" class="button" value="Change Status" onclick="submitresponse(<?php echo $row['id'] ?>)"></TD>
  <TD><input type="button" class="button" value="Change Reviewee" onclick="submitrev(<?php echo $row['id'] ?>)"></TD>
  <TD align="center" valign="top"><?php echo (!empty($row['creationDate'])) ? date("Y-m-d H:i:s", $row['creationDate']) : "N/A"; ?></TD>
  <?php
  echo "</tr>";
} 
} else {
	echo "<tr><td colspan='15' align='center'> No record Found</td></tr>";
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