<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>My simple game</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/Table.css">
    <link rel="stylesheet" type="text/css" href="css/Error.css">
    <link rel="stylesheet"href="css/shop-item.css" >

  </head>

  <body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">B r i c k s </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="HomePage.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="LogIn.php">Log In</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="SignUp.php">Sign Up</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">

      <div class="row">

        <div class="col-sm-3">
          <br>
          <div class="list-group">
            <a href="#" class="list-group-item disabled">New Shape</a>
            <a href="#" class="list-group-item disabled">Undo</a>
            <a href="#" class="list-group-item disabled">Log Out</a>
          </div>
        </div>
        <!-- /.col-sm-3 -->

        <div class="col-sm-9">
          <div class="error-template">
                  <h1 style="color:red;">An error occours</h1>
                  <div class="error-details">
                    <?php
                    if(isset($_GET["msg"])){
                      $errorMessage = urldecode ( $_GET ["msg"] );
                      $errorMessage = strip_tags ( $errorMessage);     // sanitizing the message
                      $errorMessage = htmlentities ( $errorMessage );  // sanitizing the message
                      echo $errorMessage;
                    }
                    ?>
                  </div>
              </div>
        </div>
        <!-- /.col-lg-9 -->

      </div>

    </div>
    <!-- /.container -->

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>

  </body>

</html>
