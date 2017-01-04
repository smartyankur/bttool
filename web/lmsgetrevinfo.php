<html>
<head>
<title>Manage Functional Review</title>
<?php
error_reporting(0);
session_start();
if(!(isset($_SESSION['login']) && $_SESSION['login'] != '')){
  header ("Location:index.php");
}
$user = $_SESSION['login'];

include("config.php");

$query = "select username from login where uniqueid='$user'";
$retval = mysql_query( $query, $con );
$count = mysql_num_rows($retval);

if($count==0){
  die('Data Not Found Please contact SEPG');
}

while($row = mysql_fetch_assoc($retval)){ 
  echo "</br>";
  echo "</br>";
  echo "</br>";
  echo "<h4>" . "Hi " . $row['username'] . " ! Welcome to Manage Ticket Interface" . "</h4>";
  $username = $row['username'];
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

.table_text {
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
      <input type="button" name="goback" class="button" value="Go Back" onclick="location.href='lmsbt.php';">  
    </td>
  </tr>
</table>
<br />
<table width="80%" border="1" cellspacing="0" cellpadding="0" bordercolor="orangered" class="table_text">
  <tr class="table_text">
    <th>Bug ID</th>
    <th>Req ID</th>
    <th>Reviewer</th>
    <th>Developer</th>
    <th>Build</th>
    <th>Module</th>
    <th>Submodule</th>
    <th>Type</th>
    <th>Category</th>
    <th>Priority</th>
    <th>Severity</th>
    <th>Status</th>
    <th>BugDesc</th>
    <th>Grab</th>
    <th>Entry Date</th>
    <th>Action</th>  
  </tr>

<?php
if( isset($_REQUEST['requestId']) && !empty($_REQUEST['requestId']) && ($_REQUEST['requestId'] != "Select") ){
  $selectFuncRvw = "SELECT * FROM lmsblob where project='".$_REQUEST['q']."' and reqid='".$_REQUEST['requestId']."'";
}else{
  $selectFuncRvw = "SELECT * FROM lmsblob where project='".$_REQUEST['q']."'";    
}

$queryFuncRvw = mysql_query($selectFuncRvw);
$numrowsFuncRvw = mysql_num_rows($queryFuncRvw);
if( !empty($numrowsFuncRvw) ){
  while($fetchFuncRvw = mysql_fetch_array($queryFuncRvw)){
    echo "<tr>";
      echo "<td>"."<div align=center style="."width:50;height:100;overflow:auto>".$fetchFuncRvw['id']."</div>"."</td>";  
      echo "<td>"."<div align=center style="."width:50;height:100;overflow:auto>".$fetchFuncRvw['reqid']."</div>"."</td>";
      echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$fetchFuncRvw['reviewer']."</div>"."</td>";
      echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$fetchFuncRvw['dev']."</div>"."</td>";
      echo "<td>"."<div align=center style="."width:50;height:100;overflow:auto>".$fetchFuncRvw['build']."</div>"."</td>";
      echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$fetchFuncRvw['module']."</div>"."</td>";
      echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$fetchFuncRvw['submodule']."</div>"."</td>";
      echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$fetchFuncRvw['type']."</div>"."</td>";
      echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$fetchFuncRvw['btype']."</div>"."</td>";
      echo "<td>"."<div align=center style="."width:75;height:100;overflow:auto>".$fetchFuncRvw['priority']."</div>"."</td>";
      echo "<td>"."<div align=center style="."width:75;height:100;overflow:auto>".$fetchFuncRvw['severity']."</div>"."</td>";
      echo "<td>"."<div align=center style="."width:75;height:100;overflow:auto>".$fetchFuncRvw['status']."</div>"."</td>";
      echo "<td>"."<div align=center style="."width:250;height:100;overflow:auto>".$fetchFuncRvw['bdr']."</div>"."</td>";
      echo "<td>"."<div align=center style="."width:350;height:100;overflow:auto>".$fetchFuncRvw['grab']."</div>"."</td>";
      echo "<td>"."<div align=center style="."width:100;height:100;overflow:auto>".$fetchFuncRvw['entrydate']."</div>"."</td>";
      echo "<td><a href='lmsbtedit.php?bugid=".base64_encode($fetchFuncRvw['id'])."'>Edit</a></td>";      
    echo "</tr>";
  }
}else{
  echo "<tr>";
    echo "<td> No record found.</td>";    
  echo "</tr>";  
}  

mysql_close($con);
?>
</table>
<br />
<input type="button" name="goback" class="button" value="Go Back" onclick="location.href='lmsbt.php';">
<input type="button" name="gotologout" class="button" value="Log Out" onclick="location.href='logout.php';">
</body>
</html>