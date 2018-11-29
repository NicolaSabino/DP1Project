<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>B r i c k s</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"> <!-- BOOTSTRAP -->
    <link rel="stylesheet" type="text/css" href="css/Table.css">  <!-- TABLE -->
    <link rel="stylesheet"href="css/shop-item.css" >  <!-- TEMPLATE -->
  </head>

  <body>

    <?php
      include '../Control/HomePage_controller.php';
      include '../Control/commonFunctions.php';
      // manage the page in the controller
      main_controller();
    ?>

    <!-- Bootstrap navbar with responsive configuration -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">B r i c k s</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto"> <!-- links in the navbar -->
            <li class="nav-item active"> <!-- empty link -->
              <a class="nav-link" href="">
                Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item"> <!-- move to the log in page -->
              <a class="nav-link" href="LogIn.php">Log In</a>
            </li>
            <li class="nav-item"> <!-- move to the Sign up page -->
              <a class="nav-link" href="SignUp.php">Sign Up</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
      <div class="row"> <!-- place elements in a row -->
        <div class="col-sm-3"> <!-- FIRST ELEMENT, side navbar with disabled commands -->
          <br>
          <div class="list-group">
            <a href="" class="list-group-item disabled">New brick</a>
            <a href="" class="list-group-item disabled">Undo</a>
            <a href="" class="list-group-item disabled">Log Out</a>
          </div>
        </div> <!-- END FIRST ELEMENT -->

        <div class="col-sm-9"> <!-- SECOND ELEMENT, table and custom alerts -->
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

        </div><!-- END SECOND ELEMENT -->
      </div> <!-- END THE ROW -->

    </div> <!-- END THE PAGE CONTAINER -->

    <!-- javascript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
    // automaticcaly close bottom aletrs after 6 seconds
    window.setTimeout(function() {
      $(".alert").not(".alert-primary").not(".alert-secondary").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove();
      });
    }, 6000);
    </script>
  </body>
</html>
