<html>
<head>
<link href="css/mystyle.css" rel="stylesheet" type="text/css">
</head>
<body ><!-- background="lb.jpeg" -->
<script type="text/javascript">

function verify()
{
 var alphanumericExp = /^[0-9a-zA-Z._, /s]*$/;
 var bug = trim(document.getElementById('bug').value);
 var module = trim(document.getElementById('module').value);
 var topic = trim(document.getElementById('topic').value);
 var page = trim(document.getElementById('pagenumber').value);

 if(module=="")
  {
  alert("Module should be identified");
  return false;
  }
 
 if(topic=="")
  {
  alert("Topic should be identified");
  return false;
  }
  
  if(page=="")
  {
  alert("Page should be identified");
  return false;
  }

  if(!module.match(alphanumericExp))
  {
  alert("Module details Should be only Alpha-Numeric");
  return false;
  }

  if(!topic.match(alphanumericExp))
  {
  alert("Topic details Should be only Alpha-Numeric");
  return false;
  }

  if(!page.match(alphanumericExp))
  {
  alert("Page Number Should be only Alpha-Numeric");
  return false;
  }

 if(bug=="")
  {
  	alert("Bug description should be given");
  	return false;
  }

 if(!bug.match(alphanumericExp))
  {
  	alert("Please don't use special characters in description");
  	return false;
  }
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
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" action="./edituat.php" onsubmit="return verify()" method="post" enctype="multipart/form-data">

<?php
error_reporting(0);
include 'config.php';
$id=$_REQUEST['id'];


if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
	   $u=mysql_real_escape_string($_POST["module"]);//module
	   $v=mysql_real_escape_string($_POST["topic"]);//topic
	   $w=mysql_real_escape_string($_POST["pagenumber"]);//pagenumber
         $bdr=mysql_real_escape_string($_POST["bdr"]);
         $id=$_POST["id"];
         
            
         $query="update uploadinfo set description='$bdr', module='".$u."', topic='".$v."', page='".$w."' where id='$id'";
         if (mysql_query($query)) 
         { 
          $message="The details have been updated.";
		echo "<script>this.opener.showAll('display');</script>";
         }
         else
         {
          //$message="Module, Topic, Page & Description couldn't be updated"; 
            $message = "The details couldn't be updated.";
         }  
	}

$equery="select * from uploadinfo where id='$id'";
//echo $equery;
$eresult = mysql_query( $equery, $con );
$count = mysql_num_rows($eresult);
if($count==0)
	{
	die('Data Not Found Please contact SEPG');
	}

 
    while($row = mysql_fetch_assoc($eresult)) 
    { 
     //echo "<h4>"."Hi ".$row['username']." ! Welcome To BUG Sheet Upload Tool"."</h4>";
    	//$bcat=$row['bcat'];
	$bug=$row['description'];
	$module=$row['module'];
	$topic=$row['topic'];
	$screen=$row['page'];

	//$username=$row['username'];
    } 
//echo "Bug ID  ".$id." -- Provide Description In the Text Area";
?>
<TABLE>
          <tr>
            <td valign="middle" class="table_text" align="right">Module-Topic-Page</td>
            <td height="30" colspan="2" valign="middle"><input type=text maxlength=40 size=12 name="module" id="module" value="<?php echo $module;?>">-<input type=text maxlength=40 size=12 name="topic" id="topic" value="<?php echo $topic;?>">-<input type=text maxlength=40 size=12 name="pagenumber" id="pagenumber" value="<?php echo $screen;?>"></td>
          </tr>
<TR>
<TD class="table_text" align="right">Bug Description</TD>
<TD><textarea name="bdr" rows="4" cols="34" id="bdr"><?php echo $bug;?></textarea></TD>
</TR>

</TABLE>
<input type="hidden" name="id" value="<?php echo $id;?>">
<input type="submit" value="Submit">
<br>
<br>
<div id="ResHint"><b><?php echo $message;?></b></div>
</form>
</body>
</html> 