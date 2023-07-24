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
                $s_id = $_GET['sellerId'];
                $ss_name = $_GET['sellerSName'];

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

    <div class="page-heading about-heading header-text" style="background-image: url(assets/images/heading-6-1920x500.jpg);">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4>Cart for</h4>
              <h2><?php echo $ss_name;?></h2>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="products call-to-action">
      <div class="container">
        <h1>Product of <?php echo $ss_name;?></h1><br>
        🟡 Pending     🟢 Verified    🔴 Rejected
        <div class="inner-content">
          <div class="table-responsive">
            <table class="table" align="center" border="0" style="overflow-x: auto; width: 100%;">
              <?php
                $cart_query = "SELECT cart_id FROM cart WHERE customer_id = '$c_id'";
                $cart_result = mysqli_query($dbc, $cart_query);
                $cart_row = mysqli_fetch_assoc($cart_result);
                $cart_id = $cart_row['cart_id'];
                $grandTotal = 0; // Initialize the variable

                // Retrieve orders and product details using JOIN
                $sql = "SELECT o.*, p.*
                        FROM `orders` o
                        INNER JOIN `product` p ON o.product_id = p.product_id
                        WHERE o.cart_id = '$cart_id'
                        AND p.seller_id = '$s_id'
                        AND (o.order_status = '🟡' OR o.order_status = '🟢' OR o.order_status = '🔴')";

                $order_result = mysqli_query($dbc, $sql);

                if ($order_result != NULL && mysqli_num_rows($order_result) > 0) {
                  echo '
                  <tr>
                    <th colspan="2">Product</th>
                    <th>Quantity</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Total(RM)</th>
                    <th colspan="2">Action</th>
                  </tr>';
                } else {
                  echo 'Your Cart is Empty';
                }

                $allVerified = true; // Flag to check if all statuses are verified

                while ($row = mysqli_fetch_assoc($order_result)) {
                  $total = $row['order_quantity'] * $row['product_price'];
                  $grandTotal = $grandTotal + $total;

                  // Check if the status is not verified
                  if ($row['order_status'] !== '🟢') {
                    $allVerified = false;
                  }

                  echo '
                  <tr>
                    <td><img src="data:image/jpeg;base64,' . base64_encode($row['product_photo']) . '" alt="Product Photo" style="width: 100px; height: auto;"></td>
                    <td>'.$row['product_name'].'</td>
                    <td>'.$row['order_quantity'].'</td>
                    <td style="white-space: nowrap;">['.$row['order_date'].']</td>
                    <td style="white-space: nowrap;">['.$row['order_time'].']</td>
                    <td>'.$row['order_status'].'</td>
                    <td>'.$total.'</td>
                    <td><a href="c_order_update_frm.php?orderId='.$row['order_id'].'&" class="btn btn-success" role="button" >Update</a></td>
                    <td><a href="c_order_delete_frm.php?orderId='.$row['order_id'].'" class="btn btn-danger" role="button">Delete</a></td>
                  </tr>';
                }
              ?>
            </table>
          </div>
        </div><br><br>
        <?php if ($order_result != NULL && mysqli_num_rows($order_result) > 0) { echo 'Total: RM'.$grandTotal.' <br><br>';} ?>
        <a href="c_orders_list.php" class="filled-button">Back</a>
        <?php if ($order_result != NULL && mysqli_num_rows($order_result) > 0 && $allVerified) { ?>
        <a href="c_orders_payment_frm.php?cartId=<?php echo $cart_id; ?>&&sellerId=<?php echo $s_id; ?>" class="filled-button">Checkout</a><?php }?>
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