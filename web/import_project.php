<?php
error_reporting(E_ALL & E_NOTICE & E_DEPRECATED);
include("config.php");
class importProject {
    
	function processData($req) {
		$message = array();
		try {
			if(empty($req['pin'])) {
				return $message['msg'] = 'Pin id required';
			} else if(empty($req['project'])) {
				return $message['msg'] = 'Project Name required';
			} else if(empty($req['client'])) {
				return $message['msg'] = 'Client Name required';
			}
			$insertProject = "INSERT INTO projectmaster(`pin`, `projectname`, `clientspoc`) values('".$req['pin']."', '".$req['client']." ".$req['project']." ".$req['pin']."', '".$req['client']."')";
			
			if(mysql_query($insertProject)){
				return $message['msg'] = "project created successfully";
			} else {
				return $message['msg'] = "Project already exist with this pin ".$req['pin'];
			}
			
		} catch(Exception $e) {
			return $e->getMessage();
		}
		
	}
	
}
$obj = new importProject();
$key = array('client', 'project', 'pin');
$tmp = array();
$count = 0;
if (($handle = fopen("pins.csv", "r")) !== FALSE) {
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $num = count($data);
    for ($c=0; $c < $num; $c++) {
        $tmp[$key[$c]] = $data[$c];
		
    }
	if($count > 0) {
	 
		echo $obj->processData($tmp)."<br>";
	}
	$count++;
  }
  fclose($handle);
}

?>
	
	
