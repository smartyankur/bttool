<?PHP
error_reporting(0);
if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
  include("config.php");
  
  $uname = mysql_real_escape_string(trim($_POST['username']));
  $uname = htmlspecialchars($uname);
  $str=sha1($uname);

	$query = "select username from login where uniqueid='$str'";
	//echo $query;
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if ($retval) {
			if ($count > 0) {
						
				session_start();
				$_SESSION['login'] = sha1($uname);
				//header ("Location: links.php");
				header ("Location: logticket.php");
			}
			else {
				
				$errorMessage = "Unique ID is not correct. Please Try again!";
				
			}	
		}
		else {
			$errorMessage = "Error Establishing Connection.";
		}
	}
?>
<html>
<head>
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


function validateForm(){
var x=trim(document.forms["tstest"]["username"].value);

if (x=="")
  {
  alert("Unique ID must be filled");
  document.forms["tstest"]["username"].focus();
  return false;
  }
}

function focuson(){
  document.forms["tstest"]["username"].focus();
}
</script>
<title>Login To Audit Tracking Tool.</title>
</head>
<body onload="focuson()">
  <form name="tstest" method="post" action="support.php" onsubmit="return validateForm()">
    <br>
    <br>
    <br>
    <br>
    <b>Unique ID:</b><input type='password' name='username' maxlength="20">
    <P align=left>
    <input type="submit" class="button" name="Submit1" value="Login">
    </p>
  </form>
  
  <p>
  <b><?php echo $errorMessage;?></b>
</body>
</html>