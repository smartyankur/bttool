<meta http-equiv="refresh" content="5">
<?php

/*$url = "192.168.3.40/BTTool/web/create_project_service.php";
$json_data = json_encode(array('pin' => 'GB/1309/33967', 'project' => 'Test Project 3', 'client' => 'British Standards Institution'));
$ch = curl_init( $url );
# Setup request to send json via POST.
curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
# Return response instead of printing.
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
# Send request.
$result = curl_exec($ch);
echo '<pre>'; print_r($result); die;
curl_close($ch);*/

include('config.php');

$query = "select finding from actionitem where projectname= 'Pepsico';";
//echo $query;

$retval = mysql_query( $query, $con );
$count = mysql_num_rows($retval);
//echo "Count of elements:".$count;

if($count==0)
{
  die('Data Not Found');
}


while($row = mysql_fetch_array($retval))
  {
   echo "</br>";
   echo "</br>";
   echo "<TABLE border=1>";
   echo "<TR>";
   echo "<TD>".$row['finding']."</TD>";
   echo "</TR>";
   echo "</TABLE>";
  }
mysql_close($con);

?>