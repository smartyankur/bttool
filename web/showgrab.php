<?php
/*
 * @author Saurav Gupta
 */
error_reporting(0);
require_once("config.php");

$pro_id = $_GET['id'];

$sql1 = "SELECT grab FROM blobt WHERE id = ".$pro_id;
try {
	$stmt = mysql_query($sql1, $con);
	$result = mysql_num_rows($stmt);
} catch (Exception $ex) {
	echo $ex->getMessage();
}

$v = mysql_fetch_assoc($stmt);

echo "<div>".$v['grab']."</div>";



?>