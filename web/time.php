<html>
<head>
</head>
<body>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" method="post" onsubmit="return verify()" action="testrequest.php">
<?php

$ind=1;

while($ind<40000)
{
 echo "</br>";
 echo $ind."email@mmail"."."."com";
 $ind=$ind+1; 
}
?>
</form>
</body>
</html> 