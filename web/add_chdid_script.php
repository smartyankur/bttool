<?php 
/** @saurav To Update table qcuploadinfo **/
set_time_limit(0);
include("config.php");
$functional = "select id, project_id, project_name from tbl_functional_review";
$result = mysql_query($functional);
$count = mysql_num_rows($result);
if( $count > 0 ){
	while($result_array = mysql_fetch_array($result)){
   
		echo "Updating Project ID for '".$result_array['project_name']."' \n"; 
		
		mysql_query("update `qcuploadinfo` set chd_id = '".$result_array['id']."' where project_id = '".$result_array['project_id']."'");
	}
}

/* script end */


?>