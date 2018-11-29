<?php


  include '../Model/Brick.php';
  include '../Model/User.php';
  include '../Model/DB.php';
  include 'commonFunctions.php';

  function main_controller(){
    httpsRedirect();  // redirect on HTTPS
    session_start();  //start the user session
    checkCookies();   // check if Coockies are enabled

    if ($_SERVER ['REQUEST_METHOD'] === 'POST') {
      $new_user = new user();  // create a new user
      $new_user -> signUp();   // sign up
    }

  }

  function checkParam(){
    if (isset ( $_GET ["newUser"] )){
      $mex = urldecode ( $_GET ["newUser"] );
      $mex = _sanitize($mex);
      if($mex == 'done'){
        echo '<div class="alert alert-success alert-dismissible" role="alert">';
        echo '  <strong>Well done!</strong> You successfully sign up. Now <a href="LogIn.php" class="alert-link">log in</a>.';
        echo '</div>';
      }else{
        echo '<div class="alert alert-danger alert-dimissible" role="alert">';
        echo '  <strong>Error!</strong> This user already exists.';
        echo '</div>';
      }
    }
  }

?>
