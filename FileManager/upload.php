<?php
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';

//turn on php error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$name     = $_FILES['file']['name'];
	$tmpName  = $_FILES['file']['tmp_name'];
	$error    = $_FILES['file']['error'];
	$size     = $_FILES['file']['size'];
        $ext	  = strtolower(pathinfo($name, PATHINFO_EXTENSION));
  	$jobid    = $_POST['jobid'];
	$tableid  = $_POST['tableid'];
	$attribute= $_POST['attribute'];
	switch ($error) {
		case UPLOAD_ERR_OK:
			$valid = true;
			//validate file extensions
			if ( !in_array($ext, array('jpg','jpeg','png','gif','pdf')) ) {
				$valid = false;
				$response = 'Invalid file extension.';
			}
			//validate file size
			if ( $size/1024/1024 > 10 ) {
				$valid = false;
				$response = 'File size is exceeding maximum allowed size.';
			}
			//upload file
			if ($valid) {
				$targetPath =  dirname( __FILE__ ) . DIRECTORY_SEPARATOR. 'uploads' . DIRECTORY_SEPARATOR. $name;
				if(move_uploaded_file($tmpName,$targetPath)){ 
					filepath_database_insert($database, $jobid, $tableid, $attribute, $targetPath);
					header( "Location: index.php?jobid=".$jobid."&tableid=".$tableid."&attribute=".$attribute) ;
					print "success";var_dump( $database->log() );
					exit;
				}
			}
			break;
		case UPLOAD_ERR_INI_SIZE:
			$response = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
			break;
		case UPLOAD_ERR_PARTIAL:
			$response = 'The uploaded file was only partially uploaded.';
			break;
		case UPLOAD_ERR_NO_FILE:
			$response = 'No file was uploaded.';
			break;
		case UPLOAD_ERR_NO_TMP_DIR:
			$response = 'Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3.';
			break;
		case UPLOAD_ERR_CANT_WRITE:
			$response = 'Failed to write file to disk. Introduced in PHP 5.1.0.';
			break;
		default:
			$response = 'Unknown error';
		break;
	}

	echo $response;
}
?>