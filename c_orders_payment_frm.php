<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>UniStore | Cart</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/owl.css">

    <!-- Post without form -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  </head>

  <body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <header class="">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <a class="navbar-brand" href="index.php"><h2>UniStore <em></em></h2></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
              </li> 

              <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">More</a>
                
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="about_us.php">About Us</a>
                  <a class="dropdown-item" href="terms.php">Terms</a>
                </div>
              </li>


              <?php
              include("dbconn.php");
              session_start();
              if (isset($_SESSION['name']) && isset($_SESSION['id'])) {
                // Retrieve customer name and image using session values
                $c_id = $_SESSION['id'];
                $s_id = $_GET['sellerId'];

                $cart_query = "SELECT cart_id FROM cart WHERE customer_id = '$c_id'";
                $cart_result = mysqli_query($dbc, $cart_query);
                $cart_row = mysqli_fetch_assoc($cart_result);
                $cart_id = $cart_row['cart_id'];

                $sql = "SELECT * FROM customer WHERE customer_id = $c_id";
                $results = mysqli_query($dbc, $sql);
                $row = mysqli_fetch_assoc($results);
                ?>

                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle active" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <?php echo $row['customer_name']; ?>
                  </a><span class="sr-only">(current)</span>

                  <div class="dropdown-menu">
                    <!-- Dropdown menu options for the logged-in customer -->
                    <a class="dropdown-item" href="c_profile.php">Profile</a>
                    <a class="dropdown-item" href="c_orders_list.php">Cart</a>
                    <a class="dropdown-item" href="c_orders_notifications.php">Notifications</a>
                    <a class="dropdown-item" href="c_delivery_list.php">Delivery Details</a>
                    <a class="dropdown-item" href="c_orders_received_list.php">Received Orders</a>
                    <a class="dropdown-item" href="seller.php">Seller Center</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                  </div>
                </li>
              <?php
              } else {
                // If not logged in, show the login and register links
                ?>
                <li class="nav-item active"><a class="nav-link" href="login.php">Login / Sign Up</a><span class="sr-only">(current)</span></li>
              <?php
              }
              ?>
            </ul>
          </div>
        </div>
      </nav>
    </header>

    <br><br><br><br>

    <div class="products call-to-action">
      <div class="container" style="max-width: 450px; margin: 0 auto;">
        <h1>Payment Details</h1><br>
        🟡 Pending     🟢 Verified    🔴 Rejected
        <div class="inner-content">
          <div class="contact-form">
            <form name="customer" method="post" action="c_orders_payment_process.php">
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <h4 align="left"> Address: </h4>
                  <fieldset>
                    <textarea name="address" type="text" class="form-control" id="address" disabled><?php echo $row['customer_address']; ?></textarea>
                    <a href="c_profile.php" class="pull-right">Edit address</a><br>
                  </fieldset><br>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <h4 align="left">Payment Method:</h4>
                  <fieldset>
                    <select name="method" type="text" class="form-control" id="payment-method" placeholder="---" required="">
                      <option value="">---</option>
                      <option value="Online Banking">Online Banking</option>
                      <option value="Cash on Delivery">Cash on Delivery</option>
                    </select>
                  </fieldset>
                  <input type="hidden" name="sellerId" value="<?php echo $s_id; ?>">
                  <input type="hidden" name="cartId" value="<?php echo $cart_id; ?>">
                </div>
              </div><br>

              <div class="clearfix">
                <a href="c_orders_list.php" class="filled-button pull-left" style="width: 100%;">Back</a>
                <button type="submit" name="btnsubmit" id="nextButton" class="filled-button pull-left" style="width: 100%;">Next</button><br><br>
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