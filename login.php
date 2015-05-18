<?PHP
$uname = "";
$pword = "";
$errorMessage = "";
	


if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$uname = $_POST['username'];
	$pword = $_POST['password'];
	
	$uname = htmlspecialchars($uname);
	$pword = htmlspecialchars($pword);
	
	//========================================
	//	connect to the local database
	//========================================
	$user_name = "root";
	$pass_word = "";
	$database  = "kimball";
	$server	   = "localhost";
	
	$db_handle = mysqli_connect($server, $user_name, $pass_word);
	$db_found  = mysqli_select_db($db_handle, $database);
	
	if($db_found){	
		$uname = quote_smart($uname, $db_handle);
		$pword = quote_smart($pword, $db_handle);
		$mdpword = md5($pword);
		$SQL = "SELECT * FROM Login WHERE username = '$uname' 
			AND lpassword = '$mdpword'";	
			
		$result = mysqli_query($db_handle, $SQL);
		if($result)
			$num_rows = mysqli_num_rows($result);
		else
			$num_rows = 0;
		
		
		//===================================================
		//	CHECK TO SEE IF THE $result variable is true
		//===================================================
		if($result){
			$row = mysqli_fetch_array($result, MYSQLI_NUM);
			
			if($num_rows > 0){
				session_start();
				$_SESSION['login'] = "1";
				$_SESSION['privilege'] = $row[0];
				header("Location:index.php");
                echo "success";
			}
			else{
				session_start();
				$_SESSION['login'] = "";
				$_SESSION['privilege'] = "";
				header("Location: login.php");
			}
		}
	}
	else
	{
		$errorMessage = "Error logging on";
	}
}

//==============================================
//	ESCAPE DANGEROUS SQL CHARACTERS
//==============================================

function quote_smart($value){
	
        if (get_magic_quotes_gpc()) {
            $value = stripslashes($value);
        }
	
	return mysql_real_escape_string($value); 
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<style>
/* Basics */
html, body {
    width: 100%;
    height: 100%;
    font-family: "Helvetica Neue", Helvetica, sans-serif;
    color: #444;
    -webkit-font-smoothing: antialiased;
}
#container {
    position: fixed;
    width: 340px;
    height: 280px;
    top: 50%;
    left: 50%;
    margin-top: -140px;
    margin-left: -170px;
	background: #fff;
    border-radius: 3px;
    border: 1px solid #ccc;
    box-shadow: 0 1px 2px rgba(0, 0, 0, .1);
	
}
form {
    margin: 0 auto;
    margin-top: 20px;
}
label {
    color: #555;
    display: inline-block;
    margin-left: 18px;
    padding-top: 10px;
    font-size: 14px;
}
p a {
    font-size: 11px;
    color: #aaa;
    float: right;
    margin-top: -13px;
    margin-right: 20px;
 -webkit-transition: all .4s ease;
    -moz-transition: all .4s ease;
    transition: all .4s ease;
}
p a:hover {
    color: #555;
}
input {
    font-family: "Helvetica Neue", Helvetica, sans-serif;
    font-size: 12px;
    outline: none;
}
input[type=text],
input[type=password] {
    color: #777;
    padding-left: 10px;
    margin: 10px;
    margin-top: 12px;
    margin-left: 18px;
    width: 290px;
    height: 35px;
	border: 1px solid #c7d0d2;
    border-radius: 2px;
    box-shadow: inset 0 1.5px 3px rgba(190, 190, 190, .4), 0 0 0 5px #f5f7f8;
-webkit-transition: all .4s ease;
    -moz-transition: all .4s ease;
    transition: all .4s ease;
	}
input[type=text]:hover,
input[type=password]:hover {
    border: 1px solid #b6bfc0;
    box-shadow: inset 0 1.5px 3px rgba(190, 190, 190, .7), 0 0 0 5px #f5f7f8;
}
input[type=text]:focus,
input[type=password]:focus {
    border: 1px solid #a8c9e4;
    box-shadow: inset 0 1.5px 3px rgba(190, 190, 190, .4), 0 0 0 5px #e6f2f9;
}
#lower {
    background: rgba(110, 110, 110, 0.08);
    width: 100%;
    height: 69px;
    margin-top: 20px;
	  box-shadow: inset 0 1px 1px #fff;
    border-top: 1px solid #ccc;
    border-bottom-right-radius: 3px;
    border-bottom-left-radius: 3px;
}
input[type=checkbox] {
    margin-left: 20px;
    margin-top: 30px;
}

input[type=submit] {
    float: right;
    margin-right: 20px;
    margin-top: 20px;
    width: 80px;
    height: 30px;
font-size: 14px;
    font-weight: bold;
    color: #fff;
    background-color: #FF0505; /*IE fallback*/
    background-image: -webkit-gradient(linear, left top, left bottom, from(#CA1A1A), to(#EF1818));
    background-image: -moz-linear-gradient(top left 90deg, #CA1A1A 0%, #EF1818 100%);
    background-image: linear-gradient(top left 90deg, #CA1A1A 0%, #EF1818 100%);
    border-radius: 30px;
    border: 1px solid #D66666;
    box-shadow: 0 1px 2px rgba(0, 0, 0, .3), inset 0 1px 0 rgba(255, 255, 255, .5);
    cursor: pointer;
}
input[type=submit]:hover {
    background-image: -webkit-gradient(linear, left top, left bottom, from(#CA1A1A), to(#CA1A1A));
    background-image: -moz-linear-gradient(top left 90deg, #CA1A1A 0%, #CA1A1A 100%);
    background-image: linear-gradient(top left 90deg, #CA1A1A 0%, #CA1A1A 100%);
}
input[type=submit]:active {
    background-image: -webkit-gradient(linear, left top, left bottom, from(#EF1818), to(#EF1818));
    background-image: -moz-linear-gradient(top left 90deg, #EF1818 0%, #EF1818 100%);
    background-image: linear-gradient(top left 90deg, #EF1818 0%, #EF1818 100%);
}
</style>

</head>

<body>
    <!-- Begin Page Content -->
    <div style="background-image: url('http://www.kimballequipment.com/wp-content/uploads/2014/08/kimball-logo-black-font-325.png'); height: 59px; width: 329px; margin:auto; margin-top:5%"> 
    </div>
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
	<?PHP print $errorMessage;?>
    </div><!--/ container-->
    <!-- End Page Content -->
	
</body>
</html>

