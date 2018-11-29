<?php

  include '../Model/DB.php';
  include '../Model/Brick.php';
  include '../Model/User.php';
  include 'commonFunctions.php';
  include 'Settings.php';


  function main_controller(){
    session_start();
    sessionTimer();

    if(isset($_SESSION['username'])){
      $user = new user( $_SESSION['username'] );  // create user
    }else{
      header ( "Location: HomePage.php?msg=session_timeout");
    }

    if ($_SERVER ['REQUEST_METHOD'] === 'POST'
        && isset($_POST ['startRow'])
        && isset($_POST ['startCol'])
        && isset($_POST ['endRow'])
        && isset($_POST ['endCol'])) {

      $new_brick = new brick($_SESSION['username'], // create a new brick
                              $_POST ['startRow'],
                              $_POST ['startCol'],
                              $_POST ['endRow'],
                              $_POST ['endCol']);

      if($new_brick->checkConstraints()){  //check the specifications constraints
        $new_brick->store();
        header ( "Location: PersonalPage.php?msg=newBrick");
      }else{
        header( "Location: PersonalPage.php?msg=newBrick_err");
      }
    }else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      if (isset ( $_GET ["undo"] )) {
        $user->undo();
      }

    }


  }

  function renderTable(){
    global $table_rows;
    global $table_columns;
    global $brick_lenght;
    //2d matrix
    foreach (range(0,$table_rows) as $row) {
     foreach (range(0,$table_columns) as $col) {
      $matrix[$row][$col] = "W";
     }
    }


    // populate the table
    $bricks = retrieveBricks();
    if($bricks == -1){
      errorRedirector("can't retrive bricks");
    }

    foreach ($bricks as $key => $brick) {

      $flag = false;
      if(isset($_SESSION['username']) && $brick->owner == $_SESSION['username']) $flag = true;


      if($brick->startRow == $brick->endRow){
        for($i = 0; $i < $brick_lenght; $i++){
          if($flag){
            $matrix[$brick->startRow][$brick->startColumn+$i] = "G";
          }else{
              $matrix[$brick->startRow][$brick->startColumn+$i] = "X";
          }

        }
      }else if($brick->startColumn == $brick->endColumn){
        for($i = 0; $i < $brick_lenght; $i++){
          if($flag){
            $matrix[$brick->startRow+$i][$brick->startColumn] = "G";
          }else{
            $matrix[$brick->startRow+$i][$brick->startColumn] = "X";
          }
        }
      }
    };


    echo "<table id='table'>";
    for($i=0; $i<$table_rows ; $i++){
      echo "<tr>";
      for($j=0; $j<$table_columns; $j++){
            echo
            ("<td row='"
             .$i
             ."' col='"
             .$j
             ."' class='"
             . $matrix[$i][$j]
             ."' id='"
             .$i."-".$j
             ."'></td>"
            );
      }
      echo "</tr>";
    }
    echo "</table>";




  }

  function checkParam(){
    if (isset ( $_GET ["msg"] )) {
      $mex = urldecode ( $_GET ["msg"] );
      $mex = _sanitize($mex);
      if($mex == 'newBrick'){
        echo '<div class="alert alert-success alert-dismissible" role="alert">';
        echo '  <strong>Ok!</strong> New brick created correctly.';
        echo '</div>';
      }else if($mex == 'newBrick_err'){
        echo '<div class="alert alert-danger alert-dismissible" role="alert">';
        echo '  <strong>Error!</strong> The brick does not fit the constraints.';
        echo '</div>';
      }else if($mex == 'undo'){
        echo '<div class="alert alert-success alert-dismissible" role="alert">';
        echo '  <strong>Ok!</strong> Brick correctly destroyed.';
        echo '</div>';
      }else if($mex == 'no_res'){
        echo '<div class="alert alert-warning alert-dismissible" role="alert">';
        echo '  <strong>Warning!</strong> There are no bricks to destroy.';
        echo '</div>';
      }
    }
  }
 ?>
