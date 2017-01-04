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
	var b=trim(document.forms["tstest"]["pmemail"].value);
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
<TR>
<TD>Project Name</TD>
<TD>
<?php
$project = $_REQUEST['id'];
Echo "<u>"."Change PM Email for project :"."</u>".$project;
?>
</TD>
</TR>

<TR>
<TD>Email</TD>
<TD><input type=text maxlength=40 size=30 name="pmemail" id="pmemail"></TD>
</TR>

</TABLE>
<input type="submit"/>
<input type="hidden" name="project" value="<?php echo $project;?>">
</form>
</body>
</html> 