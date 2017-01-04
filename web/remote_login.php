<?PHP
error_reporting(0);
session_start();
/*
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
*/

if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
  if(empty($_POST['username'])) {
	$errorMessage = "Please enter Unique ID";
  }else if(empty($_POST['reviewer'])) {
	$errorMessage = "Please enter Reviewer Name";
  } else {

	  $con = mysql_connect("localhost","root","password");
	
	  if (!$con)
	    {
	        die('Could not connect: '. mysql_error());
	    }
	
   	mysql_select_db("audit") or die(mysql_error());
    	$uname = mysql_real_escape_string(trim($_POST['username']));
	$uname = htmlspecialchars($uname);
	$reviewer = mysql_real_escape_string(trim($_POST['reviewer']));
	$str=sha1($uname);

	$query = "select username from login where uniqueid='$str'";

	$retval = mysql_query( $query, $con );
    	$count = mysql_num_rows($retval);
	
	if ($retval) {
			if ($count > 0) {
						
				session_start();
				$_SESSION['login'] = sha1($uname);
				$row = mysql_fetch_assoc($retval);
				$_SESSION['username'] = $row['username'];
				$_SESSION['reviewer'] = $reviewer;
				header ("Location: remote_openbug2.php?".$_SESSION['qString']);
			}
			else {
				
				$errorMessage = "Unique ID is not correct. Please Try again!";
				
			}	
		}
		else {
			$errorMessage = "Error Establishing Connection.";
		}
	}
  }
?>
<html>
<head>
<script src="js/jquery.js"></script>
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
var y=trim(document.forms["tstest"]["reviewer"].value);

if (x=="")
  {
  alert("Unique ID must be filled");
  document.forms["tstest"]["username"].focus();
  return false;
  }
if (y=="")
  {
  alert("Reviewer Name must be filled");
  document.forms["tstest"]["reviewer"].focus();
  return false;
  }
}

function focuson()
{
document.forms["tstest"]["username"].focus();
}

if ($.browser.msie) {
	this.resizeTo(430,435);
} else {
	this.resizeTo(430,400);
}

window.onresize = function() 
{
	if ($.browser.msie) {
	    window.resizeTo(430,435);
	} else {
	    window.resizeTo(430,400);
	}
}

</script>
<style type="text/css">
body, td
{
	margin:13px 0px 0px 0px;
	font-family:Arial;
	font-size:12px;
	overflow:hidden;
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
box-shadow:2px 2px 0 0 #014D06;
border-radius: 10px;
border: 1px outset #b37d00;
}
</style>

<title>Login To Audit Tracking Tool.</title>
</head>
<body onload="focuson()">


<div style='width:100%;height:32px;'>
	<div style='width:50%;float:left;height:32px;text-indent:10px;'><img src="images/G_Cube_logo1.png" style="margin-bottom:4px;"></div>
	<div style='width:46%;float:right;margin-right:10px;height:32px;text-align:left;'>&nbsp;<br/> Welcome to Bug Tracking Tool </div>
</div>
<div style="width:100%;height:5px;line-height:5px;text-indent:10px;background-color:rgb(247,148,28);color:#FFFFFF"></div>
<div style="width:100%;height:5px;line-height:5px;text-indent:10px;background-color:rgb(251,192,122);"></div>
<div style="width:100%;height:10px;"></div>

<div style="width:57%;height:200px;float:left;text-align:center;display:table-cell;">
        <br/><br/><br/><br/>
	<FORM NAME ="tstest" METHOD ="POST" ACTION ="remote_login.php" onsubmit="return validateForm()">
	<table align="center">
	  <tr>
	    <td><b>Unique ID:</b></td>
	    <td><INPUT TYPE = 'password' Name ='username' maxlength="20"></td>
	  </tr>
	  <tr>
	    <td><b>Reviewer:</b></td>
	    <td><input type="text" name="reviewer" id="reviewer" maxlength="100" value="<?=$reviewer?>"></td>
	  </tr>
	  <tr>
	    <td></td>
	    <td><INPUT TYPE = "Submit" class="button" Name = "Submit1"  VALUE = "Login"></td>
	  </tr>
	</table>
	</FORM>
	<p align="center"><b><?PHP echo $errorMessage;?></b></p>
</div>
<div style="width:42%;height:200px;float:right;text-align:left;">
	<img src="images/Bee001.png">
</div>

</body>
</html>