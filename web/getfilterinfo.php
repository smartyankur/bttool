<?php $pro_id = $_REQUEST['pro_id'];	  
	  include("config.php");
?>
<script src="js/jquery.js"></script>


	
	
<select name="filter_name" id="filter_name" style="" onChange="toggleFilter(this);">
			<option value="">Select Filter</option>
			<option value="filter_bcat">Bug Category</option>
			<option value="filter_severity">Severity</option>
			<option value="filter_bugstatus">Bug Status</option>
			<option value="filter_asignee">Assignee</option>
			<option value="filter_module">Module</option>
			<option value="filter_qc">QC</option>
			<option value="filter_all">All</option>
		</select>
	
		<span id="filter_values" style="display:inline-block;">
			
			<span id="filter_all" name="filter_all" style="display:none">
				<select name="all" id="all">
					<option value="All" selected>All</option>
				</select>
			</span>
			<span id="filter_bcat" name="filter_bcat" style="display:none" onChange="toggleFilter(this);">
				<select name="bcat1" id="bcat1">
					<option value="select" selected>All</option>
					<?php $query = "select id, category from tbl_category where parent_id = 0"; 
						  $res = mysql_query($query, $con);
					?>
					<?php 
						while($row = mysql_fetch_assoc($res)) 
						{
						?>
							<option value="<?php echo $row['id']?>"><?php echo $row['category'];?></option> 
						<?php			
						}
					?>
				</select>
			</span>
			<span id="filter_severity" name="filter_severity" style="display:none">
				<select name="severity1" id="severity1">
					<option value="select" selected>Select</option>
					<option value="High">High</option>
					<option value="Medium">Medium</option>
					<option value="Low">Low</option>
				</select>
			</span>
			<span id="filter_bugstatus" name="filter_bugstatus" style="display:none">
				<select name="bugstatus1" id="bugstatus1">
					<option value="">Select</option>
					<option value="hold">hold</option>
					<option value="open">open</option>
					<option value="closed">closed</option>
					<option value="ok as is">ok as is</option>
					<option value="reopened">reopened</option>
					<option value="fixed">fixed</option>
				</select>
			</span>
			<span id="filter_asignee" name="filter_asignee" style="display:none;">
				<select name="asignee1" id="asignee1" >
					<?php

					$sqldev="SELECT dev1, dev2, dev3, dev4, dev5, dev6, dev7, dev8 from projectmaster WHERE pindatabaseid = '".$pro_id."'";
					//echo $sql;
					$resultdev = mysql_query($sqldev);
					$count = mysql_num_rows($resultdev);
					$ary=array();
				
					if($count>0)
					{
						$rowdev = mysql_fetch_assoc($resultdev);
						echo "<option selected value=\"select\">Select</option>";
						foreach($rowdev as $developer){
							if(!empty($developer) && $developer != "NA") {
								echo "<option value='".$developer."'>".$developer."</option>";
							}
						}
					} else {
						echo "<option>No Names Present</option>";  
					}

					?>
				</select>
			</span>
			<span id="filter_module" name="filter_module" style="display:none;">
				<select name="module1" id="module1" >
					<?php
					$sqlmod="SELECT module from qcuploadinfo WHERE project_id = '".$pro_id."' group by module";
					//echo $sql;
					$resultmod = mysql_query($sqlmod);
					$count = mysql_num_rows($resultmod);
					$ary=array();
				
					if($count>0)
					{
						echo "<option selected value=\"select\">Select</option>";
						while( $rowmod = mysql_fetch_assoc($resultmod)) {
							
						
							if(!empty($rowmod['module']) && $rowmod['module'] != "NA") {
								echo "<option value='".$rowmod['module']."'>".$rowmod['module']."</option>";
							}
						}
					} else {
						echo "<option>No Names Present</option>";  
					}

					?>
				</select>
			</span>
			<span id="filter_qc" name="filter_qc" style="display:none;">
				<select name="qc1" id="qc1" >
					<?php

					$sqltest="SELECT tester1, tester2, tester3, tester4, tester5, tester6, tester7, tester8 from projectmaster WHERE pindatabaseid = '".$pro_id."'";
					$resulttest = mysql_query($sqltest);
					$count = mysql_num_rows($resulttest);
					$ary=array();
				
					if($count>0)
					{
						$rowtest = mysql_fetch_assoc($resulttest);
						echo "<option selected value=\"select\">Select</option>";
						foreach($rowtest as $tester){
							if(!empty($tester) && $tester != "NA") {
								echo "<option value='".$tester."'>".$tester."</option>";
							}
						}
					} else {
						echo "<option>No Names Present</option>";  
					}
					?>
				</select>
			</span>
			<span id="filter_bscat" style="display:none;">
				<select name="bscat1" id="bscat1">
					<option value="select" selected>All</option>
				</select>
			</span>
				
			<span id="filter_submit" name="filter_submit" style="display:none">
				<input type="button" name="submit" id="submit" value="Show Bug" onClick="showAll();return false;">
			</span>
		</span>
		
	


<?php  
  mysql_close($con);
?> 