<?PHP
require_once 'includes/functions.php';
require_once 'includes/db_connect.php';

$uname = "";
$pword = "";
$errorMessage = "";

sec_session_start();


if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$uname = $_POST['username'];
	$pword = $_POST['password'];
	
	print md5('user');
	if(login($uname, $pword, $database)){
		header('Location:index.php');
	}
	else{
		$errorMessage = "Error logging on";
		header('Location:login.php');
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Kimball Equipment</title>
<link rel="stylesheet" type="text/css" href="css/login.css">
</head>

<body>
    <div id="body">
    	<div id ="icon"></div>
   	<div id="container">
        	<Form name = "form1" method="post" action="login.php">
            	    <label for="username">Username:</label>
            	    <input type="text" name="username" value="<?PHP print $uname;?>" maxlength="30">
	    
            	    <label for="password">Password:</label>
            	    <input type="password" name="password" value="<?PHP print $pword;?>" maxlength="30">
                    <div id="lower">
                       <input type="submit" value="Login">
            	   </div><!--/ lower-->
                </form>
    	</div>
    </div>
    <?PHP print $errorMessage;?>
</body>
</html>

