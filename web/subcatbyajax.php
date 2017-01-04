<?php
$catname = $_GET['catName'];

include("config.php");

$query  = "select subcat from catmaster where cat='$catname'";
$retval = mysql_query($query, $con);
 
echo "<option value='select' selected>Select bug sub category</option>";
if(mysql_num_rows($retval)){ 
  while($row=mysql_fetch_assoc($retval)){
    if(strlen($row['subcat'])<>0){		 
      echo "<option>" . $row['subcat'] . "</option>"; 
    }
  } 
}else {
  echo "<option>No records</option>";  
}
?> 