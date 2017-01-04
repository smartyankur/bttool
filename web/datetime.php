<?php
$date = date('m/d/Y h:i:s a', time());
echo "Current Time:".$date;
echo "<br>";
$timezone = date_default_timezone_get();
echo "The current server timezone is: " . $timezone;
?>