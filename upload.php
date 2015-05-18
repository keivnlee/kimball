<?php  
	/************************************************************
		$id 	which item is edited
		$table 	which table's item is edited
		$db	which database table is edit.
	*************************************************************/
	//include the medod framework
	require_once('medoo.min.php');
	$db = new medoo();

	$target_dir = "uploads/";
	$target_file = $target_dir.basename($_FILES['fileToUpload']['name']);
	//strip the space in the path
	$target_file = str_replace(' ', '', $target_file);
	$uploadOk = 1;
	$fileType = pathinfo($target_file, PATHINFO_EXTENSION);
	$table 	= $_POST['table'];
	$attribute = $_POST['attribute'];
	$job_no = $_POST['job_no'];
	$cust_no = $_POST['cust_no'];

	// chekc if the file already exists
	if(file_exists($target_file)){
		echo "file ".$target_file." already exists.";
		Job_file_Upload_Database_Path_Update($db, $table, $attribute, $target_file, $job_no, $cust_no);
		return;
	}
	
	//check file size, 10M is the limite
	if($_FILES["fileToUpload"]["size"] > 10000000){
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}
	
	// Only PDF file is allowed
	if($fileType != "pdf" && $fileType != "PDF" && $fileType !="jpg" && $fileType !="JPG") {
	    echo "Sorry, only pdf file is allowed.";
	    $uploadOk = 0;
	}

	//if all pre-check is passed, upload file
	if($uploadOk != 0){
		
	    if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'],$target_file))
	    {
		    echo "The file". basename($_FILES['fileToUpload']['name'])."has been uploaded";
		    Job_file_Upload_Database_Path_Update($db, $table, $attribute, $target_file, $job_no, $cust_no);
	    }else{
			echo "Sorry, there was an error uploading your file.";
	    }
	}
	
	
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