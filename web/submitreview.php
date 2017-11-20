<html>
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
	$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : '';
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && $id) {
		$id = $_POST["id"];
		$status = $_POST["status"];
		$comment = $_POST["comment"];
		$max_filesize = 1048576; //Maximum filesize in BYTES (currently 1MB).
		$upload_path = './support/';
		$filename = $_FILES['attachment']['name'];
		$message = $_REQUEST["message"];
		///////////////////////////////////////////////////////////////////////////////////
		if(filesize($_FILES["attachment"]['tmp_name']) > $max_filesize) {
			$message .= "The file '${filename.$x}' you attempted to upload is too large.<br>";
		} else if(!is_writable($upload_path)) {
			$message .= "You cannot upload to the specified directory. Please CHMOD it to 777.";
		}
		$fstr = empty($filename) ? '' : time()."_".$filename;
		///////////////////////////////////////////////////////////////////////////////////
		if(empty($message)){
			if(!empty($fstr)) {
				move_uploaded_file($_FILES["attachment"]['tmp_name'], $upload_path . $fstr);
				$query="update blobt set status='".$status."', comment='".$comment."', rev_attachment='".$fstr."' where id='$id'";
			} else {
				$query="update blobt set status='".$status."', comment='".$comment."' where id='$id'";
			}
			
		}
		if (mysql_query($query)) {
			$message="Record has been updated.";
			header ("Location: submitreview.php?message=".urlencode($message));
		} else {
			die(mysql_error());
		}	
	}

?>
<style>
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
 var status = trim(document.getElementById('status').value);
 var comment = trim(document.getElementById('comment').value);
 if(status=="select"){alert("Please select status"); return false;}; 
 if(comment==""){alert("Please enter description"); return false;}; 
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
<body background="bg.gif">
<form name="ttest" action="./submitreview.php" method="post" enctype="multipart/form-data">

<TABLE>

<TR>
	<TD>Status</TD>
	<TD>
		<select name="status" id="status" size="1">
			<option value="select" selected>Select</option>
			<option value="fixed">Fixed</option>
			<option value="ok as is">Ok As IS</option>
			<option value="hold">Hold</option>
			<option value="reopened">Reopen</option>
			<option value="closed">Close</option>
		</select>
	</TD>
</TR>
<TR>
	<TD>Comment</TD>
	<TD>
		<textarea name="comment" id="comment" rows="3" cols="20"></textarea>
	</TD>
</TR>
<TR>
	<TD>Attachment</TD>
	<TD>
		<input type="file" name="attachment" id="attachment" size="35" />
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