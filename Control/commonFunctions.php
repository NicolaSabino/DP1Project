<?php

  // move from HTTP to HTTPS
  function httpsRedirect(){
    if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
      $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
      header('HTTP/1.1 301 Moved Permanently');
      header('Location: ' . $redirect);
      exit();
    }
  }

  // redirect to the error page
  function errorRedirector($msg = "") {
	header ( 'HTTP/1.1 307 temporary redirect' );
	header ( "Location: ErrorPage.php?msg=" . urlencode ( $msg ) );
  }

  // check if cookies are available
  function checkCookies(){
    if (isset ( $_SESSION ['MyCookie'] )) // if the cookie is set there are no problems
		  return true;
	  else {
  		if (isset ( $_REQUEST ['check'] )) {  // if `check` is set we are after the redirect
        // if the cookie does not exists and the redirect
        // has just been executed report the error
  			errorRedirector ( "Coockies are disabled" );
  		} else {
        $_SESSION['MyCookie'] = ' random content';            // set a cookie
        $redirect = 'http://' . $_SERVER['HTTP_HOST']         // create the redicet URL with a `check` value inside
                    . $_SERVER['REQUEST_URI'].'?check=something';
  			header ( 'Location:' . $redirect);                    // redirect
  			exit ();
  		}
  	 }
  }

  function sanitize($conn, $string){
    $string = strip_tags ( $string );                       // Strip HTML and PHP tags from a string
    $string = htmlentities ( $string );                     // Convert all applicable characters to HTML entities
    $string = mysqli_real_escape_string ( $conn, $string ); // Escapes special characters in a string for use in an SQL statement,
                                                            // taking into account the current charset of the connection
	  return $string;
  }

  function _sanitize($string){                              // same method without msqli_...
    $string = strip_tags ( $string );                       // Strip HTML and PHP tags from a string
    $string = htmlentities ( $string );                     // Convert all applicable characters to HTML entities
    return $string;
  }

  // check if the session is still valid
  function sessionTimer(){
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 120)) { //120 sec = 2 min
        // last request was more than 2 minutes ago
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage
        header ( "Location: HomePage.php?msg=session_timeout");
    }
    $_SESSION['last_activity'] = time(); // update last activity time stamp
  }


 ?>
