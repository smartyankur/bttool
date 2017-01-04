<html>
<head>
<script type="text/javascript">

function submitresponse(str)
{

//var newMDate=document.getElementById('MDate'+str).value;
var newTDate=document.getElementById('TDate'+str).value; 

//alert(newMDate); 
alert(newTDate);

if (newMDate=="")
{
 alert ("Please Fill The New Meeting Date.");
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
xmlhttp.open("GET","dateimpacttar.php?q="+newTDate+ "&p=" + str,true);
xmlhttp.send();

}

function myPopup() {
//window.open( "http://www.google.com/" )
window.open("window-child.html","Ratting","width=550,height=170,0,status=0,");
//alert ("Hi");
}

function showAll()
{
str=document.forms["tstest"]["project"].value;
//alert (str);

if (str=="Select")
{
 alert("Please select the project");
 return; 
}

if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
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
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","updatetarget.php?q="+str,true);
xmlhttp.send();
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
<?php	
	$con = mysql_connect("localhost","root","password");
    $user=mysql_real_escape_string($_REQUEST['user']);
    //echo $user;

    if (!$con)
      {
        die('Could not connect: ' . mysql_error());
      }

	mysql_select_db("audit") or die(mysql_error());

	$query = "select username from adminlogin where uniqueid='$user'";
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found Please contact SEPG');
		}

    
    while($row = mysql_fetch_assoc($retval)) 
    { 
     echo "<h3>"."Hi ".$row['username']." ! You Can Update Action Item Status"."<h3>";
	 $username=$row['username'];
	 //$pwd=$row['pwd'];
    } 	
?>
<h3>Update or Close NC Individually</h3>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest">
<div id="ResHint"><b></b></div>
<br>
<TABLE>
<TR>
	<TD>Project Name</TD>
	<TD>
    <?php
	$query = "select DISTINCT projectname from projectmaster where projectmanager= '$username' or accountmanager= '$username' or buhead='$username' or practicehead='$username' or sepghead='$username' or sepglead='$username'";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found');
		}

    echo "<select name=\"project\">"; 
    echo "<option size =30 selected value=\"Select\">Select</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
    echo "<option>$row[projectname]</option>"; 
    } 
 
    } 
    else {
    echo "<option>No Names Present</option>";  
    } 
    ?>
    </TD>
</TR>

</TABLE>
<br>
<br>
<input type="button" value="Main Menu" onclick="document.location = 'admin.php?ruser=<?php echo $user;?>';">
<input type="button" value="Show All Action Items" onclick="showAll()">
</form>
<br />
<div id="txtHint"><b>ActionItems will appear here.</b></div>
<?php
mysql_close($con);
?>
</body>
</html> 