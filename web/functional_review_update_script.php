<?php 
/** @saurav To Update table functional review table **/
set_time_limit(0);
include("config.php");

$sql = "SELECT DISTINCT projectname, pindatabaseid FROM projectmaster";
$result = mysql_query($sql);
$count = mysql_num_rows($result);

if( $count > 0 ){
	while($result_array = mysql_fetch_array($result)){
   
		if($result_array['projectname'] == '') continue;
   
		echo "Updating Project ID for '".$result_array['projectname']."' \n"; 
		
		mysql_query("update `tbl_functional_review` set project_id = '".$result_array['pindatabaseid']."' where project_name = '".$result_array['projectname']."'");
	}
}

/* script end */


?>