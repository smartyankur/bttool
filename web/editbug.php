<html>
<head>
</head>
<body background="bg.gif">
<?php	
    error_reporting(0);
	include('config.php');
    $user=$_SESSION['login'];
	$allowed_filetypes = array('.doc','.docx','.xls','.xlsx','.jpeg','.jpg','.JPG','.JPEG','.png','.PNG','.bmp','.BMP','.gif','.GIF'); // These will be the types of file that will pass the validation.
   $max_filesize = 1048576; // Maximum filesize in BYTES (currently 1MB).
   $upload_path = './qcfiles/'; // The place the files will be uploaded to (currently a 'files' directory).
   $a=mysql_real_escape_string($_POST["project"]);
   $d=mysql_real_escape_string($_POST["id"]);
   //$f=mysql_real_escape_string($_POST["phase"]);//topic
   $g=mysql_real_escape_string($_POST["module"]);//screen
   $h=mysql_real_escape_string($_POST["topic"]);//qc
   //$i= mysql_real_escape_string($_POST["SDate"]);//SData
   //$w=strtotime($i);
   //$x = date( 'Y-m-d', $w );
   $j=mysql_real_escape_string($_POST["browser"]);//module
   //$k=mysql_real_escape_string($_POST["coursestatus"]);//topic
   $funct=mysql_real_escape_string($_POST["function"]);//pagenumber
   $l=mysql_real_escape_string($_POST["bcat"]);//pagenumber
   $l1=mysql_real_escape_string($_POST["bscat"]);//pagenumber
   $m=mysql_real_escape_string($_POST["bdr"]);//bug description
   $n=mysql_real_escape_string($_POST["asignee"]);//bug description
   $o=mysql_real_escape_string($_POST["qc"]);
   $p=mysql_real_escape_string($_POST["screen"]);
   $q=mysql_real_escape_string($_POST["severity"]);
   //$loggeduser=mysql_real_escape_string($_POST["user"]);
   $filename = $_FILES['userfile']['name']; // Get the name of the file (including file extension).

if($filename<>"")
{
   $ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); // Get the extension from the filename.
   // Check if the filetype is allowed, if not DIE and inform the user.
   if(!in_array($ext,$allowed_filetypes))
      die('The file you attempted to upload is not allowed.');

   //we can also try this : if($_FILES['userfile']['type'] != "image/gif") { echo "Sorry, we only allow uploading GIF images";   exit;}
 
   // Now check the filesize, if it is too large then DIE and inform the user.
   if(filesize($_FILES['userfile']['tmp_name']) > $max_filesize)
      die('The file you attempted to upload is too large.');
 
   // Check if we can upload to the specified path, if not DIE and inform the user.
   if(!is_writable($upload_path))
   die('You cannot upload to the specified directory, please CHMOD it to 777.');

	$date = date('m/d/Y h:i:s a', time());
	$mydate = date('Y-m-d h:i:s', time());
	//echo "Current Time:".$date;
	$values = explode(" ",$date);
	$dates = explode("/", $values[0]);
	$times = explode(":", $values[1]);
	$timex=$dates[1]."_".$dates[0]."_".$dates[2]."_"."T".$times[0]."_".$times[1]."_".$times[2];
	$str= time().$ext;
   
   if(move_uploaded_file($_FILES['userfile']['tmp_name'],$upload_path . $str))
   {
    $msg='Your file '.$filename.' upload was successful for project :'.$a.' and phase :'.$f.',You can view the file <a href="' . $upload_path . $str . '" title="Your File">here</a>'; // It worked.
    echo "</br>";
	$query="update qcuploadinfo set module='$g',topic='$h',browser='$j',function='$funct',bcat='$l',bscat='$l1',bdr='$m',asignee='$n',qc='$o',screen='$p',filepath='$str',filename='$filename',uploaddate='$mydate',severity='$q' where id='$d'";
	//echo $query;
    if (mysql_query($query))
       {
        echo "Row Updated for ID =".$d;
	   }
    }	  
   
   else
         echo 'There was an error during the file upload.  Please try again.'; // It failed :(.
         exit();

} //this is end of if which is checking whether filename is blank or not. 

else //filename is blank means the user has not uploaded any file.
{
//$date = date('m/d/Y h:i:s a', time());
	$mydate = date('Y-m-d h:i:s', time());     
    $query="update qcuploadinfo set module='$g',topic='$h',browser='$j',function='$funct',bcat='$l',bscat='$l1',bdr='$m',asignee='$n',qc='$o',screen='$p',whenchangedstatus='$mydate',severity='$q' where id='$d'";
	//echo $query;
    if (mysql_query($query))
       {
        echo "Row Updated for ID =".$d;
	   }
}

?>
</body>