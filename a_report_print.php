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
      if (isset($_SESSION['a_name']) && isset($_SESSION['a_id'])) {
        // Retrieve customer name and image using session values
        $a_id = $_SESSION['a_id'];}
        
        
        if (isset($_SESSION['alert'])) {
            // Output the alert message
            echo $_SESSION['alert'];

            // Unset the alert session variable to remove it from subsequent page loads
            unset($_SESSION['alert']);
        }

    $report_date = $_POST['date'];

    date_default_timezone_set('Asia/Kuala_Lumpur');

    // get payment id latest


    $grandTotal = 0.00; // Initialize the variable
    $totalWithShipping = 0.00;
    $shipping = 3.00;
    $totalOrder = 0;
    $totalProduct = 0;
    $totalSales = 0.0;





                  ?>
                <?php 
                /*
                $sql = "SELECT *, COUNT(order_id) AS total_order,SUM(order_quantity) AS total_quantity FROM orders";
                $result = mysqli_query($dbc, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                $totalorder = $row['total_order'];
                $totalquantity = $row['total_quantity'];}

                $sql = "SELECT sum(product_sold*product_price) AS totalsales
                        FROM product ";
                $result = mysqli_query($dbc, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                $totalsales = $row['totalsales'];}

                 $sql = "SELECT *,count(payment_id) AS total_payment,Sum(payment_amount) AS total_payment_amount
                FROM payment";
                $result = mysqli_query($dbc, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                $totalpayment = $row['total_payment'];
                $totalpaymentamount = $row['total_payment_amount'];}

               $sql = "SELECT *,count(delivery_id) AS total_delivery
                FROM delivery";
                $result = mysqli_query($dbc, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                 $totaldelivery=$row['total_delivery'];}

                 $sql = "SELECT *,count(seller_id) AS total_seller
                FROM seller";
                $result = mysqli_query($dbc, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                $totalseller= $row['total_seller'];
                }*/?>






    
    <div class="products call-to-action">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <div class="invoice-title">
            <h2 align="middle" >Report Summary</h2>
      <br>
          </div>
        </div>
      </div>
    
      <div class="row">
        <div class="col-xs-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title" align="middle"><strong> Report date: <?php echo $report_date ?>  </strong></h3>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-condensed">
                  <thead>
                    <tr>
                      <td ><strong>Seller Id</strong></td>
                      <td class="text-center"><strong>Seller Name</strong></td>
                      <td class="text-center"><strong>Total Order</strong></td>
                      <td class="text-center"><strong>Total Product</strong></td>
                      
                    </tr>
                  </thead>
                <?php

                // Retrieve orders and product details using JOIN 
                //<td class="text-right"><strong>Latest Total Sales</strong></td>
                //sum(DISTINCT p.product_sold*p.product_price) AS totalsales
                //$totalSales = $totalSales + $row['totalsales'];
                //<td class="text-right">'.number_format($row['totalsales'], 2).'</td>
                //<td class="text-right"><strong><?php echo number_format($totalSales, 2) </strong></td>

                /*$sql = "SELECT *
                        FROM `orders` o
                        INNER JOIN `product` p ON o.product_id = p.product_id
                        WHERE o.cart_id = '$cart_id'
                        AND p.seller_id = '$s_id'
                        AND o.order_status != 'payment'
                        AND o.order_status != 'checeked out'";*/
                        //sum(pa.payment_amount) as totalpaymentamount,count( DISTINCT d.delivery_id) as totaldelivery,sum(DISTINCT p.product_sold*p.product_price) AS totalsales,count(DISTINCT o.order_id) as totalorder
                        //count(DISTINCT p.product_sold) as totalsold, $totalSold = $totalSold + $row['totalsold']; <td class="text-center">'.$row['totalsold'].'</td>
                $sql = "SELECT *,  
                sum(DISTINCT pa.payment_amount) as totalpaymentamount,
                count(DISTINCT d.delivery_id) as totaldelivery, 
                sum(DISTINCT p.product_sold*p.product_price) AS totalsales,
                count(DISTINCT o.order_id) as totalorder, 
                count(DISTINCT p.product_id) as totalproduct
                        FROM seller s
                        JOIN product p ON s.seller_id = p.seller_id
                        JOIN orders o ON p.product_id = o.product_id
                        JOIN cart c ON o.cart_id = c.cart_id
                        JOIN payment pa ON c.cart_id  = pa.cart_id 
                        JOIN delivery d ON pa.payment_id  = d.payment_id 
                        WHERE o.order_date = '$report_date'
                        GROUP BY s.seller_id";

                $order_result = mysqli_query($dbc, $sql);

                $allVerified = true; // Flag to check if all statuses are verified

                while ($row = mysqli_fetch_assoc($order_result)) {
                  $totalOrder = $totalOrder + $row['totalorder'];
                  $totalProduct = $totalProduct + $row['totalproduct'];
                  

                  echo '
                  <tr>
                    <td >'.$row['seller_id'].'</td>
                    <td class="text-center">'.$row['seller_name'].'</td>
                    <td class="text-center">'.$row['totalorder'].'</td>
                    <td class="text-center">'.$row['totalproduct'].'</td>
                    
                   
                  
                  </tr>';
                }
              ?>
              <tr>
                    <td ><strong>Total</strong></td>
                    <td class="text-center"></td>
                    <td class="text-center"><strong><?php echo $totalOrder ?></strong></td>
                    <td class="text-center"><strong><?php echo $totalProduct ?></strong></td>
                    
                   
                  
                  </tr>

                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <button align="center" class="filled-button" onclick="window.print();" id="print-btn">Print Report</button><br><br>
       <a href="http://localhost/unistore/v1.2/a_index.php" id="print-btn">Back</a>


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