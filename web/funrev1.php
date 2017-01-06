<html>
<head>
<?php	
	error_reporting(0);
	session_start();
	
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location:index.php");
    }
	
    $user=$_SESSION['login'];

    include('config.php');

    $query = "select username from login where uniqueid='$user'";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found Please contact SEPG');
		}

    
    while($row = mysql_fetch_assoc($retval)) 
    { 
       echo "<br>";
       echo "<br>"; 
       echo "<h4>"."Hi ".$row['username']." ! Welcome to Functional Review Interface"."</h4>";
	 $username=$row['username'];
    } 	

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
 //echo "Yes Submited";
 $reviewer=$_POST["reviewer"];
 $project=$_POST["project"];
 $phase=$_POST["phase"];
 $reviewee=$_POST["reviewee"];
 $bcat=$_POST["bcat"];
 $subcat=$_POST["subcat"];
 $a=mysql_real_escape_string($_POST["bdr"]);
 $b=$_POST["container"];
 //echo $b;
 $query="INSERT INTO blobt(reviewer,project,phase,reviewee,cat,subcat,desc1,grab) values('".$reviewer."','".$project."','".$phase."','".$reviewee."','".$bcat."','".$subcat."','".$a."','".$b."')";

 if (mysql_query($query))
	{
        //echo "Row Created";
		$message="Record has been created for project".$project." and "."issue : ".$a.", please click on the Show All Fileinfo to read the entry.";
		header ("Location: funrev.php?proj=".urlencode($project)."&phase=".urlencode($phase)."&reviewee=".urlencode($reviewee)."&msg=".urlencode($message));
    }
  else
	{
      die(mysql_error());
	  //echo "Row Not Created";
    }	
}

?>
<style>
div.ex
{
height:250px;
width:400px;
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
</style>
<script>
function test()
{
 //alert(123);
 var project = trim(document.getElementById('project').value);
 if(project=="Select"){alert("Please select project"); return false;};

 var phase = trim(document.getElementById('phase').value);
 if(phase=="Select"){alert("Please select phase"); return false;};
 
 var reviewee = trim(document.getElementById('reviewee').value);
 if(reviewee=="Select"){alert("Please select reviewee"); return false;}; 

 var bcat = trim(document.getElementById('bcat').value);
 if(bcat=="Select"){alert("Please select category"); return false;};

 var subcat = trim(document.getElementById('subcat').value);
 if(subcat=="Select"){alert("Please select sub-category"); return false;};

 var bdr = trim(document.getElementById('bdr').value);
 if(bdr==""){alert("Please enetr the bug description"); return false;};

 var nt = document.getElementById('grab').innerHTML;
 document.forms["tstest"].container.value += nt;
 document.forms["tstest"].submit();
}


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
xmlhttp.open("GET","getrevinfo.php?q="+project,true);
xmlhttp.send();

}

function filloption(str)
{
var cat=str;
//alert(dept);

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
    document.getElementById("OpHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","catdump.php?q="+cat,true);
xmlhttp.send();
}

function submitresponse(str)
{
re = /^[A-Za-z ]+$/;
//alert (str);
comm='txt'+str;
//alert(comm);

var ptr = document.getElementById(str).value;
//alert (ptr);

var ctr = trim(document.getElementById(comm).value);
//alert(ctr);

if (ptr=="select")
{
 alert ("The status must be selected");
 //document.getElementById(str).focus();
 return false;
}

if (ctr=="")
{
 alert ("Reason must be specified");
 //document.getElementById(str).focus();
 return false;
}

if(!ctr.match(re))
  {
  alert("Comment should be Alphabet Only");
  return false;
  }

if (str=="")
  {
  document.getElementById("ResHint").innerHTML="";
  return;
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
    document.getElementById("ResHint").innerHTML=xmlhttp.responseText;
    }
  }

ctr=encodeURIComponent(ctr);
xmlhttp.open("GET","updatefunstat.php?q="+str+ "&r=" + ptr+ "&s=" + ctr,true);
xmlhttp.send();

}


function submitrev(str)
{
//alert (str);
mywindow=window.open ("editreviewee.php?id="+str,"Ratting","scrollbars=1,width=550,height=180,0,status=0,");
if (window.focus) {mywindow.focus()}
}

function trim(s)
{
	return rtrim(ltrim(s));
}

function ltrim(s)
{
	var l=0;
	while(l < s.length && s[l] == ' ')
	{	l++; }
	return s.substring(l, s.length);
}

function rtrim(s)
{
	var r=s.length -1;
	while(r > 0 && s[r] == ' ')
	{	r-=1;	}
	return s.substring(0, r+1);
}

</script>
</head>

<body>
<form name="tstest" action="./funrev.php" onsubmit="return verify()" method="post" enctype="multipart/form-data">
<TABLE>

<TR>
	<TD>Project Name</TD>
	<td>
    <?php
    $proj=$_REQUEST["proj"];
	$phase=$_REQUEST["phase"];
	$reviewee=$_REQUEST["reviewee"];
	$message=$_REQUEST["msg"];
     
	$query = "select DISTINCT projectname from projectmaster where projectmanager= '$username' or accountmanager= '$username' or buhead='$username' or practicehead='$username' or sepghead='$username' or sepglead='$username' or md='$username' or ceo = '$username' or fmfour='$username' or fmthree='$username' or fmtwo='$username' or fmone='$username' or lead='$username' or tester1='$username' or tester2='$username' or tester3='$username' or tester4='$username' or tester5='$username' or tester6='$username' or tester7='$username' or tester8='$username'or dev1='$username' or dev2='$username' or dev3='$username' or dev4='$username' or dev5='$username' or dev6='$username' or dev7='$username' or dev8='$username'";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	//$m=$_REQUEST["project"];
	
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
	 if(strlen($row[projectname])<>0)
		{
		 ?>
         <option<?php if($proj==$row[projectname])echo " selected";?>><?php echo $row[projectname];?></option> 
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

<TR>
<TD>Phase</TD><TD><select name="phase" size="1" id="phase">
<option value="Select" selected>Select</option>
<option value="alpha" <?php if($phase=="alpha")echo " selected";?>>Alpha</option>
<option value="beta" <?php if($phase=="beta")echo " selected";?>>Beta</option>
<option value="gold" <?php if($phase=="gold")echo " selected";?>>Gold</option>
<option value="POC" <?php if($phase=="POC")echo " selected";?>>POC</option>
</select></TD>
</TR>

<TR>
<TD>Reviewee</TD>
<TD>
    <?php
	$query = "select DISTINCT username from login where role='DEV' AND dept='Content' order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}

    echo "<select name=\"reviewee\" id=\"reviewee\">"; 
    echo "<option size =30 selected value=\"Select\">Select</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
     //echo "<option>$row[username]</option>";
	 if(strlen($row[username])<>0)
		{
		 ?>
         <option<?php if($reviewee==$row[username])echo " selected";?>><?php echo $row[username];?></option> 
         <?php 
		}
    } 
    } 
    else 
	{
     echo "<option>No Names Present</option>";  
    } 
    ?>
    </TD>
</TR>

<TR>
<TD>Bug Category</TD><TD><select name="bcat" size="1" id="bcat" onchange="filloption(this.value)">
<option value="Select" selected>Select</option>
<option value="Instructional Design">Instructional Design</option>
<option value="Media">Media</option>
<option value="Functionality">Functionality</option>
</select></TD>
</TR>

<TR>
<td>Bug Subcategory</td><td><div name="OpHint" id="OpHint"></div></td>
</TR>

<TR>
<TD>Bug Description</TD>
<TD><textarea name="bdr" rows="4" cols="30" id="bdr"><?php echo stripslashes($bdr);?></textarea></TD>
</TR>

<textarea class="hide" name="container" rows="2" cols="20"></textarea>

<TR>
<TD>Screen Grab</TD>
<TD><div class="ex" contenteditable="true" id="grab" name="grab">Paste Image Here if any.Clean All These Text if pasting image...</p>
</TD>
</TR>

</TABLE>
</br>
<input type="button" class="button" value="Submit" onclick="test();">
<input type="button" class="button" value="Log Out" onclick="location.href='logout.php';">
<input type="button" class="button" value="Show All Fileinfo" onclick="showAll()">
<input type="hidden" id="luser" name="reviewer" value="<?php echo $username;?>">
<br>
<br>
<div id="ResHint"></div>
<div id="txtHint"><?php if($message<>""){echo $message;}?></div>
</form>
</body>
</html> 