<html>
<head>
<?php	
  error_reporting(0);
  session_start();
  
  if(!(isset($_SESSION['login']) && $_SESSION['login'] != '')){
    header("Location:index.php");
  }
  $user = $_SESSION['login'];
  
  include("config.php");
  
  $query  = "select username from login where uniqueid='$user'";
  $retval = mysql_query( $query, $con );
  $count  = mysql_num_rows($retval);
	
  if($count==0){
    die('Data Not Found Please contact SEPG');
  }
    
  while($row = mysql_fetch_assoc($retval)){ 
    echo "</br>";
    echo "</br>";
    echo "</br>";
    echo "<h4>"."Hi ".$row['username']." ! Welcome to Bug Management Interface"."</h4>";
    $username = $row['username'];
  } 	

?>
<style>
div.ex
{
height:350px;
width:600px;
background-color:white
}
textarea.hide
{
visibility:none;
display:none;
}
body
{
background:url('qcr.jpg') no-repeat;
}
.button
{
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
<script>

function showAll()
{
var project = trim(document.getElementById('project').value);

if(project=="Select")
  {
	alert("Project must be selected");
	return false;
  }

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
project=encodeURIComponent(project);
//alert(project);
xmlhttp.open("GET","managedevinfo.php?q="+project,true);
xmlhttp.send();
}

function submitbugresponse(str){
  re   = /^[A-Za-z ]+$/;
  comm = 'txt'+str;
  stt  = 'bug'+str;
  devr = 'devreason'+str;  

  var ptr = document.getElementById(stt).value;
  if(ptr=="select"){
    alert("The status must be selected");
    return false;
  }
  
  var ctr = trim(document.getElementById(comm).value);
  if(ctr==""){
    alert ("Remarks must be specified");
    return false;
  }
  if(!ctr.match(re)){
    alert("Comment should be Alphabet Only");
    return false;
  }
  
  var devreason = document.getElementById(devr).value;
  if(devreason=="select"){
    alert("Dev Reason must be selected");
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

  ctr=encodeURIComponent(ctr);
  xmlhttp.open("GET", "updevstat.php?q="+str+"&r="+ptr+"&s="+ctr+"&devreason="+devreason,true);
  xmlhttp.send();
}

function trim(s){
  return rtrim(ltrim(s));
}

function ltrim(s){
  var l=0;
  while(l < s.length && s[l] == ' ')
  {	l++; }
  return s.substring(l, s.length);
}

function rtrim(s){
  var r=s.length -1;
  while(r > 0 && s[r] == ' ')
  {	r-=1;	}
  return s.substring(0, r+1);
}

</script>
</head>

<body>
<form name="tstest">
<TABLE>

<TR>
	<TD>Project Name</TD>
	<td>
    <?php
         
	$query = "select DISTINCT projectname from projectmaster where projectmanager= '$username' or accountmanager= '$username' or buhead='$username' or practicehead='$username' or sepghead='$username' or sepglead='$username' or md='$username' or ceo = '$username' or fmfour='$username' or fmthree='$username' or fmtwo='$username' or fmone='$username' or lead='$username' or dev1='$username' or dev2='$username' or dev3='$username' or dev4='$username' or dev5='$username' or dev6='$username' or dev7='$username' or dev8='$username'";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
		
	if($count==0)
		{
			die('Data Not Found');
		}

    echo "<select name=\"project\" id=\"project\">"; 
    echo "<option size =30 selected>Select</option>";
    if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    {
	 if(strlen($row['projectname'])<>0)
		{
		 ?>
			<option><?php echo $row['projectname'];?></option> 
         <?php 
		}
	} 
 
    } 
    else {
    echo "<option>No Names Present</option>";  
    } 
    ?>
    </td>
</TR>
</TABLE>
</br>
<input type="button" class="button" value="Log Out" onclick="location.href='logout.php';">
<input type="button" class="button" value="Show All Fileinfo" onclick="showAll()">
<input type="hidden" id="luser" name="reviewer" value="<?php echo $username;?>">
<br>
<br>
<div id="ResHint"></div>
<div id="txtHint"></div>
</form>
</body>
</html> 