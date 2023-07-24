<!DOCTYPE html>
<html lang="en">

  <head>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" rel="stylesheet">

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

              // Check if the alert session variable is set
              if (isset($_SESSION['alert'])) {
                  // Output the alert message
                  echo $_SESSION['alert'];

                  // Unset the alert session variable to remove it from subsequent page loads
                  unset($_SESSION['alert']);
              }

              if (isset($_SESSION['name']) && isset($_SESSION['id'])) {
                // Retrieve customer name and image using session values
                $c_id = $_SESSION['id'];
                $pay_id = $_GET['payId'];
                $s_id = $_GET['sellerId'];

                // Get payment details
                $payment_query = "SELECT *
                                  FROM payment p
                                  JOIN cart c ON p.cart_id = c.cart_id
                                  WHERE p.payment_id = '$pay_id'";
                $payment_result = mysqli_query($dbc, $payment_query);
                $payment_row = mysqli_fetch_assoc($payment_result);
                $amount = $payment_row['payment_amount'];

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
    <?php

    $sql = "SELECT * FROM seller WHERE seller_id = '$s_id'";
    $results = mysqli_query($dbc, $sql);
    $row = mysqli_fetch_assoc($results);

    ?>

    <div class="products call-to-action">
      <div class="container" style="max-width: 450px; margin: 0 auto;">
        <h1>Online Payment</h1>
        <div class="inner-content">
          <div class="contact-form">
              <form name="customer" method="post" action="c_orders_payment_approval_process.php" enctype="multipart/form-data">
                   <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <h4 align="left">Total amount to be paid:</h4>
                        <fieldset>
                          <input name="name" type="text" class="form-control" id="name" value="RM <?php echo $amount; ?>" required="" disabled>
                        </fieldset>
                      </div>
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <h4 align="left">Billed to:</h4>
                        <fieldset>
                          <input name="name" type="text" class="form-control" id="name" value="<?php echo $row['seller_shop_name']; ?>" required="" disabled>
                        </fieldset>
                      </div>
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <h4 align="left">Seller Bank Name:</h4>
                        <fieldset>
                          <input name="name" type="text" class="form-control" id="name" value="<?php echo $row['seller_bank']; ?>" required="" disabled>
                        </fieldset>
                      </div>
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <h4 align="left">Seller Bank Account Number:</h4>
                        <fieldset>
                          <input name="name" type="text" class="form-control" id="name" value="<?php echo $row['seller_account']; ?>" required="" disabled>
                        </fieldset>
                      </div>
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <h4 align="left">Payer Account No:</h4>
                        <fieldset>
                          <input name="account" type="text" class="form-control" id="account" placeholder="account no" required="">
                        </fieldset>
                      </div>
                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <div class="form-group">
                            <h4 align="left"> Payment prove (Online Banking Receipt)</h4>
                              <input align="control-label" type="file" name="image" accept="image/*" required />
                          </div>
                      </div>
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <h4 align="left">Remaining Time:</h4>
                        <p id="timer"></p>
                      </div>
                    <!-- Hidden input field for payId -->
                    <input type="hidden" name="payId" value="<?php echo $pay_id; ?>">
                    </div>
                <div class="clearfix">
                <button type="submit" name="btnsubmit" id="nextButton" class="filled-button pull-left" style="width: 100%;">Next</button><br><br>
              </div>
              </form>
          </div>
        </div>
      </div>
    </div>

    <script>
    // Timer function
    function startTimer(duration, redirectUrl) {
      var timer = duration;
      var timerElement = document.getElementById("timer");

      setInterval(function () {
        var minutes = Math.floor(timer / 60);
        var seconds = timer % 60;

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        timerElement.innerHTML = minutes + ":" + seconds;

        timer--;

        if (timer < 0) {
          // Timer expired, redirect to another page
          window.location.href = redirectUrl;
        }
      }, 1000); // 1 second interval
    }

    // Start the timer when the page loads
    window.onload = function () {
      var duration = 5 * 60; // 5 minutes in seconds
      var redirectUrl = "index.php"; // Replace with the URL of the other page
      startTimer(duration, redirectUrl);
    };
  </script>



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