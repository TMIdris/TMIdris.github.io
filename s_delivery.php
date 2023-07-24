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
              <li class="nav-item">
                <a class="nav-link" href="seller.php">Your Shop
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

                <li class="nav-item dropdown active">
                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <?php echo $row['seller_shop_name']; ?>
                  <span class="sr-only">(current)</span>
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
              <h2><?php echo $row['seller_shop_name']; ?></h2>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Payment join delivery, payment id, -->
    <!-- Column: Payment_id, delivery date time status (, payment status (pay,) 

                    $sql = "SELECT d.*, p.*
                        FROM `delivery` d
                        INNER JOIN `payment` p ON p.payment_id = d.payment_id
                        WHERE p.customer_id = '$c_id'
                        ORDER BY p.payment_date AND p.payment_time DESC";

                      -->

    <div class="products call-to-action">
      <div class="container">
        <h1>Delivery Detail</h1><br>
        🟠 Unchecked Payment Proof <br><br>🟡 Shipping 🔵 Delivery  🟢 Delivered    🔴 Cancelled
        <div class="inner-content">
          <div class="table-responsive">
            <table class="table" align="center" border="0" style="overflow-x: auto; width: 100%;">
              <?php
                // Retrieve orders and product details using JOIN
                $sql = "SELECT s.*, p.*, o.*, c.*, pa.*, d.*
                        FROM `seller` s
                        INNER JOIN `product` p ON p.seller_id = s.seller_id
                        INNER JOIN `orders` o ON o.product_id = p.product_id
                        INNER JOIN `cart` c ON c.cart_id = o.cart_id
                        INNER JOIN `payment` pa ON pa.cart_id = c.cart_id
                        INNER JOIN `delivery` d ON d.payment_id = pa.payment_id
                        WHERE p.seller_id = '$s_id'
                        GROUP BY pa.payment_id
                        ORDER BY pa.payment_id DESC";

                $order_result = mysqli_query($dbc, $sql);

                if ($order_result != NULL && mysqli_num_rows($order_result) > 0) {
                  echo '
                  <tr>
                    <th>PayId</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th colspan="2">Action</th>
                  </tr>';
                } else {
                  echo 'Your Delivery List is Empty';
                }

                $allVerified = true; // Flag to check if all statuses are verified

                while ($row = mysqli_fetch_assoc($order_result)) {
                      if($row['delivery_status'] != 'Received' ){
                        if($row['payment_method'] != 'Online Banking'){
                        echo '
                        <form name="order" method="post" action="s_delivery_update_process.php">
                        <tr>
                          <td>'.$row['payment_id'].'</td>
                          <td>RM'.$row['payment_amount'].'<br><a href="receipt.php?payId='.$row['payment_id'].'" target="_blank">Receipt<a></td>
                          <td>'.$row['payment_method'].'</td>
                          <td>'.$row['delivery_address'].'</td>
                          <td>'.$row['delivery_status'].'</td>
                          <td> 
                            <select name="status" id="status" required="">
                              <option value="">------</option>
                              <option value="🟠" class="orange">Uncheck</option>
                              <option value="🟡" class="yellow">Shipping</option>
                              <option value="🔵" class="blue">Delivery</option>
                              <option value="🟢" class="green">Delivered</option>
                              <option value="🔴" class="red">Cancelled</option>
                            </select>
                          </td>
                          <input type="hidden" name="deliveryId" value="'.$row['delivery_id'].'">
                          <td><button type="submit" class="btn btn-success">Update</button></td>
                        </tr></form>';}
                        else{
                        echo '
                        <form name="order" method="post" action="s_delivery_update_process.php">
                        <tr>
                          <td>'.$row['payment_id'].'</td>
                          <td>RM'.$row['payment_amount'].'<br><a href="receipt.php?payId='.$row['payment_id'].'" target="_blank">Receipt<a></td>
                          <td>'.$row['payment_method'].'<br><a href="proof.php?payId='.$row['payment_id'].'" target="_blank">Proof<a></td>
                          <td>'.$row['delivery_address'].'</td>
                          <td>'.$row['delivery_status'].'</td>

                          <td> 
                            <select name="status" id="status" required="">
                              <option value="">------</option>
                              <option value="🟠" class="orange">Uncheck</option>
                              <option value="🟡" class="yellow">Shipping</option>
                              <option value="🔵" class="blue">Delivery</option>
                              <option value="🟢" class="green">Delivered</option>
                              <option value="🔴" class="red">Cancelled</option>
                            </select>
                          </td>
                          <input type="hidden" name="deliveryId" value="'.$row['delivery_id'].'">
                          <td><button type="submit" class="btn btn-success">Update</button></td>
                        </tr></form>';}
                      }else
                      {
                      /*echo '
                      <tr>
                        <td>'.$row['payment_id'].'</td>
                        <td>RM'.$row['payment_amount'].'</td>
                        <td>'.$row['payment_method'].'</td>
                        <td>'.$row['delivery_address'].'</td>
                        <td>'.$row['delivery_status'].'</td>
                        <td>
                        </td>
                      </tr>';*/
                      }
                    }
              ?>
              
            </table>
          </div>
        </div>
      </div>
    </div>


    <div class="products call-to-action">
      <div class="container">
        <h1>All Received Orders</h1>
        <div class="inner-content">
          <div class="table-responsive">
            <table class="table" align="center" border="0" style="overflow-x: auto; width: 100%;">
              <?php
                // Retrieve orders and product details using JOIN
                $sql = "SELECT *
                        FROM `delivery` d
                        INNER JOIN `payment` pa ON d.payment_id = pa.payment_id
                        INNER JOIN `cart` c ON pa.cart_id = c.cart_id
                        INNER JOIN `orders` o ON o.cart_id = c.cart_id
                        INNER JOIN `product` p ON o.product_id = p.product_id
                        INNER JOIN `seller` s ON s.seller_id = p.seller_id
                        GROUP BY pa.payment_id
                        ORDER BY pa.payment_id DESC";

                $order_result = mysqli_query($dbc, $sql);
                //<th>Action</th><td><a href="c_orders_received_list_info.php?deliveryId='.$row['delivery_id'].'&&payId='.$row['payment_id'].'&&sellerId='.$row['seller_id'].'" class="btn btn-info" role="button">View Product</a></td>
                if ($order_result != NULL && mysqli_num_rows($order_result) > 0) {
                  echo '
                  <tr>
                    <th>PayId</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Address</th>
                    <th>Status</th>
                  </tr>';
                } else {
                  echo 'Your Delivered List is Empty';
                }


                while ($row = mysqli_fetch_assoc($order_result)) {
                  $deliveryStatus = $row['delivery_status'];
                  if($deliveryStatus == 'Received'){
                  echo '
                  <tr>
                    <td>'.$row['payment_id'].'</td>
                    <td>RM'.$row['payment_amount'].'<br><a href="receipt.php?payId='.$row['payment_id'].'" target="_blank">Receipt<a></td>
                    <td>'.$row['payment_method'].'</td>
                    <td>'.$row['delivery_address'].'</td>
                    <td>'.$row['delivery_status'].'</td>
                  </tr>';}
                    else{
                    }
                }
              ?>
            </table>
          </div>
        </div><br>
        <a href="products.php" class="filled-button">Back</a>
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