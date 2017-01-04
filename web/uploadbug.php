<body background="bg.gif">
<?php
   $con = mysql_connect("localhost","root","password");
   if (!$con)
   {
   die('Could not connect: ' . mysql_error());
   }
   mysql_select_db("audit", $con);

   // Configuration - Your Options
   $allowed_filetypes = array('.doc','.docx','.xls','.xlsx'); // These will be the types of file that will pass the validation.
   $max_filesize = 1048576; // Maximum filesize in BYTES (currently 1MB).
   $upload_path = './files/'; // The place the files will be uploaded to (currently a 'files' directory).
   
   $q=$_POST["project"]; //project
   $r=$_POST["phase"]; //phase
 
   $filename = $_FILES['userfile']['name']; // Get the name of the file (including file extension).
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
   $str=$q."_".$r.$ext;
   // Upload the file to your specified path.

   if(move_uploaded_file($_FILES['userfile']['tmp_name'],$upload_path . $str))
   {
    echo 'Your file upload was successful, view the file <a href="' . $upload_path . $str . '" title="Your File">here</a>'; // It worked.
    
	$query="INSERT INTO uploadinfo(project,phase,filepath) values('".$q."','".$r."','".$str."')";
    //echo $query;
	if (mysql_query($query))
       {
		  //echo "Record created with id :".$row['id']." and description :".$w;
	   }
    else
       {
        echo "Uploadinfo table couldn't be updated.";
	   }
   }	  
   else
         echo 'There was an error during the file upload.  Please try again.'; // It failed :(.
?>
<br>
You can either go back using browser back button to upload another sheet or you can logout.</br>
<input type="button" value="Log Out" onclick="location.href='logout.php';">
</body>