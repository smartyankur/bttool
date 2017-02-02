<?php
error_reporting(~E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include("config.php");
class createProject {
    
	function processData($req) {
		$message = array();
		try {
			if(empty($req->pin)) {
				return $message['msg'] = 'Pin id required';
			} else if(empty($req->project)) {
				return $message['msg'] = 'Project Name required';
			} else if(empty($req->client)) {
				return $message['msg'] = 'Client Name required';
			}
			$insertProject = "INSERT INTO projectmaster(`pin`, `projectname`, `clientspoc`) values('".$req->pin."', '".$req->project."', '".$req->client."')";
			
			if(mysql_query($insertProject)){
				return $message['msg'] = "project created successfully";
			} else {
				return $message['msg'] = "Project already exist with this pin ".$req->pin;
			}
			
		} catch(Exception $e) {
			return $e->getMessage();
		}
		
	}
	
}

$request_data = json_decode(file_get_contents("php://input"));
$obj = new createProject();
echo $obj->processData($request_data);

?>
	
	
