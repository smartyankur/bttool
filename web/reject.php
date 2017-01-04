<?php	
    error_reporting(0);
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
	 echo "<h3>"."Hi ".$row['username']." ! Welcome To Task Rejection Interface"."</h3>";
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
 var reason = trim(document.getElementById('reason').value); 
 if(reason == ""){alert("Please mention reason"); return false;}
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
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" method="post" onsubmit="return verify()" action="acceptrejection.php">
<?php
$id=$_REQUEST["id"];
$status=$_REQUEST["stat"];
$masterid=$_REQUEST["mid"];

$qrs="select project,task,status,round from projecttask where id='".$masterid."'";
$rets=mysql_query( $qrs, $con );
$rows=mysql_fetch_assoc($rets);
$round=$rows['round'];
$stats=$rows['status'];
$project=$rows['project'];
$task=$rows['task'];

if($stats<>"sent to qc")
{
 die("Status is not appropriate for rejection");
}

$qr="select whosent,sendermail from qcreq where id='".$masterid."'and indx='".$id."'";
$retval = mysql_query( $qr, $con );

while($row = mysql_fetch_assoc($retval)) 
{
  $whosent=$row['whosent'];
  $sendermail=$row['sendermail'];
} 
?>
<TABLE>
<TR>
<TD>Reason For Rejection</TD>
<TD><textarea name="reason" rows="10" cols="40" id="reason"></textarea></TD>
</TR>
<TR>
<TD></TD>
<TD><i>Use Only: Alphabet,Integer,Single Space and Period</i></TD>
</TR></TABLE>
<?php
echo "<input type ='hidden' name='loggeduser' value='$username'>";
echo "<input type ='hidden' name='email' value='$email'>";
echo "<input type ='hidden' name='masterid' value='$masterid'>";
echo "<input type ='hidden' name='id' value='$id'>";
echo "<input type ='hidden' name='whosent' value='$whosent'>";
echo "<input type ='hidden' name='sendermail' value='$sendermail'>";
echo "<input type ='hidden' name='round' value='$round'>";
echo "<input type ='hidden' name='project' value='$project'>";
echo "<input type ='hidden' name='task' value='$task'>";
?>
<input type="submit" class="button" value="Reject">
</form>
<br/>
</body>
</html> 