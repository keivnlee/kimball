<?php
	
	//include the medoo framework
	require_once('medoo.min.php');
	
	// key of the selected item from the database.
	$si  = $_REQUEST['SI']; 
	$ir1 = $_REQUEST['IR1']; 
	$ir2 = $_REQUEST['IR2'];
	// check the provolege of user
		//admin
		//user
	$privilege = "";
	session_start();
	if($_SESSION['privilege'] == "user")
		$privilege = "readonly";
	
	//medoo framework
	$database =  new medoo();
	
	//access item in the database
	$data = $database->select('TBL_JOBS_Si','*',[
		"AND"=>[
			"SI"=>$si,
			"IR1"=>$ir1,
			"IR2"=>$ir2
		]
	]);


$content = "<span style='color:rgb(140,27,27)'><p align='center'> Service Issue Form</p></span>
	    <form style=\"padding:3px; margin:3px\" action='serviceIssue_form_dataupdate.php' id='serviceIssue_form' >
	    	<div>
			<label>SI:</label>
			 <input type='text' value='".checkEmpty($data[0]['SI'])."' class ='text' name='si' ".$privilege.">
		</div>
		<div>
			<label>ServiceNotes:</label>
			 <textarea class ='text' ".$privilege." name='servicenotes'>".checkEmpty($data[0]['SERVICENOTES'])." </textarea>
		</div>
		<div>
			<label>Attachment:</label>
			<input type='text' name='attachment' class ='text' value='".checkEmpty($data[0]['ATTACHMENT'])."' ".$privilege.">
		</div>
		<div>
			<label>Attachments:</label>
			<input type='text' name='attachments' class ='text' value='".checkEmpty($data[0]['ATTACHMENTS'])."' ".$privilege.">
		</div>
		<div>
			<label>IR1:</label>
			<input type='text' name='ir1' class ='text' value='".checkEmpty($data[0]['IR1'])."' ".$privilege.">
		</div>
		<div>
			<label>IR2:</label>
			<input type='text' name='ir2' class ='text' value='".checkEmpty($data[0]['IR2'])."' ".$privilege.">
		</div>
		<div>
			<label>IRMANAGER:</label>
			<input type='text' name='irmanager' class ='text' value='".checkEmpty($data[0]['IRMANAGER'])."' ".$privilege.">
		</div>
		<div>
			<label>IRMANUFACTURER:</label>
			<input type='text' name='irmanufacturer' class ='text' value='".checkEmpty($data[0]['IRMANUFACTURER'])."' ".$privilege.">
		</div>
		<div>
			<label>Standard:</label>
			<input type='text' name='standard' class ='text' value='".checkEmpty($data[0]['STANDARD'])."' ".$privilege.">
		</div>
		<div>
			<label>Application:</label>
			<input type='text' name='application' class ='text' value='".checkEmpty($data[0]['APPLICATION'])."' ".$privilege.">
		</div>
		<div>	
			<span style='margin:300px'> ";
			if($privilege != "readonly")
		    		$content .= "<button type='button' onclick='update_serviceIssue_form()' class='final'>Update</button>";
			$content .="<button type='button' onclick='cancle()' style='margin-left:1px' class='final'>Cancle</button>
		 	</span>
		</div>
			
	    </form>";

echo $content;






/********************************************************
			function define
*********************************************************/
/****************
	check if the value is empty
****************/
function checkEmpty($value)
{
	if(empty($value))
		return "N/A";
	else
		return $value;
}
?>