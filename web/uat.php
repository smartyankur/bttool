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
  $con = mysql_connect("localhost","root","password");

  if (!$con)
    {
        die('Could not connect: '. mysql_error());
    }

   	mysql_select_db("audit") or die(mysql_error());
    $uname = mysql_real_escape_string(trim($_POST['username']));
	$uname = htmlspecialchars($uname);
	//$str=sha1($uname);

	$query = "select * from login where pwd='$uname'";
	//echo $query;
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if ($retval) {
			if ($count > 0) {
						
				session_start();
				$_SESSION['login'] = $uname;
				//header ("Location: links.php");
				header ("Location: uploadsheet.php");
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
<title>G-Cube | Bug Tracking Tool</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="css/mystyle.css" rel="stylesheet" type="text/css">
<script type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->

function greeting()
{
 //alert(123);
 var uid=trim(document.getElementById('username').value);
 //alert(uid);
 if(uid=="") {alert ("Please provide unique-id"); return false;}
 document.tstest.submit();
}

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
</script>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('images/over_stage_button.jpg')">
<!-- Save for Web Slices (sample4.psd) -->
<table id="Table_01" width="1000" height="583" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<img src="images/login_page_01.jpg" width="235" height="80" alt=""></td>
		<td colspan="3">
			<img src="images/login_page_02.jpg" width="765" height="80" alt=""></td>
	</tr>
	<tr>
		<td width="1000" height="27" colspan="4" background="images/login_page_03.jpg" class="s11">Welcome to the Bug Tracking Tool!</td>
	</tr>
	<tr>
		<td colspan="4">
			<img src="images/login_page_04.jpg" width="1000" height="83" alt=""></td>
	</tr>
	<tr>
		<td colspan="4">
			<img src="images/login_page_05.jpg" width="1000" height="82" alt=""></td>
	</tr>
	<tr>
		<td colspan="4">
			<img src="images/login_page_06.jpg" width="1000" height="68" alt=""></td>
	</tr>
	<tr>
		<td colspan="2" rowspan="2">
			<img src="images/login_page_07.jpg" width="328" height="242" alt=""></td>
		<td width="377" height="190" background="images/login_page_08.jpg"><table width="295" border="0" align="center">
          <tr>
            <td height="35" colspan="2" class="t1">Please enter your login details/credentials.</td>
          </tr>
          <tr>
            <td width="85" height="30" valign="top" class="t1">Unique ID</td>
            <td width="200" align="center" valign="middle"><form name="tstest" method="post" action="uat.php" style="vertical-align:middle">
              <input type="password" size="30" name ='username' maxlength="20" id='username'>
                        </form>              </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('buttons','','images/over_stage_button.jpg',1)" onclick="greeting()"><img src="images/normal_stage_button.jpg" alt="Click to Submit" name="buttons" width="82" height="24" border="0"></a></td>
          </tr>
        </table></td>
		<td rowspan="2">
			<img src="images/login_page_09.jpg" width="295" height="242" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/login_page_10.jpg" width="377" height="52" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/spacer.gif" width="235" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="93" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="377" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="295" height="1" alt=""></td>
	</tr>
</table>
<!-- End Save for Web Slices -->
<table>
<td width="300" height="30" valign="top" class="t1"><?PHP echo $errorMessage;?></td>
</table>
</body>
</html>