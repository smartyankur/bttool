<?PHP
error_reporting(0);
if(isset($_SERVER['HTTP_USER_AGENT']))
{
  $agent = $_SERVER['HTTP_USER_AGENT'];
}

if(strlen(strstr($agent,"Firefox")) > 0 )
{ 

  //$browser = 'firefox';
}

else
{
  echo "Please use Firefox";
  exit();

}

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
				header ("Location: content.php");
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
var x=trim(document.forms["tstest"]["username"].value);

if (x=="")
  {
  alert("Unique ID must be filled");
  document.forms["tstest"]["username"].focus();
  return false;
  }
}

function focuson()
{
document.forms["tstest"]["username"].focus();
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

<title>Login To Audit Tracking Tool.</title>
</head>
<body onload="focuson()">

<FORM NAME ="tstest" METHOD ="POST" ACTION ="index.php" onsubmit="return validateForm()">
<br>
<br>
<br>
<br>
<b>Unique ID:</b><INPUT TYPE = 'password' Name ='username' maxlength="20">

<P align = left>
<INPUT TYPE = "Submit" class="button" Name = "Submit1"  VALUE = "Login">
</P>
</FORM>

<P>
<b><?PHP echo $errorMessage;?></b>
</body>
</html>