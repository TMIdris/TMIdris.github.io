<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/images/favicon.ico">

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>UniStore | Products</title>

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

              <li class="nav-item active"><a class="nav-link" href="products.php">Products</a><span class="sr-only">(current)</span></li>

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

                $sql = "SELECT * FROM customer WHERE customer_id = $c_id";
                $results = mysqli_query($dbc, $sql);
                $row = mysqli_fetch_assoc($results);
                ?>

                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <?php echo $row['customer_name']; ?>
                  </a>

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
                <li class="nav-item"><a class="nav-link" href="login.php">Login / Sign Up</a></li>
              <?php
              }
              ?>
            </ul>
          </div>
        </div>
      </nav>
    </header>

    <!-- Page Content -->
    <br><br><br>

    <?php
    // Connection to the server and database
    include("dbconn.php");

    // Check if a product ID is provided
    if (isset($_GET['productId'])) {
      $productId = $_GET['productId'];
      
      // Fetch the product details from the database
      $sql = "SELECT * FROM product WHERE product_id = $productId";
      $result = mysqli_query($dbc, $sql);
      $row = mysqli_fetch_assoc($result);
    }
    ?>

    <div class="products call-to-action">
      <div class="container" style="max-width: 600px; margin: 0 auto;">
        <h1>Order Form</h1>
        <div class="inner-content">
          <div class="contact-form">
              <form name="order" method="post" action="c_order_product_process.php?productId=<?php echo $row['product_id']; ?>">
                   <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <h4 align="left"> Product Name: </h4>
                          <fieldset>
                            <input name="pname" type="text" class="form-control" id="pname" value="<?php echo $row['product_name']; ?>" disabled>
                          </fieldset>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <h4 align="left"> Product Price: </h4>
                          <fieldset>
                            <input name="pprice" type="text" class="form-control" id="pprice" value="RM<?php echo $row['product_price']; ?>" disabled>
                          </fieldset>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                          <h4 align="left"> Product Stock: </h4>
                          <fieldset>
                            <input name="pstock" type="text" class="form-control" id="pstock" value="<?php echo $row['product_stock']; ?>" disabled>
                          </fieldset>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                          <h4 align="left"> Order Quantity: </h4>
                          <fieldset>
                            <input name="pqtty" type="number" class="form-control" id="pqtty" placeholder="<?php echo $row['product_stock']; ?>" min="1" max="<?php echo $row['product_stock']; ?>" required="">
                          </fieldset>
                        </div>
                    </div>
                   <div class="clearfix">
                        <a href="c_order_product.php?productId=<?php echo $row['product_id']; ?>" class="filled-button">Back</a>
                        <button type="submit" name="btnsubmit" class="filled-button">Add to cart</button>
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
