<!DOCTYPE html>
<html lang="en">

  <head>

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

                $sql = "SELECT * FROM customer c 
                        INNER JOIN seller s ON c.customer_id = s.customer_id
                        WHERE s.customer_id = '$c_id' 
                        GROUP BY s.customer_id";
                $results = mysqli_query($dbc, $sql);
                $row = mysqli_fetch_assoc($results);//dah tau row
                $s_id = $row['seller_id'];
                ?>

                <li class="nav-item dropdown active">
                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <?php echo $row['seller_shop_name']; ?><span class="sr-only">(current)</span>
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
              <h2>Orders for</h2>
              <h2><?php echo $row['seller_shop_name']; ?></h2>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="products call-to-action">
      <div class="container">
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
                $sql = "SELECT *
                        FROM `orders` o
                        INNER JOIN `product` p ON o.product_id = p.product_id
                        WHERE p.seller_id = '$s_id' 
                        AND (o.order_status = '🟡' OR o.order_status = '🟢' OR o.order_status = '🔴')
                        GROUP BY o.order_id"; 

                        

                $order_result = mysqli_query($dbc, $sql);

                if ($order_result != NULL && mysqli_num_rows($order_result) > 0) {
                  echo '
                  <tr>
                    <th colspan="2">Product</th>
                    <th>Quantity</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Update</th>
                    <th colspan="2">Action</th>
                  </tr>';
                } else {
                  echo 'Your Orders is Empty';
                }

                /*$allVerified = true; // Flag to check if all statuses are verified*/

                while ($row = mysqli_fetch_assoc($order_result)) {
                  $total = $row['order_quantity'] * $row['product_price'];
                  $grandTotal = $grandTotal + $total;

                  // Check if the status is not verified
                  /*if ($row['order_status'] !== '🟢') {
                    $allVerified = false;
                  }*/

                  echo '
                  <form name="order" method="post" action="s_orders_update_process.php">
                  <tr>
                    <td><img src="data:image/jpeg;base64,' . base64_encode($row['product_photo']) . '" alt="Product Photo" style="width: 100px; height: auto;"></td>
                    <td>'.$row['product_name'].'</td>
                    <td>'.$row['order_quantity'].'</td>
                    <td style="white-space: nowrap;">['.$row['order_date'].']</td>
                    <td style="white-space: nowrap;">['.$row['order_time'].']</td>
                    <td>RM'.$total.'</td>
                    <td style="white-space: nowrap;">'.$row['order_status'].'</td>
                    <td> 
                      <select name="status" id="status" required="">
                        <option value="">------</option>
                        <option value="🟡" class="yellow">Pending</option>
                        <option value="🟢" class="green">Verified</option>
                        <option value="🔴" class="red">Rejected</option>
                      </select>
                    </td>
                    <input type="hidden" name="orderId" value="'.$row['order_id'].'">
                    <td>
                        <button type="submit" class="btn btn-success">Update</button>
                    </td>
                    
                    
                  </tr></form>';
                }
              ?>

            </table>
          </div>
        </div><br><br>
       
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