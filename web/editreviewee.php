<html>
<head>
<?php	
	error_reporting(0);
	session_start();
	
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
		header ("Location:index.php");
    }
	$user = $_SESSION['login'];
	include("config.php");

    $query = "select username from login where uniqueid='$user'";
    
	$retval = mysql_query($query, $con);
	
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found Please contact SEPG');
		}

    
    while($row = mysql_fetch_assoc($retval)) 
    { 
       echo "<br>";
       echo "<br>"; 
       echo "<h4>"."Hi ".$row['username']." ! Welcome to Change Reviewee Interface"."</h4>";
	   $username=$row['username'];
    } 	
$id=$_REQUEST["id"];
$message=$_REQUEST["message"];
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
 $id=$_REQUEST["id"];
 $reviewee=$_POST["reviewee"];
 $query="update blobt set reviewee='$reviewee' where id='$id'";

 if (mysql_query($query))
	{
        $message="Record has been updated.";
		header ("Location: editreviewee.php?message=".urlencode($message));
    }
  else
	{
      die(mysql_error());
    }	
}

?>
<style>
div.ex
{
height:250px;
width:400px;
background-color:white
}
textarea.hide
{
visibility:none;
display:none;
}
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
<script>

function test()
{
 var reviewee = trim(document.getElementById('reviewee').value);
 if(reviewee=="Select"){alert("Please select reviewee"); return false;}; 
 document.forms["ttest"].submit();
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

<body>
<form name="ttest" action="./editreviewee.php" method="post" enctype="multipart/form-data">
<TABLE>

<TR>
<TD>Reviewee</TD>
<TD>
    <?php
	$query = "select DISTINCT username from login where role IN('ID, Media', 'ID, Tech', 'Media, Tech', 'Media, ID', 'Tech, ID', 'Tech, Media', 'ID', 'Media', 'Tech', 'ID FM', 'Tech FM', 'Media FM') AND dept='Content' order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}

    echo "<select name=\"reviewee\" id=\"reviewee\">"; 
    echo "<option size =30 selected value=\"Select\">Select</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
     //echo "<option>$row[username]</option>";
	 if(strlen($row[username])<>0)
		{
		 ?>
         <option<?php if($reviewee==$row[username])echo " selected";?>><?php echo $row[username];?></option> 
         <?php 
		}
    } 
    } 
    else 
	{
     echo "<option>No Names Present</option>";  
    } 
    ?>
    </TD>
</TR>
</TABLE>
</br>
<input type="button" class="button" value="Submit" onclick="test();">
<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
<br>
<br>
<div id="txtHint"><?php if($message<>""){echo $message;}?></div>
</form>
</body>
</html> 