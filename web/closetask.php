<?php	
    error_reporting(0);
	session_start();
	
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location:index.php");
    }

    $user=$_SESSION['login'];

    include('config.php');

    $query = "select username,email from login where uniqueid='$user'";
    
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
	 echo "<h3>"."Hi ".$row['username']." ! Welcome To Task Closure Interface"."</h3>";
	 $username=$row['username'];
	 $email=$row['email'];
    } 	
?>
<html>
<head>
<script type="text/javascript">

window.onunload = unloadPage;

function unloadPage()
{
 //alert("unload event detected!");
 newwindow.close();
 //chwindow.close();
}


function verify()
{
 var decimalExpression = /^[0-9.]+$/;
 //var alphanumericExp = /^[0-9a-zA-Z._ /s]*$/;
 var task = trim(document.getElementById('task').value);
 var qc = trim(document.getElementById('qc').value);
 var task = trim(document.getElementById('task').value);
 var SDate = trim(document.getElementById('SDate').value);
 var EDate = trim(document.getElementById('EDate').value);
  
 if(task == ""){alert("Please mention task name"); return false;}
 if(qc == "select"){alert("Please mention QC details"); return false;}
 if(SDate == ""){alert("Please mention start Date"); return false;}
 if(EDate == ""){alert("Please mention end Date"); return false;}
 
 if(!effort.match(decimalExpression))
  {
	alert("Effort Should be Purely Decimal");
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
<style type="text/css">
body
{
background:url('qcr.jpg') no-repeat;
}
</style>
</head>
<body>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" method="post" onsubmit="return verify()" action="submitclose.php">
<?php
$id=$_REQUEST["id"];
$status=$_REQUEST["stat"];
$masterid=$_REQUEST["mid"];

$upqreq="select * from qcreq where id='$masterid' AND indx='$id'";
$reupreq=mysql_query($upqreq, $con);
while($rerow = mysql_fetch_assoc($reupreq)) 
 {
  $status = $rerow['status'];
  $whosent = $rerow['whosent'];
  $sendermail = $rerow['sendermail'];
 }

if($status<>"accepted")
{
 die("Status is not appropriate for closure");
}

$qr="select count(*) from qcplan where masterid='".$masterid."' AND indx='".$id."' and status='open'";
$retval = mysql_query( $qr, $con );
while($row = mysql_fetch_assoc($retval)) 
 {
  $count = $row['count(*)']; 
 } 

if($count>0)
{
 echo "Count of open tasks :".$count;
 echo "</br>";
 die("Wait until all tasks are closed by team members...");
}

else
{
 echo "Count of open tasks :".$count;
 echo "</br>";
 echo "Please click the button below to close the work packet";
}
echo "<input type ='hidden' name='loggeduser' value='$username'>";
echo "<input type ='hidden' name='email' value='$email'>";
echo "<input type ='hidden' name='id' value='$id'>";
echo "<input type ='hidden' name='mid' value='$masterid'>";
echo "<input type ='hidden' name='whosent' value='$whosent'>";
echo "<input type ='hidden' name='sendermail' value='$sendermail'>";
?>
<br>
<br>
<input type="submit" value="Close The Work Packet">
</form>
<br/>
</body>
</html> 