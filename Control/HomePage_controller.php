<?php

  include '../Model/DB.php';
  include '../Model/Brick.php';
  include 'Settings.php';

  function main_controller(){
      // nothing to do
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
      if($brick->startRow == $brick->endRow){
        for($i = 0; $i < $brick_lenght; $i++){
          $matrix[$brick->startRow][$brick->startColumn+$i] = "X";
        }
      }else if($brick->startColumn == $brick->endColumn){
        for($i = 0; $i < $brick_lenght; $i++){
          $matrix[$brick->startRow+$i][$brick->startColumn] = "X";
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
             ."'class='"
             . $matrix[$i][$j]
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
      if($mex == 'session_end'){
        echo '<div class="alert alert-success alert-dismissible" role="alert">';
        echo '  <strong>Ok!</strong> Session ended correctly.';
        echo '</div>';
      }else if($mex == 'session_timeout'){
        echo '<div class="alert alert-danger alert-dismissible" role="alert">';
        echo '  <strong>Error!</strong> Session timeout. Please <a href="LogIn.php">log in</a>.';
        echo '</div>';
      }
    }
  }
