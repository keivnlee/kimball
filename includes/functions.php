<?php

//what is this function used for?
function  sec_session_start(){
        $session_name = 'sec_session_id';   // Set a custom session name
        // This stops JavaScript being able to access the session id.
        $httponly = true;
        // Forces sessions to only use cookies.
        if (ini_set('session.use_only_cookies', 1) === FALSE) {
            header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
            exit();
        }
        // Gets current cookies params.
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams["lifetime"],
            $cookieParams["path"], 
            $cookieParams["domain"], 
            false,
            $httponly);
        // Sets the session name to the one set above.
        session_name($session_name);
        session_start();            // Start the PHP session 
        session_regenerate_id(true);    // regenerated the session, delete the old one. 
}

function login($username, $password, $database){
	$password = htmlspecialchars($password);
	$username = htmlspecialchars($username);
	$mdpword = md5($password);
	$user_browser = $_SERVER['HTTP_USER_AGENT'];
	$rows = $database->count('Login','*', [
		"AND"=>[
			"username"=>$username,
			"lpassword"=>$mdpword
		]
	]);	
	
	if( $rows == 1){
		$_SESSION['username'] = $username;
		$_SESSION['login_string'] = hash('sha512', $password . $user_browser);
		$user = $database->select('Login','*',['username'=>$username]);
		$_SESSION['privilege']= $user[0]['userid'];
		return true;
	}else
		return false;
}

function login_check(){
	//check if the session variables are set.
	if(isset($_SESSION['username'],$_SESSION['login_string']))
		return true;
	else
		return false;
}

function esc_url($url) {
    if ('' == $url) {
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}
?>