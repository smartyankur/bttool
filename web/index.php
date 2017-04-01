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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>BT Tool</title>
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <div class="wrapper">
        <div class="login_box">
            <div class="logo">
                <img src="images/logo.png" alt="" />               
            </div>
			<div class="login_area">
				<form name="tstest" method="POST" action="index.php" onsubmit="return validateForm()">
					Unique ID:
					<input type="password" name="username">
					<br>
					<button type="submit" class="subtn">Login</button>
				</form>
				
				<b><?PHP echo $errorMessage;?></b>

            </div>
			
            <div class="char_img">
            	<img src="images/char_img.png" alt="" />
            </div>
        </div>
    </div>
</body>

</html>