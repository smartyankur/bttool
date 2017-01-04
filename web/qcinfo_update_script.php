<?php 
/** @saurav To Update table qcuploadinfo **/
set_time_limit(0);
include("config.php");

$sql = "SELECT pindatabaseid, projectname FROM projectmaster";
$result = mysql_query($sql);
$count = mysql_num_rows($result);

if( $count > 0 ){
	while($result_array = mysql_fetch_array($result)){
   
		if($result_array['projectname'] == '') continue;
   
		echo "Updating Project ID for '".$result_array['projectname']."' \n"; 
		
		mysql_query("update `qcuploadinfo` set project_id = '".$result_array['pindatabaseid']."' where project = '".$result_array['projectname']."'");
	}
}

/* script end */


?>