<?PHP
session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	
	echo $_SESSION['login'];
	//header ("Location: login3.php");
}

else {
     
	 echo $_SESSION['login'];	 
?>
     <form name="tstest" method=post>
	 <TABLE border=1>
     <TR>
	 <TD><a href="ncaging.php">NC Aging Projectwise</a></TD>
     </TR>
	 </TABLE>
	 </form>
<?php
}
?>

	