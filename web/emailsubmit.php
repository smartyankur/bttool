<body background="bg.gif">
<?php
error_reporting(0);
include("config.php");
$email = mysql_real_escape_string($email);


$project = trim($_POST['project']);
$pmemail = trim($_POST['pmemail']);
$fmoneemail = trim($_POST['fmoneemail']);
$fmtwoemail = trim($_POST['fmtwoemail']);
$fmthreeemail = trim($_POST['fmthreeemail']);
$fmfouremail = trim($_POST['fmfouremail']);

$pm = trim($_POST['pm']);
$idfm = trim($_POST['idfm']);
$medfm = trim($_POST['medfm']);
$scrfm = trim($_POST['scrfm']);
$qcfm = trim($_POST['qcfm']);

if($pmemail=="" && $fmoneemail=="" && $fmtwoemail=="" && $fmthreeemail=="" && $fmfouremail=="") {
	echo "You haven't provided any email id".
	exit(); 
}

if($pmemail<>"") {
	if(!filter_var($pmemail, FILTER_VALIDATE_EMAIL)) {
		echo "PM Email Not correct";
		exit();
	}
}

if($fmoneemail<>"") {
	if(!filter_var($fmoneemail, FILTER_VALIDATE_EMAIL))	{
		echo "ID FM Email Not correct";
		exit();
    }
}

if($fmtwoemail<>"") {
	if(!filter_var($fmtwoemail, FILTER_VALIDATE_EMAIL)) {
		echo "MED FM Email Not correct";
		exit();
    }
}


if($fmthreeemail<>"") {
	if(!filter_var($fmthreeemail, FILTER_VALIDATE_EMAIL)) {
		echo "SCR FM Email Not correct";
		exit();
    }
}


if($fmfouremail<>"") {
	if(!filter_var($fmfouremail, FILTER_VALIDATE_EMAIL)) {
		echo "QC FM Email Not correct";
		exit();
    }
}

if($pmemail<>"") {
   $query="update login set email='$pmemail' where username='$pm'";	
   $result=mysql_query($query) or die (mysql_error());
   echo "PM email updated"."</br>";
}

if($fmoneemail<>"") {
   $query="update login set email='$fmoneemail' where username='$idfm'";	
   $result=mysql_query($query) or die (mysql_error());
   echo "ID FM email updated"."</br>";
}

if($fmtwoemail<>"") {
   $query="update login set email='$fmtwoemail' where username='$medfm'";	
   $result=mysql_query($query) or die (mysql_error());
   echo "MED FM email updated"."</br>";
}

if($fmthreeemail<>"") {
   $query="update login set email='$fmthreeemail' where username='$scrfm'";	
   $result=mysql_query($query) or die (mysql_error());
   echo "SCR FM email updated"."</br>";
}

if($fmfouremail<>"") {
   $query="update login set email='$fmfouremail' where username='$qcfm'";	
   $result=mysql_query($query) or die (mysql_error());
   echo "QC FM email updated"."</br>";
}
mysql_close($con);
?>
</body>