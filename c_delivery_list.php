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
              <h4>Orders</h4>
              <h2>Delivery</h2>
            </div>
          </div>
        </div>
      </div>
    </div>    

    <!-- Payment join delivery, payment id, -->
    <!-- Column: Payment_id, delivery date time status (, payment status (pay,) -->

    <div class="products call-to-action">
      <div class="container">
        <h1>All Delivery Details</h1><br>
        🟠 Checking Payment  🟡 Shipping 🔵 Delivery  🟢 Delivered    🔴 Cancelled
        <div class="inner-content">
          <div class="table-responsive">
            <table class="table" align="center" border="0" style="overflow-x: auto; width: 100%;">
              <?php
                // Retrieve orders and product details using JOIN
                $sql = "SELECT d.*, p.*
                        FROM `delivery` d
                        INNER JOIN `payment` p ON p.payment_id = d.payment_id
                        WHERE p.customer_id = '$c_id'
                        ORDER BY p.payment_date AND p.payment_time DESC";

                $order_result = mysqli_query($dbc, $sql);

                if ($order_result != NULL && mysqli_num_rows($order_result) > 0) {
                  echo '
                  <tr>
                    <th>PayId</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th colspan="2">Confirmation</th>
                  </tr>';
                } else {
                  echo 'Your Delivery List is Empty';
                }

                $allVerified = true; // Flag to check if all statuses are verified

                while ($row = mysqli_fetch_assoc($order_result)) {
                  $deliveryStatus = $row['delivery_status'];
                  if ($deliveryStatus !== '🟢') {
                    $disableReceivedButton = 'true';
                  } else {
                    $disableReceivedButton = '';
                  }
                  if ($deliveryStatus !== 'Received')
                  {
                    if ($disableReceivedButton)
                    {
                      echo '
                      <tr>
                        <td>'.$row['payment_id'].'</td>
                        <td>RM'.$row['payment_amount'].'<br><a href="c_receipt.php?payId='.$row['payment_id'].'" target="_blank">Receipt<a></td>
                        <td>'.$row['payment_method'].'</td>
                        <td>'.$row['delivery_address'].'</td>
                        <td>'.$deliveryStatus.'</td>
                        <td><button class="btn btn-success" role="button" disabled>Received</button></td>
                      </tr>';}
                      else{
                      echo '
                      <tr>
                        <td>'.$row['payment_id'].'</td>
                        <td>RM'.$row['payment_amount'].'<br><a href="c_receipt.php?payId='.$row['payment_id'].'" target="_blank">Receipt<a></td>
                        <td>'.$row['payment_method'].'</td>
                        <td>'.$row['delivery_address'].'</td>
                        <td>'.$deliveryStatus.'</td>
                        <td><button class="btn btn-success" role="button" onclick="redirectToProcess('.$row['payment_id'].')">Received</button></td>
                      </tr>
                      <script>
                        function redirectToProcess(payId) {
                          window.location.href = "c_order_receive_process.php?payId=" + '.$row['payment_id'].';
                        }
                      </script>';
                      }//<td><a href="c_order_info_frm.php?orderId='.$row['payment_id'].'" class="btn btn-info" role="button">Info</a></td>
                  }
                  else{}
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