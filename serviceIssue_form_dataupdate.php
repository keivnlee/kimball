<?php

/**********************************************************************
		function definition
		"IRMANAGER"=>Valiation($_POST['irmanager']),
		"IRMANUFACTURER"=>Valiation($_POST['irmanufacturer']),
		"STANDARD"=>Valiation($_POST['standard']),
		"APPLICATION"=>Valiation($_POST['application'])
***********************************************************************/
	//check if the variable value is N/A
	function Valiation($value){
		if($value == 'N/A')
			return "";
		else
			return $value;
	}
		
	//include the medoo framework
	require_once 'includes/db_connect.php';
	
	//get the key of the item
	$si  = Valiation($_REQUEST['si']); 
	$ir1 = Valiation($_REQUEST['ir1']); 
	$ir2 = Valiation($_REQUEST['ir2']);
	
	//update the data
	$database->update('TBL_JOBS_SI',[
		"SI"=>Valiation($_POST['si']),
		"SERVICENOTES"=>Valiation($_POST['servicenotes']),
		"ATTACHMENT"=>Valiation($_POST['attachment']),
		"ATTACHMENTS"=>Valiation($_POST['attachments']),
		"IR1"=>Valiation($_POST['ir1']),
		"IR2"=>Valiation($_POST['ir2']),
		"IRMANAGER"=>Valiation($_POST['irmanager']),
		"IRMANUFACTURER"=>Valiation($_POST['irmanufacturer']),
		"STANDARD"=>Valiation($_POST['standard']),
		"APPLICATION"=>Valiation($_POST['application'])
	],[
		"AND"=>[
		"SI"=>$si,
		"IR1"=>$ir1,
		"IR2"=>$ir2
		]
	]);	
?>