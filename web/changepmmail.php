<html>
<head>
<script type="text/javascript">

function trim(s) {
	return rtrim(ltrim(s));
}

function ltrim(s) {
	var l=0;
	while(l < s.length && s[l] == ' ')
	{	l++; }
	return s.substring(l, s.length);
}

function rtrim(s) {
	var r=s.length -1;
	while(r > 0 && s[r] == ' ')
	{	r-=1;	}
	return s.substring(0, r+1);
}

function validateForm() {
	var b=trim(document.forms["tstest"]["fmemail"].value);
	if (b=="") {
		alert("Email ID should be provided.");
		return false;
	}
}
</script>
</head>

<body background="bg.gif">
<form name="tstest" action="emailsubmit.php" onsubmit="return validateForm()" method="post">

<TABLE>
<?php
error_reporting(0);
include("config.php");
$project = $_REQUEST['id'];
$project_id = $_REQUEST['pro_id'];
/* @saurav Modify query to fetch data using pindatabaseid */ 
$query="select projectmanager,fmone,fmtwo,fmthree,fmfour from projectmaster where pindatabaseid = '$project_id'";
$result=mysql_query($query) or die (mysql_error());
while($row = mysql_fetch_assoc($result)) { 
     $pm=$row['projectmanager'];
	 $fmone=$row['fmone'];
     $fmtwo=$row['fmtwo'];
	 $fmthree=$row['fmthree'];
     $fmfour=$row['fmfour'];
}
/* @saurav modify script to merge 5 query in one */
$mquery = "select email, username from login where username IN('$pm', '$fmone', '$fmtwo', '$fmthree', '$fmfour')";
$mresult=mysql_query($mquery) or die (mysql_error());
$tmp = array();
while($mrow = mysql_fetch_assoc($mresult)) { 
    $tmp[$mrow['username']] = $mrow['email'];
}

/*$mquery="select email from login where username='$pm'";
$mresult=mysql_query($mquery) or die (mysql_error());

while($mrow = mysql_fetch_assoc($mresult)) { 
    $pmmail=$mrow['email'];
} 	

$mquery="select email from login where username='$fmone'";
$mresult=mysql_query($mquery) or die (mysql_error());

while($mrow = mysql_fetch_assoc($mresult)) { 
    $fmonemail=$mrow['email'];
} 	

$mquery="select email from login where username='$fmtwo'";
$mresult=mysql_query($mquery) or die (mysql_error());

while($mrow = mysql_fetch_assoc($mresult)) { 
    $fmtwomail=$mrow['email'];
}

$mquery="select email from login where username='$fmthree'";
$mresult=mysql_query($mquery) or die (mysql_error());

while($mrow = mysql_fetch_assoc($mresult)) { 
    $fmthreemail=$mrow['email'];
}

$mquery="select email from login where username='$fmfour'";
$mresult=mysql_query($mquery) or die (mysql_error());

while($mrow = mysql_fetch_assoc($mresult)) { 
    $fmfourmail=$mrow['email'];
}*/

echo "<u>"."Change PM/FM Emails for project.If you dont want to give the email leave text box blank:"."</u>".$project;
?>
<TR>
<TD><?php if(trim($pm)<>"" || trim($pm)<>'NA') echo $pm;?></TD>
<TD><input type=text maxlength=40 size=30 name="pmemail" id="pmemail" value="<?php echo $tmp[$pm];?>"></TD><TD>PM</TD>
</TR>

<TR>
<TD><?php if(trim($fmone)<>"" || trim($fmone)<>'NA') echo $fmone;?></TD>
<TD><input type=text maxlength=40 size=30 name="fmoneemail" id="fmoneemail" value="<?php echo $tmp[$fmone];?>"></TD><TD>ID FM</TD>
</TR>

<TR>
<TD><?php if(trim($fmtwo)<>"" || trim($fmtwo)<>'NA') echo $fmtwo;?></TD>
<TD><input type=text maxlength=40 size=30 name="fmtwoemail" id="fmtwoemail" value="<?php echo $tmp[$fmtwo];?>"></TD><TD>MED FM</TD>
</TR>

<TR>
<TD><?php if(trim($fmthree)<>"" || trim($fmthree)<>'NA') echo $fmthree;?></TD>
<TD><input type=text maxlength=40 size=30 name="fmthreeemail" id="fmthreeemail" value="<?php echo $tmp[$fmthree];?>"></TD><TD>SCR FM</TD>
</TR>

<TR>
<TD><?php if(trim($fmfour)<>"" || trim($fmfour)<>'NA') echo $fmfour;?></TD>
<TD><input type=text maxlength=40 size=30 name="fmfouremail" id="fmemail" value="<?php echo $tmp[$fmfour];?>"></TD><TD>QC FM</TD>
</TR>

</TABLE>
<input type="submit"/>
<input type="hidden" name="project" value="<?php echo $project;?>">
<input type="hidden" name="pm" value="<?php echo $pm;?>">
<input type="hidden" name="idfm" value="<?php echo $fmone;?>">
<input type="hidden" name="medfm" value="<?php echo $fmtwo;?>">
<input type="hidden" name="scrfm" value="<?php echo $fmthree;?>">
<input type="hidden" name="qcfm" value="<?php echo $fmfour;?>">
</form>
</body>
</html> 