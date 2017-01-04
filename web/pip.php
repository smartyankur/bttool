<?php	
	session_start();
	
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location:index.php");
    }
	
	$con = mysql_connect("localhost","root","password");
    $user=$_SESSION['login'];

    if (!$con)
      {
        die('Could not connect: ' . mysql_error());
      }

	mysql_select_db("audit") or die(mysql_error());

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
       echo "<h3>"."Hi ".$row['username']." ! Welcome To PIP (Process Improvement Proposal) Interface."."<h3>";
	 $username=$row['username'];
    } 	
	?>
<html>
<head>
<script type="text/javascript">
function showhistory(str)
{
 //alert(str);
 newwindow=window.open("piphistory.php?param1="+str,"Ratting","scrollbars=1,width=550,height=170,0,status=0,");
 if (window.focus) {newwindow.focus()}
}
function showAll()
{

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
xmlhttp.open("GET","getallpip.php",true);
xmlhttp.send();
}

function submitproposal()
{
  //alert (pqr);
  var str = trim(document.getElementById('proposal').value);
  var lmn = trim(document.getElementById('practice').value);
  var pqr = trim(document.getElementById('user').value);
  //alert (pqr);

if (str=="")
  {
  alert ("Please Provide Proposal");
  document.getElementById('proposal').focus();
  return false;
  }

if (lmn=="Select")
  {
  alert ("Please Provide Practice");
  document.getElementById('practice').focus();
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
str= encodeURIComponent(str);
pqr= encodeURIComponent(pqr);
xmlhttp.open("GET","proposal.php?q="+str+ "&r=" + pqr+ "&s=" + lmn,true);
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
<style type="text/css">
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
</head>
<body>
<h2>Process Improvement Proposal. Here You May Suggest Improvement Proposal</h2>
<h5>Focus : Improved product quality,Decreased cycle time or delivery time,Greater customer satisfaction, Greater end-user satisfaction,Shorter production time to change functionality or add new features.</h5>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest">
<TABLE>
<TR>
<TD>Proposal</TD>
<TD><textarea id="proposal" rows="6" cols="30" maxlength="222"></textarea></TD>
</TR>
<TR>
<TD>Practice</TD>
<TD><select id="practice" size="1">
<option value="Select" selected>Select Practice</option>
<option value="Software Services">Software Services</option>
<option value="Content">Content</option>
<option value="Research and Development">Research and Development</option>
<option value="Business Development">Business Development</option>
<option value="Shared Services">Shared Services</option>
</select></TD>
</TR>
</TABLE>
<br>
<?php
echo "<input type ='hidden' id='user' value='$username'>";
?>
<input type="button" class="button" value="Log Out" onclick="location.href='logout.php';">
<input type="button" class="button" value="Submit the Response" onclick="submitproposal();">
<input type="button" class="button" value="Show All PIPs" onclick="showAll()">
</form>
<br />
<div id="txtHint"><b></b></div>

</body>
</html> 