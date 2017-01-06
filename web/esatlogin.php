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
	include('config.php');
    $uname = mysql_real_escape_string(trim($_POST['username']));
	$uname = htmlspecialchars($uname);
	//$str=sha1($uname);

	$query = "select * from surveylogin where passwd='$uname'";
	//echo $query;
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if ($retval) {
			if ($count > 0) {
						
				session_start();
				$_SESSION['login'] = $uname;
				//header ("Location: links.php");
				header ("Location: esat.php");
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
background:url('esat.jpg') no-repeat;
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
<title>Login To ESAT Tool.</title>
</head>
<body background="bg.gif" onload="focuson()">

<FORM NAME ="tstest" METHOD ="POST" ACTION ="esatlogin.php" onsubmit="return validateForm()">
<br>
<br>
<br>
<br>
<b>Unique ID:</b><INPUT TYPE = 'password' Name ='username' maxlength="20">

<P align = left>
<INPUT TYPE = "Submit" Name = "Submit1"  VALUE = "Login">
</P>
</FORM>

<P>
<b><?PHP echo $errorMessage;?></b>
</body>
</html>