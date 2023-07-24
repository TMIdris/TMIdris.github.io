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
                <li class="nav-item active"><a class="nav-link" href="login.php">Login / Sign Up</a><span class="sr-only">(current)</span></li>
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
              <h4>Add</h4>
              <h2>Review and Rating</h2>
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
          </div>
        </div> 
        <div class="row">
          <div class="col-md-12">
            <br><h2 style="text-align: left; color: black;">Product Description:</h2><br>
            <h6 style="text-align: left; color: black;"><?php echo nl2br($row['product_description']); ?></h6>
            <br>
          </div>
        </div>
      </div>
    </div>
    <?php

    $review_sql = "SELECT * FROM review r 
                   INNER JOIN customer c ON r.customer_id = c.customer_id 
                   WHERE c.customer_id = $c_id
                   AND r.product_id = $productId";

    $review_result = mysqli_query($dbc, $review_sql);

    $row = mysqli_fetch_assoc($review_result);

    
    ?>  

    <div class="products call-to-action">
      <div class="container">
        <h1>Write your review and leave your rating here!</h1>
        <div class="inner-content">
          <div class="contact-form">
              <form name="review" method="post" action="c_product_review_process.php">
                   <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <h4 align="left"> Comments: </h4>
                          <fieldset>
                            <textarea name="comment" type="text" class="form-control" id="comment" placeholder="Write review here" required=""><?php if ($review_result = !NULL && mysqli_num_rows($review_result) > 0){echo $row['review_comment'];}?></textarea>
                          </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <h4 align="left"> Star Rating: </h4>
                              <style>
                                .rating {
                                  margin-top: 5px;
                                  border: none;
                                  float: left;
                                }

                                .rating > label {
                                  color: #90A0A3;
                                  float: right;
                                }

                                .rating > label:before {
                                  margin: 5px;
                                  font-size: 2em;
                                  font-family: FontAwesome;
                                  content: "\f005";
                                  display: inline-block;
                                }

                                .rating > input {
                                  display: none;
                                }

                                .rating > input:checked ~ label,
                                .rating:not(:checked) > label:hover,
                                .rating:not(:checked) > label:hover ~ label {
                                  color: #F79426;
                                }

                                .rating > input:checked + label:hover,
                                .rating > input:checked ~ label:hover,
                                .rating > label:hover ~ input:checked ~ label,
                                .rating > input:checked ~ label:hover ~ label {
                                  color: #FECE31;
                                }
                              </style>
                              <div class="rating">
                                <input type="radio" id="star5" name="rating" value="5" />
                                <label class="star" for="star5" title="Awesome" aria-hidden="true"></label>
                                <input type="radio" id="star4" name="rating" value="4" />
                                <label class="star" for="star4" title="Great" aria-hidden="true"></label>
                                <input type="radio" id="star3" name="rating" value="3" />
                                <label class="star" for="star3" title="Very good" aria-hidden="true"></label>
                                <input type="radio" id="star2" name="rating" value="2" />
                                <label class="star" for="star2" title="Good" aria-hidden="true"></label>
                                <input type="radio" id="star1" name="rating" value="1" />
                                <label class="star" for="star1" title="Bad" aria-hidden="true"></label>
                              </div>
                              <br><br><br><br><br>
                        </div>
                    </div>
                    <input type="hidden" name="productId" value="<?php echo $productId; ?>">
                   <div class="clearfix">
                        <a href="c_product_review_delete_process.php?productId=<?php echo $productId ?>" class="btn btn-danger">Delete</a>
                        <button type="button" name="btnback" class="btn btn-info pull-left" onclick="window.open('c_orders_received_list.php')">Back</button>
                        <button type="button" class="btn btn-success pull-right" id="confirm">Submit</button>
                   </div>
              </form>
          </div>
        </div>
      </div>
    </div>

    <script>
    document.getElementById("confirm").addEventListener("click", function() {
        Swal.fire({
            title: "Are you sure?",
            text: "This comment will be public!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, submit it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                // Submit the form
                document.forms["review"].submit();
            } else if (result.dismiss === "cancel") {
                Swal.fire(
                    "Cancelled",
                    "Update cancelled :)",
                    "error"
                )
            }
        });
    });
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
