<?php

include '../Model/Brick.php';
include '../Model/User.php';
include '../Model/DB.php';
include 'commonFunctions.php';

function main_controller(){
  httpsRedirect();  // redirect on HTTPS
  session_start();
  checkCookies();   // check if Coockies are enabled

  if ($_SERVER ['REQUEST_METHOD'] === 'POST') {
    $new_user = new user();  // create a new user
    $new_user -> logIn();   // sign up
  }

}

function checkParam(){
  if (isset ( $_GET ["log"] )) {
    $mex = urldecode ( $_GET ["log"] );
    $mex = _sanitize($mex);
    if($mex == 'fail_uname'){
      echo '<div class="alert alert-danger alert-dismissible" role="alert">';
      echo '  <strong>Error!</strong> This user does not exists.';
      echo '</div>';
  }else if($mex == 'fail_pass'){
     echo '<div class="alert alert-danger alert-dismissible" role="alert">';
     echo ' <strong>Error!</strong> Wrong password.';
     echo '</div>';
   }
  }
}
 ?>
