<!DOCTYPE html>
<html lang="en">

  <head>


  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" rel="stylesheet">

  <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <link rel="stylesheet" type="text/css" href="assets/css/print.css" media="print">









  </head>

  <body>
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
    $p_id = $_GET['payId'];

  }

    date_default_timezone_set('Asia/Kuala_Lumpur');

    //$cart_query = "SELECT cart_id FROM cart WHERE customer_id = '$c_id'";
    //$cart_result = mysqli_query($dbc, $cart_query);
    //$cart_row = mysqli_fetch_assoc($cart_result);
    //$cart_id = $cart_row['cart_id'];

    // get payment id latest

    $payment_query = "SELECT *
                      FROM payment 
                      WHERE payment_id= '$p_id'";
    $payment_result = mysqli_query($dbc, $payment_query);
    $payment_row = mysqli_fetch_assoc($payment_result);
    $method = $payment_row['payment_method'];
    $pay_date = $payment_row['payment_date'];
    $pay_time = $payment_row['payment_time'];

    /*

    $seller_query = "SELECT * FROM seller s INNER JOIN customer c
                     WHERE c.customer_id = '$c_id'";
    $seller_result = mysqli_query($dbc, $seller_query);
    $seller_row = mysqli_fetch_assoc($seller_result);
    $s_id = $payment_row['seller_id'];*/

    $grandTotal = 0.00; // Initialize the variable
    $totalWithShipping = 0.00;
    $shipping = 3.00;
    


    ?>



    
    <div class="products call-to-action">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <div class="invoice-title">
            <h2>Receipt</h2>
            <h3 class="pull-right">Payment Id: # <?php echo $p_id ?></h3>
          </div>
          <hr>
          <div class="row">
            <div class="col-xs-12 col-sm-6">
              <address>
                <strong>Billed To:</strong><br>

                <?php 

                    $seller_sql = "SELECT *
                            FROM seller s
                            JOIN product p ON s.seller_id = p.seller_id
                            JOIN orders o ON p.product_id = o.product_id
                            WHERE o.order_status = '$p_id'";
                    $seller_results = mysqli_query($dbc, $seller_sql);
                    $seller_row = mysqli_fetch_assoc($seller_results);
                    $s_id = $seller_row['seller_id'];
                    $s_name = $seller_row['seller_name'];
                    $s_shop = $seller_row['seller_shop_name'];
                    echo $s_name.' - Seller <br> ';
                    echo $s_shop.' - Shop <br> ';
                  ?>
              </address>
            </div>
            <div class="col-xs-12 col-sm-6 text-right">
              <address>
                <strong>Shipped To:</strong><br>
                <?php $sql = "SELECT * FROM payment WHERE payment_id = $p_id";
                      $results = mysqli_query($dbc, $sql);
                      $row = mysqli_fetch_assoc($results);
                      $cust_id = $row['customer_id'];
                      $sql = "SELECT * FROM customer WHERE customer_id = $cust_id";
                      $results = mysqli_query($dbc, $sql);
                      $row = mysqli_fetch_assoc($results);
                      ?>
                <?php echo $row['customer_name']?><br>
                <?php echo nl2br($row['customer_address'])?>
              </address>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-6">
              <address>
                <strong>Payment Method:</strong><br>
                <?php echo $method ?>
              </address>
            </div>
            <div class="col-xs-12 col-sm-6 text-right">
              <address>
                <strong>Payment Date:</strong><br>
                <?php echo ''.$pay_date.'  '.$pay_time.'' ?>  <br><br>
              </address>
            </div>
          </div>
        </div>
      </div>
    
      <div class="row">
        <div class="col-xs-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><strong>Order summary</strong></h3>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-condensed">
                  <thead>
                    <tr>
                      <td><strong>Product</strong></td>
                      <td class="text-center"><strong>Price</strong></td>
                      <td class="text-center"><strong>Quantity</strong></td>
                      <td class="text-right"><strong>Total</strong></td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    // Retrieve orders and product details using JOIN
                    $receipt_sql = "SELECT o.*, p.*, c.*, pa.*
                                    FROM `orders` o
                                    INNER JOIN `product` p ON o.product_id = p.product_id
                                    INNER JOIN `cart` c ON c.cart_id = o.cart_id
                                    INNER JOIN `payment` pa ON pa.cart_id = c.cart_id
                                    WHERE p.seller_id = '$s_id'
                                    AND o.order_status = '$p_id'
                                    AND pa.customer_id = '$c_id'
                                    GROUP BY o.order_id";

                    $receipt_results = mysqli_query($dbc, $receipt_sql);
                    $grandTotal = 0;

                    while ($row = mysqli_fetch_assoc($receipt_results)) {
                      $total = $row['order_quantity'] * $row['product_price'];
                      $grandTotal += $total;
                      $totalWithShipping = $grandTotal + $shipping;
                      $formattedPrice = number_format($row['product_price'], 2);
                      $formattedTotal = number_format($total, 2);

                      echo '
                      <tr>
                        <td>'.$row['product_name'].'</td>
                        <td class="text-center">'.$formattedPrice.'</td>
                        <td class="text-center">'.$row['order_quantity'].'</td>
                        <td class="text-right">'.$formattedTotal.'</td>
                      </tr>';
                    }
                    ?>
                    <tr>
                      <td class="thick-line"></td>
                      <td class="thick-line"></td>
                      <td class="thick-line text-center"><strong>Subtotal</strong></td>
                      <td class="thick-line text-right"><?php echo number_format($grandTotal, 2); ?></td>
                    </tr>
                    <tr>
                      <td class="no-line"></td>
                      <td class="no-line"></td>
                      <td class="no-line text-center"><strong>Shipping</strong></td>
                      <td class="no-line text-right"><?php echo number_format($shipping, 2); ?></td>
                    </tr>
                    <tr>
                      <td class="no-line"></td>
                      <td class="no-line"></td>
                      <td class="no-line text-center"><strong>Total</strong></td>
                      <td class="no-line text-right">RM<?php echo number_format($totalWithShipping, 2); ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <button align="center" class="filled-button" onclick="window.print();" id="print-btn">Print Invoice</button><br><br>

      </div>
    </div>
          

      

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- Additional Scripts -->
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/owl.js"></script>

  </body>
</html>