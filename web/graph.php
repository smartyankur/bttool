<?php
error_reporting(0);
include("phpgraphlib.php");

$con = mysql_connect("localhost","root","password");
$user=$_SESSION['login'];

if (!$con)
{
  die('Could not connect: ' . mysql_error());
}

mysql_select_db("audit") or die(mysql_error());

$query = "select qc,SUM(effort) from qcplan where status='open' group by qc ASC";
$retval = mysql_query( $query, $con );

$count = mysql_num_rows($retval);
if($count==0) {echo "No Data Available"; exit();}

$data = array();
while($row = mysql_fetch_assoc($retval)) 
    { 
     $data[$row['qc']] = $row['SUM(effort)'];
	}
$graph = new PHPGraphLib(800,800);
//$data = array("Alex"=>99, "Mary"=>98, "Joan"=>70, "Ed"=>90);
$graph->addData($data);
$graph->setTitle("LOAD");
$graph->setTextColor("blue");
$graph->createGraph();
?>