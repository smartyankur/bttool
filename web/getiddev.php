<body background="bg.gif">
<?php
$pro=$_REQUEST['pro'];
//$phs=$_REQUEST['phs'];

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("audit") or die(mysql_error());

$pquery="select fmfour from projectmaster where projectname='$pro'";
//echo $pquery;
$presult=mysql_query($pquery) or die (mysql_error());
while($prow = mysql_fetch_assoc($presult)) 
    { 
     $qm=$prow['fmfour'];
	 //$username=$row['username'];
    } 	

$query="select email from login where username='$qm'";
$result=mysql_query($query) or die (mysql_error());

while($row = mysql_fetch_assoc($result)) 
    { 
     $mail=$row['email'];
	 //$username=$row['username'];
    } 	
	mysql_close($con);
?>
<script>
function verify()
{
var mail = trim(document.getElementById('pmmail').value);
var msg = trim(document.getElementById('msg').value);
var alphaExp = /^[a-zA-Z /s]*$/;

if(mail=="")
  {
  alert("Mail ID must be provided");
  return false;
  }

if(msg=="")
  {
  alert("Message must be provided");
  return false;
  }

if(!msg.match(alphaExp))
  {
  alert("Message Should be Purely Alphabetic");
  return false;
  }
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
<form name="tstest" action="./sample_code.php" onsubmit="return verify()" method="post" enctype="multipart/form-data">
<table>
<TR>
<TD>To :</TD>
<TD><input type=text maxlength=35 size=35 name="pmmail" id="pmmail" value="<?php echo $mail;?>"></TD>
</TR>
</br>
<TR>
<TD>Bug Description</TD>
<TD><textarea name="msg" rows="4" cols="30" name="msg" id="msg"><?php echo "Response for defects from programer have been logged in the tool for project ".$pro;?></textarea></TD>
</TR>
</table>
<input type="submit" value="Send Mail">
</form>
</body>