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

              <li class="nav-item"><a class="nav-link" href="products.php">Products</a>

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

                // Check if the alert session variable is set
                if (isset($_SESSION['alert'])) {
                    // Output the alert message
                    echo $_SESSION['alert'];

                    // Unset the alert session variable to remove it from subsequent page loads
                    unset($_SESSION['alert']);
                }

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

    <br>
    
    <?php
    // Connection to the server and database
    include("dbconn.php");

    // Check if a product ID is provided
    if (isset($_GET['orderId'])) {
      $o_id = $_GET['orderId'];
      
      // Fetch the product details from the database
      $sql = "SELECT * FROM orders o, product p WHERE o.product_id = p.product_id AND o.order_id = '$o_id'";
      $result = mysqli_query($dbc, $sql);
      $row = mysqli_fetch_assoc($result);
    }
    ?>

    <div class="products call-to-action">
      <div class="container"><br>
        <h1>Update order</h1>
        <div class="inner-content">
          <div class="contact-form">
              <form name="order" method="post" action="c_order_update_process.php?orderId=<?php echo $row['order_id'];?>&productId=<?php echo $row['product_id'];?>&orderQuantity=<?php echo $row['order_quantity'];?>">
                   <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <h4 align="left"> Product Name: </h4>
                          <fieldset>
                            <input name="pname" type="text" class="form-control" id="pname" value="<?php echo $row['product_name']; ?>" disabled>
                          </fieldset>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                          <h4 align="left"> Product Stock: </h4>
                          <fieldset>
                            <input name="pstock" type="text" class="form-control" id="pstock" value="<?php echo $row['product_stock']; ?>" disabled>
                          </fieldset>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                          <h4 align="left"> New Order Quantity: </h4>
                          <fieldset>
                            <input name="newOrderQuantity" type="number" class="form-control" id="newOrderQuantity" min="1" max="<?php echo $row['product_stock']; ?>" required="">
                          </fieldset>
                        </div>
                    </div>
                   <div class="clearfix">
                        <a href="javascript:history.go(-1)" class="btn btn-info">Back</a>
                        <button type="submit" name="btnsubmit" class="btn btn-success">Update</button>
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
