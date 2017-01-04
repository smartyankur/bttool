<html>
<head>
<title>Manage Course Handover Documents</title>
<?php
error_reporting(0);
session_start();

if(!(isset($_SESSION['login']) && $_SESSION['login'] != '')){
  header ("Location:index.php");
}
$user = $_SESSION['login'];

include("config.php");

$query = "select username, role from login where uniqueid='$user'";
$retval = mysql_query( $query, $con );
$count = mysql_num_rows($retval);

if($count==0){
  die('Data Not Found Please contact SEPG');
}

while($row = mysql_fetch_assoc($retval)){ 
  echo "</br>";
  echo "</br>";
  echo "</br>";
  echo "<h4>" . "Hi " . $row['username'] . " ! Welcome to Course Handover Document" . "</h4>";
  $username = $row['username'];
  $userrole = $row['role'];  
}

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
<script type="text/javascript">
function submitchdresponse(str){

stt     = 'chd' + str;
var ptr = document.getElementById(stt).value;

if(ptr=="select"){
  alert ("The status must be selected");
  return false;
}

if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
}else{// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}

xmlhttp.onreadystatechange=function(){
  if(xmlhttp.readyState==4 && xmlhttp.status==200){
    document.getElementById("ResHint").innerHTML=xmlhttp.responseText;
  }
}

xmlhttp.open("GET", "chdstatus.php?q="+str+ "&r=" + ptr, true);
xmlhttp.send();

}
</script>
</head>

<body background="bg.gif">
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
<tr>
  <td>
    <input type="button" name="goback" class="button" value="Go Back" onclick="location.href='chd.php';">  
  </td>
</tr>
</table>
<br />
<table width="80%" border="1" cellspacing="0" cellpadding="0" bordercolor="orangered" class="table_text">
<div id="ResHint"></div>
<tr>
  <th>S. No.</th>
  <th>Project Name</th>
  <th>Project Manager</th>  
  <th>Course Title</th>
  <th>Start Date</th>
  <th>Course Level</th>
  <th>Functional Manager[ID]</th>
  <th>Functional Manager[Med]</th>
  <th>Functional Manager[Tech]</th>
  <th>Developers</th>
  <th>Version</th>
  <th>No of HTML/Flash Pages</th>
  <th>Learning Hours</th>
  <th>Scope for testing</th>  
  <th>Partial Testing</th>
  <th>Confirmation On Reviews</th>  
  <th>Course Path [SVN]</th>
  <th>SB Path [SVN]</th>  
  <th>Development Tracker Path [SVN]</th>
  <th>Test Plan Path [SVN]</th>
  <th>Test Case/Checklists [SVN]</th>
  <th>Reviewer</th>  
  <th>QC/s</th>
  <th>Remarks</th>
  <?php if($userrole == 'QC'){ ?>
  <th>Status</th>
  <th>Change Status</th>
  <th>Assignment</th>
  <?php } ?>    
  <th>Comments</th>
  <th>Attach supporting documents</th>
</tr>
<?php
$i = 1;
$rownumbers = 26;
if( isset($_REQUEST['project']) && !empty($_REQUEST['project']) && ($_REQUEST['project'] != "Select") ){
  $selectFuncRvw="SELECT * FROM tbl_functional_review WHERE project_name = '".$_REQUEST['project']."' ORDER BY id DESC";                                   
  $queryFuncRvw = mysql_query($selectFuncRvw);
  $numrowsFuncRvw = mysql_num_rows($queryFuncRvw);
  if( !empty($numrowsFuncRvw) ){  
    while($fetchFuncRvw = mysql_fetch_array($queryFuncRvw)){    
      echo "<tr>";
        echo "<td>".$i."</td>"; 
        echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$fetchFuncRvw['project_name']."</div>"."</td>";
        echo "<td>"."<div align=center style="."width:50;height:100;overflow:auto>".$fetchFuncRvw['project_manager']."</div>"."</td>";  
        echo "<td>"."<div align=center style="."width:50;height:100;overflow:auto>".$fetchFuncRvw['course_title']."</div>"."</td>";
        echo "<td>"."<div align=center style="."width:75;height:100;overflow:auto>".$fetchFuncRvw['start_date']."</div>"."</td>";
        echo "<td>"."<div align=center style="."width:40;height:100;overflow:auto>".$fetchFuncRvw['course_level']."</div>"."</td>";
        echo "<td>"."<div align=center style="."width:75;height:100;overflow:auto>".$fetchFuncRvw['functional_manager_id']."</div>"."</td>";
        echo "<td>"."<div align=center style="."width:75;height:100;overflow:auto>".$fetchFuncRvw['functional_manager_media']."</div>"."</td>";
        echo "<td>"."<div align=center style="."width:75;height:100;overflow:auto>".$fetchFuncRvw['functional_manager_tech']."</div>"."</td>"; 
        echo "<td>"."<div align=center style="."width:75;height:100;overflow:auto>".$fetchFuncRvw['developers']."</div>"."</td>";
        echo "<td>"."<div align=center style="."width:40;height:100;overflow:auto>".$fetchFuncRvw['version']."</div>"."</td>";
        echo "<td>"."<div align=center style="."width:40;height:100;overflow:auto>".$fetchFuncRvw['pagecount']."</div>"."</td>";
        echo "<td>"."<div align=center style="."width:75;height:100;overflow:auto>".$fetchFuncRvw['learning_hours']."</div>"."</td>";
        echo "<td>"."<div align=center style="."width:60;height:100;overflow:auto>".$fetchFuncRvw['testing_scope']."</div>"."</td>";
        echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$fetchFuncRvw['partial_testing']."</div>"."</td>";
        echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$fetchFuncRvw['conf_reviews']."</div>"."</td>";
        echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$fetchFuncRvw['course_path']."</div>"."</td>";
        echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$fetchFuncRvw['sb_path']."</div>"."</td>";
        echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$fetchFuncRvw['dt_path']."</div>"."</td>";
        echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$fetchFuncRvw['test_plan_path']."</div>"."</td>";
        echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$fetchFuncRvw['test_checklists']."</div>"."</td>";
        echo "<td>"."<div align=center style="."width:70;height:100;overflow:auto>".$fetchFuncRvw['reviewer']."</div>"."</td>";
        echo "<td>"."<div align=center style="."width:70;height:100;overflow:auto>".$fetchFuncRvw['assignqc']."</div>"."</td>";
        echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$fetchFuncRvw['qccomment']."</div>"."</td>";
      
        if($userrole == 'QC'){
          $rownumbers = 29;
          $haystack = explode(",", $fetchFuncRvw['assignqc']);  
          if( in_array($username, $haystack) ){               
?>
        <TD>
          <select id="<?php echo "chd".$fetchFuncRvw['id']; ?>" size="1">
            <option value="select" selected>Select</option>
            <option value="accepted" <?php if($fetchFuncRvw['status'] == 'accepted')echo " selected"; ?>>Accepted</option>
            <option value="rejected" <?php if($fetchFuncRvw['status'] == 'rejected')echo " selected"; ?>>Rejected</option>
          </select>          
        </TD>
        <TD><input type="button" class="button" value="Change" onclick="submitchdresponse(<?php echo $fetchFuncRvw['id'] ?>)"></TD>
<?php     }else{ ?>        
        <TD align='center'>Not allowed</TD>
        <TD align='center'>Not allowed</TD>
<?php     } ?>
        <TD><input type="button" name="qcassignment" class="button" value="QC Assignment" onclick="location.href='chdchangestatus1.php?chdid=<?php echo $fetchFuncRvw['id']; ?>&pname=<?php echo urlencode($fetchFuncRvw['project_name']); ?>';"></TD>
<?php 
        }  
        echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$fetchFuncRvw['comments']."</div>"."</td>";
        echo "<td><div align='left' style='width:150;height:100;overflow:auto;'>
        ".((!empty($fetchFuncRvw['support_file1']))?'<a href="support/'.$fetchFuncRvw['support_file1'].'">'.$fetchFuncRvw['support_file1'].'</a><br />':'')."
        ".((!empty($fetchFuncRvw['support_file2']))?'<a href="support/'.$fetchFuncRvw['support_file2'].'">'.$fetchFuncRvw['support_file2'].'</a><br />':'')."
        ".((!empty($fetchFuncRvw['support_file3']))?'<a href="support/'.$fetchFuncRvw['support_file3'].'">'.$fetchFuncRvw['support_file3'].'</a><br />':'')."
        ".((!empty($fetchFuncRvw['support_file4']))?'<a href="support/'.$fetchFuncRvw['support_file4'].'">'.$fetchFuncRvw['support_file4'].'</a><br />':'')."
        </div></td>";
      echo "</tr>";
      $i++;  
    }
  }else{
    echo "<tr>";
      echo "<td colspan='".$rownumbers."' align='center'>No record found.</td>";    
    echo "</tr>";  
  }
}else{
  echo "<tr>";
    echo "<td colspan='".$rownumbers."' align='center'>No record found.</td>";    
  echo "</tr>";
}
mysql_close($con);
?>
</table>

<br />
<input type="button" name="goback" class="button" value="Go Back" onclick="location.href='chd.php';">
<input type="button" name="gotologout" class="button" value="Log Out" onclick="location.href='logout.php';">
</body>
</html>
 