<?php
	//include the medoo framework
	require_once('medoo.min.php');
	
	//check if the variable value is N/A
	function Validation($value){
		if($value == 'N/A')
			return "";
		else
			return $value;
	}
	
	//get the id of the item
	$job_no  = $_POST['job_no'];
	$cust_no = $_POST['cust_no'];
	
	//medoo framework database
	$database = new medoo();
	
	$database->update('qry_forms_jobs_si_jobs',[
		"EQUIPMENTTYPE"=>Validation($_POST['equipmenttype']),
		"CATEGORY"=>Validation($_POST['category']),
		"STATUS"=>Validation($_POST['statues']),
		"DEFECTRATING"=>Validation($_POST['defectrating']),
		"CF1"=>Validation($_POST['cf1']),
		"CF2"=>Validation($_POST['cf2']),
		"CF3"=>Validation($_POST['cf3']),
		"SI1"=>Validation($_POST['si1']),
		"SI2"=>Validation($_POST['si2']),
		"IR1"=>Validation($_POST['ir1']),
		"IR2"=>Validation($_POST['ir2']),
		"MANAGERIR"=>Validation($_POST['managerir']),
		"MANUFACTURERIR"=>Validation($_POST['manufatureir']),
		"INTERNETLINK"=>Validation($_POST['internetlink']),
		"QTY_BACKORDER"=>Validation($_POST['qty_backorder'])
	],[
		"AND"=>[
		"JOB_NO"=>$job_no,
		"CUST_NO"=>$cust_no
		]
	]); 
?>