<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>File manager</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
   
  </head>

  <body>

    <!-- Static navbar -->
    <div class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">File manager</a>
        </div>
      </div>
    </div>


    <div class="container">
    
    	<div class="row">
	       <?php 
       		require_once '../includes/db_connect.php';
	       
	        
	       
	      	$jobid 		= $_GET['jobid'];
	      	$tableid 	= $_GET['tableid'];
              	$attribute 	= $_GET['attribute'];
		$table 		= "";
		//print $tableid;
		switch($tableid){
			case 1:
			$table = "QRY_FORMS_JOBS";
			break;
			case 2:
			$table = "qry_forms_jobs_si_jobs";
			break;
			case 3:
			$table = "TBL_JOBS_Si";
			break;
			default:
			exit;
		}
	       
	       
		$paths = $database->select($table,$attribute, ["JOB_NO"=>$jobid]);
	    	$paths = explode('#',$paths[0]);
		foreach($paths as $p){
			//if $p is empty skip current loop.
			if(empty($p) || $p == '.' || $p == '..' || $p == ' ') continue;
			//case 1 use /
			if(!empty(strripos($p, '/')))
				$index = strripos($p, '/')+1;//escape the '/' character.
			//case 2 user \
			else if(!empty(strripos($p, '\\')))
				$index = strripos($p, '\\')+1;//escape the '\' character.
			else 
				$index = 0;
		
			$file = substr($p, $index);
		
			$ext = pathinfo($p, PATHINFO_EXTENSION);
			$filename = pathinfo($p, PATHINFO_FILENAME);
			if($ext == 'pdf'){
				#$img = new Imagick($folder . '/' . $result);
	       			echo "
	       				<div class='col-md-3'>
		       			<div class='thumbnail'>
						<img src='../../img/pdf.png' alt='...'>
				       		<div class='caption' style='margin:aut'>
				       		<p>
						<a href='remove.php?name='".$p."' class='btn btn-danger' role='button'>Remove</a>
						<a href='".$p."' target='_blank' class='btn btn-info' role='button'>View</a>
						</p>
						<p>".$file."</p>
						</div>
						
		       			</div>
	       				</div>";
				
			}else{
				
	       			echo "
	       				<div class='col-md-3'>
		       			<div class='thumbnail'>
						<img src='".$p."' alt='...'>
				       		<div class='caption' style='margin:aut'>
				       		<p>
						<a href='remove.php?name='".$p."' class='btn btn-danger' role='button'>Remove</a>
						<a href='".$p."' target='_blank' class='btn btn-info' role='button'>View</a>
						</p>
						</div>
						
		       			</div>
	       				</div>";
			}
		}	
		
	       ?>
    	</div>
    	
		

	      <div class="row">
	      	<div class="col-lg-12">
	           <form class="well" action="upload.php" method="post" enctype="multipart/form-data">
				  <div class="form-group">

				    <input type="file" name="file">
				    <input type='hidden' name='tableid' value=<?php echo $jobid."#".$tableid."#".$attribute;?>>
				    <p class="help-block">Only jpg,jpeg,png and pdf file with maximum size of 10 MB is allowed.</p>
				  </div>
				  <input type="submit" class="btn btn-lg btn-primary" value="Upload">
				</form>
			</div>
	      </div>
    </div> <!-- /container -->

  </body>
</html>