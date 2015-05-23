<?php
	require_once 'includes/db_connect.php';
	require_once 'includes/functions.php';
	
	//access item in the database 
	$data = $database->select('QRY_FORMS_JOBS','*', [
		"AND"=>[
			"JOB_NO"=>$_REQUEST['job_no'],
			"CUST_NO"=>$_REQUEST['cust_no']
		]
	]);

        //check the privilege
	$privilege = "";
	sec_session_start();
	if($_SESSION['privilege'] == 1)
		$privilege = "readonly";
	
$content = "
	    <span style='color:rgb(140,27,27)'>
	        <p align='center'> Job Form</p>
        </span>
	    <form action='job_form_data_update.php' id='job_form'>
	    	<div>
	    	    <ul class=\"tabs\" data-persist=\"true\">
			    <li><a id='li1' onclick='tab_select(\"view1\", \"li1\")' class='tab_index'>page1</a></li>
			    <li><a id='li2' onclick='tab_select(\"view2\", \"li2\")' class='tab_index'>page2</a></li>
			    <li><a id='li3' onclick='tab_select(\"view3\", \"li3\")' class='tab_index'>page3</a></li>
			    <li><a id='li4' onclick='tab_select(\"view4\", \"li4\")' class='tab_index'>page4</a></li>
		        </ul>
		    </div>
		    <div class=\"tab_contents\">
	    		<div id=\"view1\" class='tab'>
	   	    	    <div>
	    			    <label>Job_ID:</label>
				        <input type='text' value='".checkEmpty($data[0]["JOB_NO"])."' name='job_no' class='text' readonly>
                    </div>
                    <div>
	   			        <label>Cust_NO:</label>
				        <input type='text' value='".checkEmpty($data[0]["CUST_NO"])."' name='cust_no' class='text' readonly>
                    </div>
                    <div>
	    			    <label>Ord_Date:</label>
				        <input type='text' value='".checkEmpty($data[0]["ORD_DATE"])."' name='ord_date 'class='text' readonly>
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
				        <label>CUST_PO:</label>
				        <input type='text' value='".checkEmpty($data[0]["CUST_PO"])."' name='cust_po' class='text' readonly>
    			    </div>
        	   	        <span style='margin:300px'>";
    		//admin and user
    		if($privilege != "readonly")
    			$content = $content."<button type='button' onclick='update_job_form()' class='final'>Update</button>";
    		$content = $content."<button type='button' onclick='cancle()' style='margin-left:1px' class='final'>Cancle</button>
    		</span>
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
					    <label>RentalRepairQuoteNo:</label>
					    <input type='text' value='".checkEmpty($data[0]["RENTALREPAIRQUOTENO"])."' name='rentalrepairquoteno' ".$privilege." class='text'>
	    			</div>
                    <div>
					    <label>Todo:</label>
					    <input type='text' value='".checkEmpty($data[0]["TODO"])."' name='todo' ".$privilege." class='text'>
	   			    </div>
	    			<div>
					    <label>Schedule Date:</label>
					    <input type='text' value='".checkEmpty($data[0]["SCHEDULED DATE"])."' name='schedule_date' ".$privilege." class='text'>
	   			    </div>
	    			<div> 
	   				    <label>Adminnotes:</label>
					    <input type='text' value='".checkEmpty($data[0]["ADMINNOTES"])."' name='adminnotes' ".$privilege." class='text'>
	    			</div>
	    			<div>
					    <label>Service Admin:</label>
					    <input type='text' value='".checkEmpty($data[0]["SERVICE ADMIN"])."' name='service_admin' ".$privilege." class='text'>
	    			</div>
	    			<div>
					    <label>Parts Rep:</label>
					    <input type='text' value='".checkEmpty($data[0]["PARTS REP"])."'  name='part_rep' ".$privilege." class='text'>
	    			</div>
	    	   	        <span style='margin:300px'>";
			//admin and user
			if($privilege != "readonly")
				$content = $content."<button type='button' onclick='update_job_form()' class='final'>Update</button>";
			$content = $content."<button type='button' onclick='cancle()' style='margin-left:1px' class='final'>Cancle</button>
			</span>
	    		</div>
	    		<div id=\"view3\" class='tab'>
	    			<div>	
					    <label>QTY_BACKORDER:</label>
					    <input type='text' value='".checkEmpty($data[0]["QTY_BACKORDER"])."' name='qty_backorder' ".$privilege." class='text'>
	    			</div>	
	    			<div>
					    <label>DefectRating:</label>
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
					    <input type='text' value='".checkEmpty($data[0]["Sl1"])."' name='si1' ".$privilege." class='text'>
	    			</div>
	    			<div>
					    <label>SI2:</label>
					    <input type='text' value='".checkEmpty($data[0]["SI2"])."' name='si2' ".$privilege." class='text'>
	    			</div>
	    			<div>
					    <label>ServiceHistoryNotes:</label>
					    <input type='text' value='".checkEmpty($data[0]["SERVICEHISTORYNOTES"])."' name='servicehistorynotes' ".$privilege." class='text'>
	    			</div>
	    	   	        <span style='margin:300px'>";
			//admin and user
			if($privilege != "readonly")
				$content = $content."<button type='button' onclick='update_job_form()' class='final'>Update</button>";
			$content = $content."<button type='button' onclick='cancle()' style='margin-left:1px' class='final'>Cancle</button>
			</span>
	   	     	</div>
	    		<div id=\"view4\" class='tab'>
	    			<div>
					    <label>IR1:</label>
					    <input type='text' value='".checkEmpty($data[0]["IR1"])."' name='ir1' ".$privilege." class='text'>
	    			</div>	
	    			<div>
					    <label>IR2:</label>
					    <input type='text' value='".checkEmpty($data[0]["IR2"])."' name='ir2' ".$privilege." class='text'>
	    			</div>
	    			<div>
					    <label>ManagerIR:</label>
					    <input type='text' value='".checkEmpty($data[0]["MANAGERIR"])."' name='managerir' ".$privilege." class='text'>
	    			</div>
	    			<div>
					    <label>ManufacturerIR:</label>
					    <input type='text' value='".checkEmpty($data[0]["MANUFACTURERIR"])."' name='manufatureir' ".$privilege." class='text'>
	    			</div>
    				<div>
					    <label>InternetLink:</label>
					    <input type='text' value='".checkEmpty($data[0]["INTERNETLINK"])."' name='internetlink' ".$privilege." class='text'>
    				</div>
    				<div>
					    <label>Attachments:</label>
					    <input type='text' value='".checkEmpty($data[0]["ATTACHMENTS"])."' name='attachments' ".$privilege." class='text'>
    				</div>
	   	 		    <div>
					    <label>ID:</label>
					    <input type='text' value='".checkEmpty($data[0]["ID"])."' name='id' ".$privilege." class='text'>
				    </div>
	    			
	    			<div>
					<label>AttachedJobNotes:</label>
					<img src='http://www.utvmedia.com/images/layout/PDF_icon_homepage.gif'
					        onclick='MM_openBrWindow(\"php-file-uploader/index.php\")'>".checkEmpty($data[0]["ATTACHEDJOBNOTES"]);
	    	    		//$res = explode('#', $data[0]["ATTACHEDJOBNOTES"]);
				        //$content .= file_upload_section_handler($res[0], 'ATTACHEDJOBNOTES',
						//$data[0]['JOB_NO'], $data[0]['CUST_NO'], $privilege);
                    $content .="
                    <div>
					<label>JobNoteLink:</label>
					<img src='http://www.utvmedia.com/images/layout/PDF_icon_homepage.gif'
					        onclick='MM_openBrWindow(\"php-file-uploader/index.php\")'>".checkEmpty($data[0]["JOBNOTELINK"]);
					
				       // $content .= file_upload_section_handler($data[0]["JOBNOTELINK"],
						//'JOBNOTELINK', $data[0]['JOB_NO'], $data[0]['CUST_NO'], $privilege);
                    $content .= "</div>
	    		    </div>
    	   	        <span style='margin:300px'>";
		//admin and user
		if($privilege != "readonly")
			$content = $content."<button type='button' onclick='update_job_form()' class='final'>Update</button>";
		$content = $content."<button type='button' onclick='cancle()' style='margin-left:1px' class='final'>Cancle</button>
		</span>
		</div>
		</div>
	    </form>";
echo $content;
	
	
/********************************************************
			function define
*********************************************************/
//function definition
//check if value is empty
function checkEmpty($value)
{
	if(empty($value))
		return "N/A";
	else
		return $value;
}


/*
	$attribute: LINKNOTE or ATTACHMENTS
 	$path : file path
 
function file_upload_section_handler($path, $att, $job_no, $cust_no, $privilege){
	$html = "<span id='".$att."section'>";
	//check if it has attachment	
	if($path=="N/A" or Empty($path)){
		//add a file upload box here
		if($privilege != "readonly")
			$html .="<input type='file' id='".$att."' name='fileToUpload'>
			<input type='button' value='upload' 
				onclick = upload('job','".$att."','".$job_no."','".$cust_no."')>
			";
		else
			$html .= "";
	}
	else{
		//Here only needs the file name, delete the file's long path. Only file name left.
		if(strpos($path, '\\') !== false)
			$path = substr($path, strrpos($path,'\\')+1);
		
		//admin and user 
		if($privilege != "readonly")
			$html .="<img src='http://www.utvmedia.com/images/layout/PDF_icon_homepage.gif'>
				<a href=".$path." target='_blank'>".$path.
				"</a>&nbsp;&nbsp;<a href='#' onclick=deleteFile('job','".$att."','".$job_no."','".$cust_no."')>delete</a><br>";
		else
			$html .="<img src='http://www.utvmedia.com/images/layout/PDF_icon_homepage.gif'>
					<a href=".$path." target='_blank'>".$path."</a>";
	}
	return $html.="</span>";
}
*/			
?>