<html>
<head>
<script type="text/javascript">
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
function validateForm()
{
var x=trim(document.forms["tstest"]["user"].value);

if (x=="")
  {
  alert("User ID must be filled");
  document.forms["tstest"]["user"].focus();
  return false;
  }
}
</script>
</head>
<body background="bg.gif">
<h2>LogIn To Audit Tracking Tool</h2>
<form name="tstest" action="index.php" onsubmit="return validateForm()" method="post">
<TABLE>
<TR>
<TD><b>Unique ID</b></TD>
<TD><input type="password" id="UID" maxlength="20" size="20" name="user"></TD>
</TR>
</TABLE>
<br>
<br>
<input type="submit"/>
</form>
</body>
</html> 