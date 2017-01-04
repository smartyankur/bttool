<html>
<head>
<title>Count Hold Issues</title>
<?php	
/*
error_reporting(0);
session_start();
	
if(!(isset($_SESSION['login']) && $_SESSION['login'] != '')){
  header ("Location:index.php");
}
$user=$_SESSION['login'];    
*/  
include("config.php");  
/*
$query  = "select username from login where uniqueid='$user'";
$retval = mysql_query($query, $con);
$count  = mysql_num_rows($retval);
	
if($count==0){
  die('Data Not Found Please contact SEPG');
}

while($row = mysql_fetch_assoc($retval)){ 
  echo "<br>";
  echo "<br>"; 
  echo "<h4>"."Hi ".$row['username']." ! Welcome to Count or Hold Issues"."</h4>";
  $username=$row['username'];
}
*/
echo "<br>";
  echo "<br>";
echo "<br>";
  echo "<br>";
?>
<style>
div.ex{
  height:250px;
  width:400px;
  background-color:white
}

textarea.hide{
  visibility:none;
  display:none;
}

body{
  background:url('qcr.jpg') no-repeat;
}

.button{
  background-color: #F7941C;
  border-bottom:#F7941C;
  border-left: #F7941C;
  border-right:#F7941C;
  border-top: #F7941C;
  color: black;
  font-family: Tahoma
  box-shadow:2px 2px 0 0 #014D06,;
  border-radius: 10px;
  border: 1px outset #b37d00 ;
}

.table_text{
	font-family: Calibri;
	font-size: 12px;
	font-style: normal;
	line-height: normal;
	font-weight: normal;
	font-variant: normal;
	color: #000000;
	text-indent: 10px;
	vertical-align: middle;
}
</style>
</head>

<body background="bg.gif">
<table width="99%" border="0" cellspacing="0" cellpadding="0" bordercolor="orangered">
  <tr class="table_text">
    <td valign="top" align="right">
      <a href="esatext.php">Export result</a>
    </td>                      
  </tr>
</table>  

<table width="99%" border="0" cellspacing="0" cellpadding="0" bordercolor="orangered" class="table_text">
  <tr class="table_text">
    <td valign="top" align="left"><input type="button" class="button" value="Log Out" onclick="location.href='logout.php';"></td>                      
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>                  
  </tr>        
</table>
<form name="tstest" action="./funrev.php" method="post" enctype="multipart/form-data">  
<table width="80%" border="1" cellspacing="0" cellpadding="0" bordercolor="orangered" class="table_text">
  <tr class="table_text">
    <th valign="top">Emp ID</th>
    <th valign="top">User</th>
    <th valign="top">Q11</th>    
    <th valign="top">Q12</th>                  
    <th valign="top">Q13</th>
    <th valign="top">Q14</th>    
    <th valign="top">Q15</th>                  
    <th valign="top">Q21</th>
    <th valign="top">Q21a</th>
    <th valign="top">Q22</th>
    <th valign="top">Q23</th>
    <th valign="top">Q24</th>
    <th valign="top">Q24a</th>
    <th valign="top">Q25</th>
    <th valign="top">Q26</th>
    <th valign="top">Q31</th>
    <th valign="top">Q31a</th>
    <th valign="top">Q32</th>
    <th valign="top">Q32a</th>
    <th valign="top">Q33</th>
    <th valign="top">Q34</th>
    <th valign="top">Q35</th>
    <th valign="top">Q36</th>
    <th valign="top">Q37</th>
    <th valign="top">Q41</th>
    <th valign="top">Q42</th>
    <th valign="top">Q43</th>
    <th valign="top">Q44</th>
    <th valign="top">Q45</th>
    <th valign="top">Q46</th>
    <th valign="top">Q47</th>
    <th valign="top">Q51</th>
    <th valign="top">Q52</th>
    <th valign="top">Q53</th>
    <th valign="top">Q54</th>
    <th valign="top">Q55</th>
    <th valign="top">Q56</th>
    <th valign="top">Q57</th>
    <th valign="top">Q58</th>
    <th valign="top">Q58a</th>
    <th valign="top">Q59</th>
    <th valign="top">Q59a</th>
    <th valign="top">Q510</th>
    <th valign="top">Q511</th>
    <th valign="top">Q511a</th>
    <th valign="top">Q512</th>
    <th valign="top">Q61</th>
    <th valign="top">Q61a</th>
    <th valign="top">Q62</th>
    <th valign="top">Q62a</th>
    <th valign="top">Q63</th>
    <th valign="top">Q64</th>
    <th valign="top">Q65</th>
    <th valign="top">Q66</th>
    <th valign="top">Q67</th>  
    
</tr>
<?php
$i=1;    
$selectCounts = "SELECT * FROM esat";
$queryCounts = mysql_query($selectCounts);
while($fetchCounts = mysql_fetch_array($queryCounts)){    
  echo "<tr>";
  	//echo "<td align=\"center\" valign=\"top\">".$i."</td>";
  	//echo "<td valign=\"top\"><div style=\"height:53;overflow:auto\">".$fetchCounts['user']."</div></td>";      
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['empid']."</div></td>"; 	   
	echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['user']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q11']."</div></td>";     
  	echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q12']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q13']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q14']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q15']."</div></td>";     
  	echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q21']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q21a']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q22']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q23']."</div></td>";     
  	echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q24']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q24a']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q25']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q26']."</div></td>";     
  	echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q31']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q31a']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q32']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q32a']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q33']."</div></td>";     
  	echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q34']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q35']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q36']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q37']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q41']."</div></td>";     
  	echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q42']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q43']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q44']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q45']."</div></td>";      
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q46']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q47']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q51']."</div></td>";     
  	echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q52']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q53']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q54']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q55']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q56']."</div></td>";     
  	echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q57']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q58']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q58a']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q59']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q59a']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q510']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q511']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q511a']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q512']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q61']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q61a']."</div></td>"; 
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q62']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q62a']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q63']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q64']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q65']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q66']."</div></td>";
      echo "<td valign=\"top\"><div style=\"width:100;height:53;overflow:auto\">".$fetchCounts['Q67']."</div></td>";
echo "</tr>";
  $i++;      
}
mysql_close($con);
?> 
</table>
<table width="99%" border="0" cellspacing="0" cellpadding="0" bordercolor="orangered" class="table_text">
  <tr>
    <td valign="top">&nbsp;</td>                  
  </tr>
  <tr class="table_text">
    <td valign="top" align="left"><input type="button" class="button" value="Log Out" onclick="location.href='logout.php';"></td>                      
  </tr>        
</table>
</form>
<script type="text/javascript">
function newPopup(url) {
	popupWindow = window.open(
		url,'popUpWindow','height=500,width=820,left=550,top=230,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no')
}
</script>
</body>
</html>