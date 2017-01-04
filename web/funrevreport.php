<html>
<head>
<?php	
error_reporting(0);
session_start();
	
if(!(isset($_SESSION['login']) && $_SESSION['login'] != '')){
  header ("Location:index.php");
}
$user=$_SESSION['login'];    
  
include("config.php");  

$query  = "select username from login where uniqueid='$user'";
$retval = mysql_query( $query, $con );
$count  = mysql_num_rows($retval);
	
if($count==0){
  die('Data Not Found Please contact SEPG');
}

while($row = mysql_fetch_assoc($retval)){ 
  echo "<br>";
  echo "<br>"; 
  echo "<h4>"."Hi ".$row['username']." ! Welcome to Functional Review Interface"."</h4>";
  $username=$row['username'];
}

$project = isset($_REQUEST['project']) && $_REQUEST['project'] != '' ? $_REQUEST['project'] :  '';
$pro_id = isset($_REQUEST['pro_id']) && $_REQUEST['pro_id'] != '' ? $_REQUEST['pro_id'] :  '';

$bugcategory = 'Instructional Design';
if( isset($_POST['issueinfo']) && $_POST['issueinfo'] == 'Issue Info'){
  $bugcategory = $_POST['bugCategories'];
}
?>
<style>
div.ex{
  height:250px;
  width:400px;
  background-color:white
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
  border: 1px outset #b37d00 ;
}

.table_text{
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
</head>

<body background="bg.gif">
<table width="99%" border="0" cellspacing="0" cellpadding="0" bordercolor="orangered" class="table_text">
  <tr class="table_text">
    <td valign="top" align="left"><input type="button" name="goback" class="button" value="Go Back" onclick="location.href='funrev.php';"></td>                      
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>                  
  </tr>        
</table>
<form name="formCat" id="formCat" action="" method="post">
<?php
	if($project != ""){
		echo "<input type='hidden' name='project' id='project' value='".$project."'>";
		echo "<input type='hidden' name='project_id' id='project_id' value='".$pro_id."'>";
	}
?>
<table width="18%" border="0" cellspacing="0" cellpadding="0" bordercolor="orangered" class="table_text">
  <tr>
    <td>
      <select name="bugCategories" id="bugCategories" size="1">
        <option value="select" selected>Select bug category</option>
        <option value="all" <?php echo ($bugcategory=='all')?' selected':''; ?>>Select all</option>
        <option value="Instructional Design" <?php echo ($bugcategory=='Instructional Design')?' selected':''; ?>>Instructional Design</option>
        <option value="Media" <?php echo ($bugcategory=='Media')?' selected':''; ?>>Media</option>
        <option value="Functionality" <?php echo ($bugcategory=='Functionality')?' selected':''; ?>>Functionality</option>
      </select>
    </td>
    <td><input type="submit" class="button" name="issueinfo" value="Issue Info"></td>
  </tr>        
</table>
</form>
<table width="99%" border="0" cellspacing="0" cellpadding="0" bordercolor="orangered">
  <tr class="table_text">
    <td valign="top" align="left">
      <a href="funrevreportexport.php?cat=<?php echo $bugcategory; ?>">Export result</a><br /><br />
    </td>                      
  </tr>
</table>
<form name="tstest" action="./funrev.php" method="post" enctype="multipart/form-data">  
<table width="80%" border="1" cellspacing="0" cellpadding="0" bordercolor="orangered" class="table_text">
  <tr class="table_text">
    <th valign="top">S. No.</th>
    <th valign="top">Project</th>    
    <th valign="top">Reviewer</th>                  
    <th valign="top">Reviewee</th>
<?php
$rowcount = 1;
$catArray = array('Instructional Design', 'Media', 'Functionality');
if($bugcategory != 'all'){
  echo "<th valign='top'>" . ucwords($bugcategory) . "</th>";
  $selectSubCategories = "SELECT subcat FROM catmaster WHERE cat='$bugcategory'";
  $querySubCategories  = mysql_query($selectSubCategories);
  while($fetchSubCategories = mysql_fetch_array($querySubCategories)){
    echo "<th valign='top'>" . ucwords($fetchSubCategories['subcat']) . "</th>";
    $rowcount++;
  }
}else{
  echo "<th valign='top'>Instructional Design</th>";
  echo "<th valign='top'>Media</th>";
  echo "<th valign='top'>Functionality</th>";
  $rowcount = 3;  
}
$finalrowcount = $rowcount + 4;
?>            
  </tr>
<?php

$where = "";
if($project != "") {
	$where = " AND project_id='".$pro_id."'";
}

$i=1;

$selectFunrevreport  = "SELECT `project`, `project_id`, `reviewer`, `reviewee`, `cat`, COUNT(`cat`) AS `ttlcat` FROM `blobt` 
WHERE `cat`='" . $bugcategory . "' ".$where." 
GROUP BY `project`, `reviewer`, `reviewee`, `cat` 
ORDER BY `project` ASC";
$queryFunrevreport   = mysql_query($selectFunrevreport);
$numrowsFunrevreport = mysql_num_rows($queryFunrevreport);
if( !empty($numrowsFunrevreport) ){
  while($fetchFunrevreport  = mysql_fetch_array($queryFunrevreport)){
    	echo "<tr class=\"table_text\">";
      	echo "<td class=\"table_text\" align=\"center\" valign=\"top\">".$i."</td>";
      	echo "<td class=\"table_text\" valign=\"top\"><div style=\"width:150;height:53;overflow:auto\">".$fetchFunrevreport['project']."</div></td>";      
      	echo "<td class=\"table_text\" valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchFunrevreport['reviewer']."</div></td>";     
      	echo "<td class=\"table_text\" valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchFunrevreport['reviewee']."</div></td>";    
       	echo "<td class=\"table_text\" align=\"center\" valign=\"top\"><div style=\"width:50;height:53;overflow:auto\">".$fetchFunrevreport['ttlcat']."</div></td>";        
///////////////    
if($bugcategory != 'all'){
    $selectSubCategories = "SELECT subcat FROM catmaster WHERE cat='$bugcategory'";
    $querySubCategories  = mysql_query($selectSubCategories);
    while($fetchSubCategories  = mysql_fetch_array($querySubCategories)){
      $selectSCV = "SELECT COUNT(subcat) AS ttlsubcat FROM blobt WHERE project_id='".$fetchFunrevreport['project_id']."' AND reviewer='".$fetchFunrevreport['reviewer']."' AND reviewee='".$fetchFunrevreport['reviewee']."' AND cat='".$bugcategory."' AND subcat='".$fetchSubCategories['subcat']."'";
      $querySCV  = mysql_query($selectSCV);
      $fetchSCV  = mysql_fetch_assoc($querySCV);
      
      echo "<td class=\"table_text\" align=\"center\" valign=\"top\"><div style=\"width:50;height:53;overflow:auto\">".$fetchSCV['ttlsubcat']."</div></td>";
    }
}else{
      foreach($catArray as $catName){
      $queryOther = mysql_query("SELECT count(cat) as ttlcat FROM `blobt` WHERE project_id = '" . $fetchFunrevreport['project_id'] . "' AND reviewer='" . $fetchFunrevreport['reviewer'] . "' AND reviewee = '" . $fetchFunrevreport['reviewee'] . "' AND cat = '" . $catName . "'");      
      $fetchOther  = mysql_fetch_array($queryOther);
       	echo "<td class='table_text' align='center' valign='top'><div style='width:50;height:53;overflow:auto'>".$fetchOther['ttlcat']."</div></td>";
      }
} 
////////////     
    	echo "</tr>";
    $i++; 
  }
}else{
    	echo "<tr>";
      	echo "<td colspan=".$finalrowcount." align='center' valign='top'>Not result found.</td>";
    	echo "</tr>";
}

mysql_close($con);
?> 
</table>
</form>
<table width="99%" border="0" cellspacing="0" cellpadding="0" bordercolor="orangered">
  <tr>
    <td colspan="20" valign="top">&nbsp;</td>                  
  </tr>
  <tr class="table_text">
    <td valign="top" align="left"><input type="button" name="goback" class="button" value="Go Back" onclick="location.href='funrev.php';"></td>                      
  </tr>  
</table>
</body>
</html>