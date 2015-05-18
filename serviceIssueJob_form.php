<?php
	//include the medoo framework
	require_once('medoo.min.php');

	// get the selected item from the database.
	$job_no = $_REQUEST['job_no']; 
	
	//medoo framework
	$database = new medoo();
	
	
	//access item in the database
	$data = $database->select('qry_forms_jobs_si_jobs','*',[
		"JOB_NO"=>$job_no
	]);
	
 	$privilege = "";
	
	session_start();
	//check the privilege of user
	if($_SESSION['privilege'] == "user")
	{
		$privilege = "readonly";
	}

	$content = "
	    <span style='color:rgb(140,27,27)'><p align='center'> Service Issue Job Form</p></span>
	    <form style=\"padding:3px; margin:3px\" id='serviceIssueJob_form' action='serviceIssueJob_form_dataupdate.php' >
	    	<div>
			<ul class=\"tabs\" data-persist=\"true\">
				<li><a id='li1' onclick='tab_select(\"view1\", \"li1\")' class='tab_index'>page1</a></li>
				<li><a id='li2' onclick='tab_select(\"view2\", \"li2\")' class='tab_index'>page2</a></li>
				<li><a id='li3' onclick='tab_select(\"view3\", \"li3\")' class='tab_index'>page3</a></li>
			</ul>
			<div class=\"tab_contents\">
	    	 		<div id=\"view1\" class='tab'>
					<div>
						<label>JOB_ID:</label>
						<input type='text' value='".checkEmpty($data[0]["JOB_NO"])."' name='job_no' class='text' readonly>
					</div>
	    				<div>
						<label>CUST_NO:</label>
						<input type='text' value='".checkEmpty($data[0]["CUST_NO"])."' name='cust_no' class='text' readonly>
					</div>
	   	     			
					<div>
						<label>Model:</label>
						<input type='text' value='".checkEmpty($data[0]["MODEL"])."' name='model' class='text' readonly>
					</div>
					<div>
						<label>SerialNo:</label>
						<input type='text' value='".checkEmpty($data[0]["SERIALNO"])."' name='serialno' class='text' readonly>
						
					</div>
					<div>
						<label>Warehouse:</label>
						<input type='text' value='".checkEmpty($data[0]["WAREHOUSE"])."' name='warehouse' class='text' readonly>
					</div>
					<div>
						<label>INV_NO:</label>
						<input type='text' value='".checkEmpty($data[0]["INV_NO"])."' name='inv_no' class='text' readonly>
					</div>
					<div>
						<label>ORD_DATE:</label>
						<input type='text' value='".checkEmpty($data[0]["ORD_DATE"])."' name='ord_date 'class='text' readonly>
					</div>
				</div>
				<div id=\"view2\" class='tab'>
	   	     			<div>
						<label>EquipmentType:</label>
						<input type='text' value='".checkEmpty($data[0]["EQUIPMENTTYPE"])."' ".$privilege." name='equipmenttype' class='text'>	
					</div>
					<div>
						<label>Category:</label>
						<input type='text' value='".checkEmpty($data[0]["CATEGORY"])."'  name='category' ".$privilege." class='text'>
					</div>
					<div>
						<label>Statues:</label>
						<input type='text' value='".checkEmpty($data[0]["STATUS"])."'   name='statues' ".$privilege." class='text'>
					</div>
					<div>
						<label>Defectrating:</label>
						<input type='text' value='".checkEmpty($data[0]["DEFECTRATING"])."' name='defectrating' ".$privilege." class='text'>
					</div>
					<div>
						<label>CF1:</label>
						<input type='text' value='".checkEmpty($data[0]["CF1"])."' name='cf1' ".$privilege." class='text'>
					</div>
					<div>
						<label>CF2:</label>
						<input type='text' value='".checkEmpty($data[0]["CF2"])."' name='cf2' ".$privilege." class='text'>
					</div>
					<div>
						<label>CF3:</label>
						<input type='text' value='".checkEmpty($data[0]["CF3"])."' name='cf3' ".$privilege." class='text'>
					</div>
					<div>
						<label>SI1:</label>
						<input type='text' value='".checkEmpty($data[0]["SI1"])."' name='si1' ".$privilege." class='text'>
					</div>
					<div>
						<label>SI2:</label>
						<input type='text' value='".checkEmpty($data[0]["SI2"])."' name='si2' ".$privilege." class='text'>
					</div>
					<div>
						<label>ServiceHistoryNotes:</label>
						<textarea name='servicehistorynotes' ".$privilege." class='text'> ".checkEmpty($data[0]["SERVICEHISTORYNOTES"])." </textarea>
					</div>
				</div>
				<div id=\"view3\" class='tab'>
					<div>
						<label>IR1:</label>
						<input type='text' value='".checkEmpty($data[0]["IR1"])."' name='ir1' ".$privilege." class='text'>
					</div>
					<div>
						<label>IR2:</label>
						<input type='text' value='".checkEmpty($data[0]["IR2"])."' name='ir2' ".$privilege." class='text'>
					</div>
					<div>
						<label>MANAGERIR:</label>
						<input type='text' value='".checkEmpty($data[0]["MANAGERIR"])."' name='managerir' ".$privilege." class='text'>
					</div>
					<div>
						<label>MANUFACTURERIR:</label>
						<input type='text' value='".checkEmpty($data[0]["MANUFACTURERIR"])."' name='manufatureir' ".$privilege." class='text'>
					</div>
					<div>
						<label>ATTACHEDJOBNOTES:</label>
						<img src='http://www.utvmedia.com/images/layout/PDF_icon_homepage.gif'
						        onclick='MM_openBrWindow(\"php-file-uploader/index.php\")'>
					</div>
					<div>
						<label>ATTACHMENTS:</label>
						<img src='http://www.utvmedia.com/images/layout/PDF_icon_homepage.gif'
						        onclick='MM_openBrWindow(\"php-file-uploader/index.php\")'>
					</div>
					<div>
						<label>INTERNETLINK:</label>
						<input type='text' value='".checkEmpty($data[0]["INTERNETLINK"])."' name='internetlink' ".$privilege." class='text'> 
					</div>
					
					<div>
						<label>QTY_BACKORDER:</label>
						<input type='text' value='".checkEmpty($data[0]["QTY_BACKORDER"])."' name='qty_backorder' ".$privilege." class='text'>
					</div>
				</div>
				<span style='margin:300px'>";
				if($privilege != "readonly")
					$content.="<button type='button' onclick='update_serviceIssueJob_form()' class='final'>Update</button>";
	    		    	$content .="<button type='button' onclick='cancle()' style='margin-left:1px' class='final'>Cancle</button>
				</span>
	    		 </div>
	    </form>";

	echo $content;
/**************************************************
		function definition
**************************************************/
//check if value is empty
function checkEmpty($value)
{
	if(empty($value))
		return 'N/A';
	else
		return $value;
}

?>