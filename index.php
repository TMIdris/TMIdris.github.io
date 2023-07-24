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

    <title>UniStore | Home</title>

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
              <li class="nav-item active">
                <a class="nav-link" href="index.php">Home
                  <span class="sr-only">(current)</span>
                </a>
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

                // Check if the alert session variable is set
                if (isset($_SESSION['alert'])) {
                    // Output the alert message
                    echo $_SESSION['alert'];

                    // Unset the alert session variable to remove it from subsequent page loads
                    unset($_SESSION['alert']);
                }

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
    <!-- Banner Starts Here -->
    <div class="banner header-text">
      <div class="owl-banner owl-carousel">
        <div class="banner-item-01">
          <div class="text-content">
            <h4>Quality Product</h4>
            <h2>From The Students</h2>
          </div>
        </div>
        <div class="banner-item-02">
          <div class="text-content">
            <h4>Easy</h4>
            <h2>Order and Delivery</h2>
          </div>
        </div>
        <div class="banner-item-03">
          <div class="text-content">
            <h4>Secure</h4>
            <h2>Payment</h2>
          </div>
        </div>
      </div>
    </div>
    <!-- Banner Ends Here -->



    <!-- <div class="container2">
      <div class="row2">
        <div class="column2"></div>
        <div class="column2"></div>
        <div class="column2"></div>
        <div class="column2"></div>
      </div>
    </div>-->

    <div class="latest-products">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Featured Products</h2>
              <a href="products.php">view more <i class="fa fa-angle-right"></i></a>
            </div>
          </div>
          <?php
            $sql = "SELECT * FROM product";
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



    <div class="best-features">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>About Us</h2>
            </div>
          </div>
          <div class="col-md-6">
            <div class="left-content">
              <p>As students from UITM Jasin, we have developed this innovative app to facilitate convenient purchasing for students from outside of the campus. Our goal is to help students save time and allow them to focus more on their studies by eliminating the need to leave campus for everyday items. Moreover, this app aims to foster an entrepreneurial spirit among UITM Jasin students, encouraging them to pursue successful entrepreneurship ventures.<br><br>Here are some key features of our apps: </p>
              <ul class="featured-list">
                <li><a>Seamless ordering</a></li>
                <li><a>Fast delivery</a></li>
                <li><a>Secured customer information</a></li>
                <li><a>Entrepreneurship opportunities</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-6">
            <div class="right-image">
              <img src="assets/images/about-1-570x350.jpg" alt="">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="services" style="background-image: url(assets/images/other-image-fullscren-1-1920x900.jpg);" >
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2><h2>Latest blog posts</h2>
            </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <div class="service-item">
              <a href="#" class="services-item-image"><img src="assets/images/food1.jpg" class="img-fluid" alt=""></a>

              <div class="down-content">
                <h4><a href="https://hafidzridzwan.wordpress.com/2012/06/02/tempat-tempat-makan-anda-harus-singgah-jika-anda-pelajar-uitm-lendu-alor-gajah-melaka/">Tempat makan terbaik Uitm Lendu</a></h4>

                <p style="margin: 0;"> Hafidzrizwan &nbsp;&nbsp;|&nbsp;&nbsp; makanan terbaik &nbsp;&nbsp;|&nbsp;&nbsp; 2019</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="service-item">
              <a href="#" class="services-item-image"><img src="assets/images/food4.jpg" class="img-fluid" alt=""></a>

              <div class="down-content">
                <h4><a href="https://says.com/my/seismik/kedai-makan-bajet-untuk-students">Makana murah di Uitm Shah Alam</a></h4>

                <p style="margin: 0;"> Sifulan &nbsp;&nbsp;|&nbsp;&nbsp; Kehidupan pelajar kolej &nbsp;&nbsp;|&nbsp;&nbsp; 2017</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="service-item">
              <a href="#" class="services-item-image"><img src="assets/images/food5.jpg" class="img-fluid" alt=""></a>

              <div class="down-content">
                <h4><a href="https://farisidzwan.blogspot.com/2019/02/uitm-kampus-raub-pahang.html">Perantaun mencari makan</a></h4>

                <p style="margin: 0;"> Faris Idzwan &nbsp;&nbsp;|&nbsp;&nbsp; Roommate sejati &nbsp;&nbsp;|&nbsp;&nbsp; 2019</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="happy-clients">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Happy Clients</h2>
            </div>
          </div>
          <div class="col-md-12">
            <div class="owl-clients owl-carousel text-center">
              <div class="service-item">
                <div class="icon">
                  <i class="fa fa-user"></i>
                </div>
                <div class="down-content">
                  <h4>Ali Imran</h4>
                  <p class="n-m"><em>"This remarkable Unistore has truly revolutionized my shopping experience, making purchasing items an absolute breeze. I cannot recommend it enough to fellow Uitm students who are looking for a seamless and convenient way to shop. Prepare to be amazed and enjoy the incredible benefits this store offers!"</em></p>
                </div>
              </div>
              
              <div class="service-item">
                <div class="icon">
                  <i class="fa fa-user"></i>
                </div>
                <div class="down-content">
                  <h4>Aqief Daniel</h4>
                  <p class="n-m"><em>"When it comes to delivery, the Unistore surpasses all expectations with its impeccable punctuality. My parcels arrived right on schedule, leaving me thoroughly impressed and eager to utilize this platform again for all my essential shopping needs. Prepare to be amazed by their outstanding timeliness and experience the convenience firsthand!"</em></p>
                </div>
              </div>
              
              <div class="service-item">
                <div class="icon">
                  <i class="fa fa-user"></i>
                </div>
                <div class="down-content">
                  <h4>Afiq Osman</h4>
                  <p class="n-m"><em>"The Unistore offers a wide variety of products that are perfect for students. From basic necessities to delicious snacks, it has everything you need. Shopping on this app brings me immense joy and convenience. Experience the happiness of finding all your essentials in one place"</em></p>
                </div>
              </div>
              
            </div>
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