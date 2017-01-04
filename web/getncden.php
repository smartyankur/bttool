<?php
$q=$_GET["q"];
$pro_id=$_GET["pro_id"];
$r=$_GET["r"];
include("config.php");

$sql="select count(*) from actionitem where project_id = '$pro_id';";
$esql="select estimatedeffort from projectmaster where pindatabaseid = '$pro_id';";

$eresult = mysql_query($esql);
$ecount = mysql_num_rows($eresult);

if($ecount==0)
{
  die('No estimated effort was found');
}

$erow = mysql_fetch_array($eresult);
$effort = $erow['estimatedeffort'];
$result = mysql_query($sql);

echo "---------------------------------------------------------------------------------------------------------------------";

while($row = mysql_fetch_array($result))
  {
  echo "<br>";
  if ($row['count(*)']<>0)
	  { 
		echo "No of NCs :".$row['count(*)']."</br>";
		echo "Effort :".$r."</br>";
		$den=$row['count(*)']/$r."</br>";
		echo "Density->NCs per PH :".$den;
      }
   else
	  {
	   
        $query = "select count(*) from actionitem where project_id = '$pro_id';";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);

        $cquery = "select count(*) from actionitem where status='closed' and  project_id = '$pro_id';";
        $cresult = mysql_query($cquery);
        $crow = mysql_fetch_array($cresult);

        
		if ($row['count(*)']<>0)
		  {
			if ($row['count(*)']==$crow['count(*)'])
			  {
			   echo "All Action Items Have Been Closed"."</br>";
              }

             else
			  {

               echo "Please Contact SEPG Something Wrong With Your Data"."</br>";

			  }
          } 
         else
          { 
            echo "This Project Has Not Been Audited"."</br>";
		  }
	  }
  echo "--------------------------------------------------------------------------------------------------------------------";
  }
mysql_close($con);
?> 