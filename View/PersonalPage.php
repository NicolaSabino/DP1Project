<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>B r i c k s</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"> <!-- BOOTSTRAP -->
    <link rel="stylesheet" type="text/css" href="css/Table.css"> <!-- TABLE -->
    <link rel="stylesheet" type="text/css" href="css/PersonalPage.css"> <!-- PERSONAL PAGE -->
    <link rel="stylesheet"href="css/shop-item.css" > <!-- TEMPLATE -->
  </head>

  <body>
    <?php
      include '../Control/PersonalPage_controller.php';
      // manage the page in the controller
      main_controller();
    ?>
    <!-- Bootstrap navbar with responsive configuration -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">B r i c k s</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse"
        data-target="#navbarResponsive" aria-controls="navbarResponsive"
        aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active"> <!-- empty link -->
              <a class="nav-link" href="">
                Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item"> <!-- empty link -->
              <a class="nav-link disabled" href="">
                Log In
              </a>
            </li>
            <li class="nav-item"> <!-- empty link -->
              <a class="nav-link disabled" href="">
                Sign Up
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
      <div class="row"> <!-- place elements in a row -->
        <div class="col-sm-3"> <!-- FIRST ELEMENT, log-alert and side navbar with enabled commands -->
          <br>
          <div class="alert alert-secondary" role="alert"> <!-- LOG ALERT -->
              Welcome back
              <br>
              <small><u>
              <?php
                if(isset($_SESSION['username'])){
                  echo $_SESSION['username'];
                }else{
                  echo "Unknown";
                }
               ?>
             </u></small>
          </div> <!-- END LOG ALERT -->
          <div class="list-group"> <!-- COMMANDS -->
            <a href="#" id="new-shape" data-toggle="tooltip" title="Insert a new brick in the table"
            class="list-group-item  list-group-item-action ">New  brick</a>
            <a href="PersonalPage.php?undo=''" data-toggle="tooltip" title="Deleate the last Brick stored in the table"
            class="list-group-item list-group-item-action ">Undo</a>
            <a href="../Control/LogOut_controller.php" data-toggle="tooltip" title="Terminate the session"
            class="list-group-item list-group-item-action ">Log Out</a>
          </div> <!-- END COMMANDS -->
          <br>
          <div class="alert alert-primary hide-item" role="alert"> <!-- INSTRUCTION ALERT, initially hidden -->
              <small>Pleas select the start and the end block</small>
              <hr>
              <small>Abort to exit</small>
          </div> <!-- END INSTRUCTION ALERT -->
          <br>
          <div class="list-group hide-item"> <!-- ABORT COMMAND, initially hidden -->
            <a id="abort" class="list-group-item list-group-item-action">Abort</a>
          </div> <!-- END ABORT -->
          <br>
          <div class="list-group hide-item"> <!-- SUBMIT COMMAND, initially hidden -->
            <a id="submit" onclick="document.getElementById('sub_form').submit();"
            style="display: none;"class="list-group-item  list-group-item-action ">Submit</a>
          </div> <!-- END SUBMIT -->
        </div> <!-- END FIRST ELEMENT -->
        <div class="col-sm-9"> <!-- SECOND ELEMENT -->
          <?php
           renderTable(); // fill the page with the table
           checkParam(); // check if the are messages inside the url (GET)
           ?>

           <div id="alert_placeholder"></div> <!-- dynamic alerts generated through javascript -->
           <noscript> <!-- if javascript is disabled alert the user -->
             <div class="alert alert-warning" role="alert">
                 <strong>Warning!</strong> Javascript disabled. Some componets may not work properly.
             </div>
           </noscript>

           <!-- HIDDEN FORM filled by javascript -->
           <form id="sub_form" action="PersonalPage.php" method="POST">
              <input id="startRow" name="startRow" class="hidden-input">
              <input id="startCol" name="startCol" class="hidden-input">
              <input id="endRow" name="endRow" class="hidden-input">
              <input id="endCol" name="endCol" class="hidden-input">
            </form>
            <!-- END FORM -->
        </div> <!-- END SECOND ELEMENT -->
      </div> <!-- END THE ROW -->
    </div> <!-- END THE PAGE CONTAINER -->

    <!-- javascript -->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/PersonalPage.js"></script>
    <script>

      // when a user click the `new-shape` button
      // show the instruction alert and the abort commands
      // (The `submit` button must remain hidden)
      $( "#new-shape" ).click(function() {
          $( ".hide-item").show();
          $( "#new-shape" ).addClass("list-group-item-info"); // mark the cell
          clickable(); // allow the click operation in the table
      });

      // when a user click the `abort` button
      // hide the instruction alert, the submit button
      // and the abort button itself.
      $( "#abort").click(function(){
        $( ".hide-item").hide();
        $( "#submit").hide();
        $( "#new-shape" ).removeClass("list-group-item-info"); // unmark the cell
        nonClickable(); // deny the click operation in the table
      });

      // automaticcaly close  bottom aletrs after 6 seconds
      window.setTimeout(function() {
        $(".alert").not(".alert-primary").not(".alert-secondary").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
      }, 6000);

    </script>
  </body>
</html>
