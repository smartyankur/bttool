<html>
<head>
</head>
<body background="bg.gif">
<?php
$q=$_REQUEST["id"];
echo "ID=".$q;
?>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" action="utsubmit.php" onsubmit="return validateForm()" method="post">
<TABLE>
<TR>
<TD>
<input type="Text" id="DDate" value="" maxlength="20" size="9" name="DDate" readonly="readonly">
<a href="javascript:NewCal('DDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a><input type="text" name="hour" size="2"></TD>
</TR>
</table>
<input type="submit"/>
<input type="hidden" value="<?php echo $q;?>" name="ID">
</form>
</body>
</html> 