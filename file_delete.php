<?php
	/************************************************************
		$id 	which item is edited
		$table 	which table's item is edited
		$db	which database table is edit.
	
	User delete the file, and need to delete the path in the database for consistence
	Here, we will receive the table informaiton, which attribute in the table and also 
	ID used to identify the specify entry in the database.
	*************************************************************/
	//include the medod framework
	require_once('medoo.min.php');
	$db = new medoo();

	$table 	= $_POST['table'];
	$attribute = $_POST['attribute'];
	$job_no = $_POST['job_no'];
	$cust_no = $_POST['cust_no'];
	
	
	
	Job_file_Upload_Database_Path_Update($db, $table, $attribute, "", $job_no, $cust_no);
	echo "here is the log ".var_dump( $db->log() );
	/***********************************************************************************************
					function define
	************************************************************************************************/
	function Job_file_Upload_Database_Path_Update($db, $tb, $attribute, $path, $job_no, $cust_no)
	{
	
		//update the data in tab2
		if($tb == 'job')
			$db->update('QRY_FORMS_JOBS',[
				$attribute=>$path
			],[
				"AND"=>[
					"JOB_NO"=>$job_no,
					"CUST_NO"=>$cust_no
					]
			]);
	}
?>