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
                    <a class="dropdown-item" href="s_reviews.php">Reviews</a>
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

    <!-- Page Content -->
    <div class="page-heading about-heading header-text" style="background-image: url(assets/images/heading-6-1920x500.jpg);">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4></h4>
              <h2>Product Details</h2>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php
    // Connection to the server and database
    include("dbconn.php");

    // Check if a product ID is provided
    if (isset($_GET['productId'])) {
      $productId = $_GET['productId'];
      
      // Fetch the product details from the database
      $sql = "SELECT * FROM product p, seller s WHERE p.product_id = $productId";
      $result = mysqli_query($dbc, $sql);
      $row = mysqli_fetch_assoc($result);
    }
    ?>

    <div class="products">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <div class="product-item">
              <img src="data:image/png;base64,<?php echo base64_encode($row['product_photo']); ?>" alt="">
            </div>
          </div>
          <div class="col-md-8">
            <h2><?php echo $row['product_name']; ?></h2>
            <br>
            <p class="lead">
              <strong class="text-primary" >RM<?php echo $row['product_price']; ?></strong>
            </p><br>
            <p>
              <h6>
              <?php
                  if ($row['product_stock'] > 0) {
                      echo 'Stock: ' .$row['product_stock'];
                  } else {
                      echo 'Sold Out';
                  }
              ?>
              </h6>
            </p><br>
            <p>
              <h6>By: 
              <?php echo $row['seller_shop_name']; ?>
              </h6>
            </p><br>
        <?php 
            $rating_query = "SELECT AVG(r.review_rating) AS average_rating FROM review r  
                             INNER JOIN product p ON p.product_id = r.product_id
                             WHERE r.product_id = '$productId'";
            $rating_result = mysqli_query($dbc, $rating_query);
            $rating_row = mysqli_fetch_assoc($rating_result);
            $avg_rating = number_format($rating_row['average_rating'], 1);?>
            <p>
              <h6> 
              <?php echo $avg_rating; ?>⭐
              </h6>
            </p>
            <br><br><br>
            <p>
              <a href="#edit" class="filled-button">Edit</a>
            </p>
          </div>
        </div> 
        <div class="row">
          <div class="col-md-12">
            <br><h2 style="text-align: left; color: black;">Product Description:</h2><br>
            <h6 style="text-align: left; color: black;"><?php echo nl2br($row['product_description']); ?></h6>
            <br>
          </div>
        </div>

      

        <div class="row">
          <div class="col-md-12">
            <br><br>
            <br><h2 style="text-align: left; color: black;">Customer Reviews:</h2><br>
              <table class="table" align="center" border="0" style="overflow-x: auto; width: 100%;">
              <tr>
                    <th>Customer</th>
                    <th>Commment</th>
                    <th>Rating</th>
              </tr>
            <?php 
            $review_query = "SELECT * FROM review r  
                             INNER JOIN product p ON p.product_id = r.product_id
                             INNER JOIN customer c ON r.customer_id = c.customer_id
                             WHERE r.product_id = '$productId'";
            $review_result = mysqli_query($dbc, $review_query);
            while ($row = mysqli_fetch_assoc($review_result)) {
              echo '              <tr>
                  <td>'.$row['customer_name'].'</td>
                  <td>'.$row['review_comment'].'</td>
                  <td>'.$row['review_rating'].'</td>
              </tr>
              ';
            }?></table>

          </a>
            <br>
          </div>
        </div>
        </div>
    </div>

            <?php
              
              // Fetch the product details from the database
              $sql = "SELECT * FROM product p, seller s WHERE p.product_id = $productId";
              $result = mysqli_query($dbc, $sql);
              $row = mysqli_fetch_assoc($result);
            
            ?>

      <a id="edit"></a>
      <div class="products call-to-action">
      <div class="container">
        <h1>Edit Product Details:</h1>
        <div class="inner-content">
          <div class="contact-form">
              <form name="product" method="post" action="s_product_details_update_process.php" enctype="multipart/form-data">
                   <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <h4 align="left"> Product Name: </h4>
                          <fieldset>
                            <input name="name" type="text" class="form-control" id="name" value="<?php echo $row['product_name']; ?>" maxlength="50" required="">
                          </fieldset>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <h4 align="left"> Product Description: </h4>
                          <fieldset>
                            <textarea name="description" type="text" class="form-control" id="description" maxlength="1000" required=""><?php echo $row['product_description']; ?></textarea>
                          </fieldset>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <h4 align="left"> Product Price: </h4>
                          <fieldset>
                            <input name="price" type="number" class="form-control" value="<?php echo $row['product_price']; ?>" id="price" required="">
                          </fieldset>
                        </div>
                        
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <h4 align="left"> Product Stock: </h4>
                          <fieldset>
                            <input name="stock" type="number" class="form-control" id="stock" min="1" value="<?php echo $row['product_stock']; ?>" required="">
                          </fieldset>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <h4 align="left"> Product Photo: </h4>
                                <input align="control-label" type="file" name="image" accept="image/*" required />
                            </div>
                        </div>
                        <input type="hidden" name="productId" value="<?php echo $productId ?>">
                    </div>
                   <div class="clearfix">
                        <button type="submit" name="btnsubmit" class="btn btn-success pull-right">Update</button>
                   </div>
              </form>
          </div>
        </div>

        <br><br><br>
        <a href="s_page.php" class="filled-button">Home</a>
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
