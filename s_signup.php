<!DOCTYPE html>
<html lang="en">

  <head>

    <script src="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js
    "></script>
    <link href="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css
    " rel="stylesheet">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>UniStore | Seller</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/style_seller.css">
    <link rel="stylesheet" href="assets/css/owl.css">

  

  </head>

  <body>

    <!-- ** Preloader Start ** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ** Preloader End ** -->

    <!-- Header -->
    <header class="">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <a class="navbar-brand" href="seller.php"><h2>UniStore Seller Center<em></em></h2></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item active">
                <a class="nav-link" href="seller.php">Your Shop
                  <span class="sr-only">(current)</span>
                </a>
              </li> 

              <li class="nav-item"><a class="nav-link" href="s_products.php">All Your Products</a></li>

              <?php
              include("dbconn.php");
              session_start();
              if (isset($_SESSION['name']) && isset($_SESSION['id'])) {
                // Retrieve customer name and image using session values
                $c_id = $_SESSION['id'];

                // Check if the alert session variable is set
                if (isset($_SESSION['alert'])) {
                    // Output the alert message
                    echo $_SESSION['alert'];

                    // Unset the alert session variable to remove it from subsequent page loads
                    unset($_SESSION['alert']);
                }



                $sql = "SELECT * FROM customer c 
                        INNER JOIN seller s ON c.customer_id = s.customer_id
                        WHERE s.customer_id = '$c_id' 
                        GROUP BY s.customer_id";
                $results = mysqli_query($dbc, $sql);
                $row = mysqli_fetch_assoc($results);//dah tau row
                $s_id = $row['seller_id'];
                $sql = "SELECT * FROM seller
                        WHERE seller_id = '$s_id'";
                $results = mysqli_query($dbc, $sql);
                $row = mysqli_fetch_assoc($results);
                ?>

                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <?php echo $row['seller_shop_name']; ?>
                  </a>

                  <div class="dropdown-menu">
                    <!-- Dropdown menu options for the logged-in customer -->
                    <a class="dropdown-item" href="s_profile.php">Seller Profile</a>
                    <a class="dropdown-item" href="s_orders.php">Orders</a>
                    <a class="dropdown-item" href="s_delivery.php">Delivery</a>
                    <a class="dropdown-item" href="index.php">Customer Page</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                  </div>
                </li>
              <?php
              } else {
                // If not logged in, show the login and register links
                ?>
                <li class="nav-item"><a class="nav-link" href="login_signup.php">Login / Sign Up</a></li>
              <?php
              }
              ?>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    
     <div class="page-heading about-heading header-text" style="background-image: url(assets/images/heading-6-1920x500.jpg);">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4></h4>
              <h2>Seller Sign Up</h2>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="products call-to-action">
      <div class="container">
        <h1>Seller Profile</h1>
        <div class="inner-content">
          <div class="contact-form">
              <form name="seller" method="post" action="s_signup_process.php">
                   <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <h4 align="left"> Seller Name: </h4>
                          <fieldset>
                            <input name="name" type="text" class="form-control" id="name" value="<?php echo $row['seller_name']; ?>" required="">
                          </fieldset>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <h4 align="left"> Seller Shop Name: </h4>
                          <fieldset>
                            <input name="shopname" type="text" class="form-control" id="shopname" value="<?php echo $row['seller_shop_name']; ?>" required="">
                          </fieldset>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <h4 align="left"> Seller Email: </h4>
                          <fieldset>
                            <input name="email" type="text" class="form-control" id="email" value="<?php echo $row['seller_email']; ?>" required="">
                          </fieldset>
                        </div>
                        
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <h4 align="left"> Seller Contact Number: </h4>
                          <fieldset>
                            <input name="contact" type="text" class="form-control" id="contact" value="<?php echo $row['seller_contact']; ?>" required="">
                          </fieldset>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <h4 align="left"> Seller Bank Name: </h4>
                          <fieldset>
                            <input name="bank" type="text" class="form-control" id="bank" value="<?php echo $row['seller_bank']; ?>" required="">
                          </fieldset>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <h4 align="left"> Seller Bank Account Number: </h4>
                          <fieldset>
                            <input name="account" type="text" class="form-control" id="account" value="<?php echo $row['seller_account']; ?>" required="">
                          </fieldset>
                        </div>
                    </div>
                   <div class="clearfix">
                        <button type="Reset" name="btnback" class="btn btn-info pull-left">Back</button>
                        <button type="submit" name="btnsubmit" class="btn btn-info pull-right">Done</button>
                   </div>
              </form>
          </div>
        </div>
      </div>
    </div>

    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="inner-content">
              <p>Copyright © 2023 UniStore</p>
            </div>
          </div>
        </div>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- Additional Scripts -->
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/owl.js"></script>
  </body>
</html>