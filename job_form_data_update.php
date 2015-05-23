<?php
	require_once 'includes/db_connect.php';
	
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
	//tab2
	//	equipmenttype
	//	category
	//	statues
	//	rentalrepairquoteno
	//	todo
	//	schedule_date
	//	adminnotes
	//	service_admin
	//	part_rep
	$tab2ischange = $_POST['tab2ischange'];
	if($tab2ischange){
		//update the data in tab2
		$database->update('QRY_FORMS_JOBS',[
			"EQUIPMENTTYPE"=>Validation($_POST['equipmenttype']),
			"CATEGORY"=>Validation($_POST['category']),
			"STATUS"=>Validation($_POST['statues']),
			"RENTALREPAIRQUOTENO"=>Validation($_POST['rentalrepairquoteno']),
			"TODO"=>Validation($_POST['schedule_date']),
			"ADMINNOTES"=>Validation($_POST['adminnotes']),
			"SERVICE ADMIN"=>Validation($_POST['service_admin']),
			"PARTS REP"=>Validation($_POST['part_rep'])
		],[
			"AND"=>[
			"JOB_NO"=>$job_no,
			"CUST_NO"=>$cust_no
			]
		]);
	}
	
	//tab3
	//	qty_backorder
	//	defectrating
	//	cf1
	//	cf2
	//	cf3
	//	si1
	//	si2
	//	servicehistorynotes
	$tab3ischange = $_POST['tab3ischange'];
	if($tab3ischange){
		$database->update('QRY_FORMS_JOBS',[
			"QTY_BACKORDER"=>Validation($_POST['qty_backorder']),
			"DEFECTRATING"=>Validation($_POST['defectrating']),
			"CF1"=>Validation($_POST['cf1']),
			"CF2"=>Validation($_POST['cf2']),
			"CF3"=>Validation($_POST['cf3']),
			"Sl1"=>Validation($_POST['si1']),
			"SI2"=>Validation($_POST['si2']),
			"SERVICEHISTORYNOTES"=>$_POST['servicehistorynotes']
		],[
			"AND"=>[
			"JOB_NO"=>$job_no,
			"CUST_NO"=>$cust_no
			]
		]);
	}
	
	//tab4
	//	ir1
	//	ir2
	//	managerir
	//	manufatureir
	//	internetlink
	//	attachments
	//	id
	$tab4ischange = $_POST['tab4ischange'];
	if($tab4ischange){
		$database->update('QRY_FORMS_JOBS',[
			"IR1"=>Validation($_POST['ir1']),
			"IR2"=>Validation($_POST['ir2']),
			"MANAGERIR"=>Validation($_POST['managerir']),
			"MANUFACTURERIR"=>Validation($_POST['manufatureir']),
			"INTERNETLINK"=>Validation($_POST['internetlink']),
			"ATTACHMENTS"=>Validation($_POST['attachments']),
			"ID"=>Validation($_POST['id']),
		],[
			"AND"=>[
			"JOB_NO"=>$job_no,
			"CUST_NO"=>$cust_no
			]
		]);
	}
		
?>