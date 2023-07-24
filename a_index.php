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
    <link rel="stylesheet" href="assets/css/style_admin.css">
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
                  <a class="dropdown-item" href="logout.php">Logout</a>
                  <a class="dropdown-item" href="about_us.php">About Us</a>
                  <a class="dropdown-item" href="terms.php">Terms</a>
                </div>
              </li>


              <?php
              include("dbconn.php");
              session_start();
              if (isset($_SESSION['a_name']) && isset($_SESSION['a_id'])) {
                // Retrieve customer name and image using session values
                $a_id = $_SESSION['a_id'];
                
                if (isset($_SESSION['alert'])) {
                    // Output the alert message
                    echo $_SESSION['alert'];

                    // Unset the alert session variable to remove it from subsequent page loads
                    unset($_SESSION['alert']);
                }

                $sql = "SELECT * FROM admin WHERE admin_id = $a_id";
                $results = mysqli_query($dbc, $sql);
                $row = mysqli_fetch_assoc($results);}
                ?>
            </ul>
          </div>
        </div>
      </nav>
    </header>
   <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Search..."
                    aria-label="Search..."
                  />
                </div>
              </div>
              <!-- /Search -->

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

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block">John Doe</span>
                            <small class="text-muted">Admin</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <i class="bx bx-cog me-2"></i>
                        <span class="align-middle">Settings</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <span class="d-flex align-items-center align-middle">
                          <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                          <span class="flex-grow-1 align-middle">Billing</span>
                          <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="auth-login-basic.html">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <div class="col-lg-8 mb-4 order-0">
                  <div class="card">
                    <div class="d-flex align-items-end row">
                      <div class="col-sm-7">
                        <div class="card-body">
                          <h5 class="card-title text-primary">Welcome Admin 🎉</h5>
                          <p class="mb-4">
                           this is your dashboard fill with some summary for admin report 
                          </p><br><br>

                          
                        </div>
                      </div>
                      <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                          <img
                            src="assets/img/illustrations/man-with-laptop-light.png"
                            height="140"
                            alt="View Badge User"
                            data-app-dark-img="illustrations/man-with-laptop-dark.png"
                            data-app-light-img="illustrations/man-with-laptop-light.png"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


                <?php 
                $sql = "SELECT sum(product_sold*product_price) AS totalsales
                        FROM product ";
                $result = mysqli_query($dbc, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                $totalsales = $row['totalsales'];
                }?>

                <?php
                 $sql = "SELECT *,count(seller_id) AS total_seller
                FROM seller";
                $result = mysqli_query($dbc, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                $totalseller= $row['total_seller'];
                }?>

                <?php
                 $sql = "SELECT *,count(customer_id) AS total_customer
                FROM customer";
                $result = mysqli_query($dbc, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                $totalcustomer= $row['total_customer'];
                }?>

                <?php 
                $sql = "SELECT *, COUNT(order_id) AS total_order,SUM(order_quantity) AS total_quantity FROM orders";
                $result = mysqli_query($dbc, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                $totalorder = $row['total_order'];
                $totalquantity = $row['total_quantity'];
                }?>

              
                <?php
                 $sql = "SELECT *,count(payment_id) AS total_payment,Sum(payment_amount) AS total_payment_amount
                FROM payment";
                $result = mysqli_query($dbc, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                $totalpayment = $row['total_payment'];
                $totalpaymentamount = $row['total_payment_amount'];
                }?>

                <?php
               $sql = "SELECT *,count(delivery_id) AS total_delivery
                FROM delivery";
                $result = mysqli_query($dbc, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                 $totaldelivery=$row['total_delivery'];
                 }?>

                  <?php
                 $sql = "SELECT *,count(payment_id) AS cod_payment
                FROM payment
                WHERE payment_method='Cash on Delivery' ";
                $result = mysqli_query($dbc, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                $codpayment = $row['cod_payment'];
                }?>

                <?php
                 $sql = "SELECT *,count(payment_id) AS BA_payment
                FROM payment
                WHERE payment_method='Online Banking' ";
                $result = mysqli_query($dbc, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                $BApayment = $row['BA_payment'];
                }?>

                <div class="col-lg-4 col-md-4 order-1">
                  <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <img
                                src="assets/img/icons/unicons/chart-success.png"
                                alt="chart success"
                                class="rounded"
                              />
                            </div>
                            <div class="dropdown">
                              <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt3"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                              </div>
                            </div>
                          </div>
                          <span class="fw-semibold d-block mb-1">Total Order</span>
                          <h3 class="card-title mb-2"><?php echo $totalorder ?></h3>
                          <small class="text-success fw-semibold"><br></small>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <img
                                src="assets/img/icons/unicons/wallet-info.png"
                                alt="Credit Card"
                                class="rounded"
                              />
                            </div>
                            <div class="dropdown">
                              <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt6"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                              </div>
                            </div>
                          </div>
                          <span>Total Payment (RM)</span>
                          <h3 class="card-title text-nowrap mb-1"> RM<?php echo $totalpaymentamount ?></h3>
                          <small class="text-success fw-semibold"><br></small>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Total Revenue -->
                <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                  <div class="card">
                    <div class="row row-bordered g-0">
                      <div class="col-md-8">
                        <div class="card-body">
                          <h5 class="card-title text-primary">Sales Summary</h5>
                          <p class="mb-4">
                             <p><span class="fw-bold">Total Sales: </span>RM <?php echo $totalsales ?>
                             </p>
                             <p><span class="fw-bold"> Total Seller: </span><?php echo $totalseller ?>
                             </p>
                             <p><span class="fw-bold"> Total Customer: </span><?php echo $totalcustomer ?>
                             </p>
                            <p><span class="fw-bold">Cash on delivery Payments: </span><?php echo $codpayment ?>                            </p>
                            <p><span class="fw-bold"> Online Banking Payments: </span><?php echo $BApayment ?>
                            </p>
                            
                      

                          <br>
                          <a onclick="window.print();" id="print-btn", class="btn btn-sm btn-outline-primary" >Print</a>
                        </div>
                        
                      </div>




                      <div class="col-md-4">
                        <div class="card-body">
                          <div class="text-center">
                            <div class="dropdown">
                              <br>

                              <h5 class="card-title text-primary">1.Select Report Date</h5> 
                              <br>
                              <form name="datefrm" method="POST" action="a_report_print.php">

                              <input name="date" type="date" id="date">

                              </form>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportId">
                                <br><br><br>
                                <a class="dropdown-item" href="javascript:void(0);"></a>
                                
                              </div>
                              <br><br><br><br>
                              <h5 class="card-title text-primary">2.Select Button to<br> view Report</h5>
                            </div>
                          </div>
                        </div>
                      
                        <div class="text-center fw-semibold pt-3 mb-2"><a type='button' id="report", class="btn btn-sm btn-outline-primary" >View Report</a></div>
                        
                          <br><br><br>                
                        </div>
                    </div>
                  </div>
                </div>



                <script>
                  document.getElementById("report").addEventListener("click", function() {
                      Swal.fire({
                          title: "Are you sure?",
                          text: "",
                          icon: "warning",
                          showCancelButton: true,
                          confirmButtonText: "Yes",
                          cancelButtonText: "No",
                          reverseButtons: true
                      }).then(function(result) {
                          if (result.value) {
                              // Submit the form
                              document.forms["datefrm"].submit();
                          } else if (result.dismiss === "cancel") {
                              Swal.fire(
                                  "Cancelled",
                                  "",
                                  "error"
                              )
                          }
                      });
                  });
                </script>


                <!--/ Total Revenue -->
                <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
                  <div class="row">
                    <div class="col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <img src="assets/img/icons/unicons/paypal.png" alt="Credit Card" class="rounded" />
                            </div>
                            <div class="dropdown">
                              <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt4"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                              </div>
                            </div>
                          </div>
                          <span class="d-block mb-1">Total Payments</span>
                          <h3 class="card-title text-nowrap mb-2"><?php echo $totalpayment ?></h3>
                          <small class="text-danger fw-semibold"><br></small>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <img src="assets/img/icons/unicons/delivery-truck.png" alt="Delivery Card" class="rounded" />
                            </div>
                            <div class="dropdown">
                              <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt1"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                              </div>
                            </div>
                          </div>
                          <span class="fw-semibold d-block mb-1">Total Delivery</span>
                          <h3 class="card-title mb-2"><?php echo $totaldelivery ?></h3>
                          <small class="text-success fw-semibold"><br></small>
                        </div>
                      </div>
                    </div>
                    <!-- </div>
    <div class="row"> -->
                    <div class="col-12 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                            <br>
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                              <div class="card-title">

                               
                              </div>
                              <div class="mt-sm-auto">
                                 <h5 class="text-nowrap mb-2">Total Customer</h5>
                                <h3 class="card-title mb-2"><?php echo $totalcustomer ?></h3>
                             <br><br><br>
                              </div>
                            </div>
                            <div id="profileReportChart"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <footer>
            <div class="inner-content">
              <p>Copyright © 2023 UniStore</p>
            </div>
         </footer>
            <!-- / Content -->

           

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->



    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    


    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- Additional Scripts -->

    <script src="assets/js/custom.js"></script>
    <script src="assets/js/owl.js"></script>

  </body>
</html>