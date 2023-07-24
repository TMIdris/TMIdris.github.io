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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

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

    <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
                <li class="nav-item lh-1 me-3">
                  <a
                    class="github-button"
                    href="https://github.com/themeselection/sneat-html-admin-template-free"
                    data-icon="octicon-star"
                    data-size="large"
                    data-show-count="true"
                    aria-label="Star themeselection/sneat-html-admin-template-free on GitHub"
                    >Star</a
                  >
                </li>
    </ul>

    <div class="page-heading about-heading header-text" style="background-image: url(assets/images/heading-6-1920x500.jpg);">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4>All</h4>
              <h2>Products</h2>
            </div>
          </div>
        </div>
      </div>
    </div><br><br>

      <?php
      // Assuming you have already established a database connection ($dbc)


      // Check if a search query is present
      if (isset($_GET['query'])) {
          $searchQuery = $_GET['query'];
          // Modify the SQL query to filter by the search query
          $sql = "SELECT * FROM product WHERE product_name LIKE '%$searchQuery%'";
      } else {
          $sql = "SELECT * FROM product";
      }

      $result = mysqli_query($dbc, $sql);
      ?>

      <!-- Add the search form -->
      <form action="" method="GET">
        <input type="text" name="query" placeholder="Search products" 
        style=" width: 50%;
                padding: 1px 5px;
                margin: 8px 0;
                box-sizing: border-box;">
        <button type="submit" ><i class="fas fa-search"></i></button>
      </form>

      <div class="products">
        <div class="container">
          <div class="row">
            <?php
              $result = mysqli_query($dbc, $sql);
              while ($row = mysqli_fetch_assoc($result)) {
                $productId = $row['product_id'];
                $rating_query = "SELECT AVG(r.review_rating) AS average_rating FROM review r  
                                 INNER JOIN product p ON p.product_id = r.product_id
                                 WHERE r.product_id = '$productId'";
                $rating_result = mysqli_query($dbc, $rating_query);
                $rating_row = mysqli_fetch_assoc($rating_result);
                $avg_rating = number_format($rating_row['average_rating'], 1);
            ?>
            <div class="col-md-4">
              <div class="product-item">
                <div class="card">
                  <?php if (isset($_SESSION['id'])) { // Check if user is logged in ?>
                    <a href="c_order_product.php?productId=<?php echo $row['product_id']; ?>">
                  <?php } else { // User not logged in ?>
                    <a href="login.php?productId=<?php echo $row['product_id']; ?>">
                  <?php } ?>
                      <img src="data:image/png;base64,<?php echo base64_encode($row['product_photo']); ?>" alt="">
                    </a>
                    <div class="down-content">
                      <a href="c_order_product.php?productId=<?php echo $row['product_id']; ?>">
                        <h4><?php echo $row['product_name']; ?></h4>
                      </a>
                      <h5>RM <?php echo $row['product_price']; ?></h5>
                    </div>
                    <table border="0" align="center" style="overflow-x: auto; width: 80%;">
                      <tr>
                        <td align="left"><h6><?php echo $row['product_sold']; ?>&nbsp; sold</h6></td>
                        <td align="right"><h6><?php echo $avg_rating; ?> ⭐</h6></td>
                      </tr>
                    </table><br>
                  </div>
                </div>
              </div>
              <?php
                }
              ?>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
  </body>

</html>
