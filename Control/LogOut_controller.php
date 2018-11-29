<?php

include 'commonFunctions.php';
httpsRedirect();        // redirect on HTTPS
session_start();        //start or retrive the current session
checkCookies();         // check if Coockies are enabled

session_unset();    // unset $_SESSION variable for the run-time
session_destroy (); // destroy session
header("Location:../View/HomePage.php?msg=session_end");
?>
