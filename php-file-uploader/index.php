<?
	
?>

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
	       	//scan "uploads" folder and display them accordingly
	       $folder = "uploads";
	       $results = scandir('uploads');
	       foreach ($results as $result) {
	       	if ($result === '.' or $result === '..') continue;
		
		$ext = pathinfo($result, PATHINFO_EXTENSION);
		$filename = pathinfo($result, PATHINFO_FILENAME);
	       
	       	if (is_file($folder . '/' . $result)) {
			if($ext == 'pdf'){
				#$img = new Imagick($folder . '/' . $result);
	       			echo '
	       				<div class="col-md-3">
		       			<div class="thumbnail"><img src="pdf.png" alt="...">
				       		<div class="caption" style="margin:aut">
				       		<p><a href="remove.php?name='.$result.'" class="btn btn-danger btn-xs" role="button">Remove</a>
						<a href="'.$folder . '/' . $result.'" target="_blank" class="btn btn-danger btn-xs" role="button">'.$filename.'</a></p>
						</div>
						
		       			</div>
	       				</div>';
				
			}else{
	       			echo '
	       				<div class="col-md-3">
		       			<div class="thumbnail"><img src="'.$folder . '/' . $result.'" alt="...">
				       		<div class="caption">
				       		<p><a href="remove.php?name='.$result.'" class="btn btn-danger btn-xs" role="button">Remove</a>
						<a href="'.$folder . '/' . $result.'" target="_blank" class="btn btn-danger btn-xs" role="button">View</a></p>
			       			</div>
		       			</div>
	       				</div>';
			}
	       	}
	       }
	       ?>
    	</div>
    	
		

	      <div class="row">
	      	<div class="col-lg-12">
	           <form class="well" action="upload.php" method="post" enctype="multipart/form-data">
				  <div class="form-group">

				    <input type="file" name="file">
				    <p class="help-block">Only jpg,jpeg,png and pdf file with maximum size of 10 MB is allowed.</p>
				  </div>
				  <input type="submit" class="btn btn-lg btn-primary" value="Upload">
				</form>
			</div>
	      </div>
    </div> <!-- /container -->

  </body>
</html>