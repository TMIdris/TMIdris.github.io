<?php
    session_start();
    $c_id = $_SESSION['id'];
    $p_method = $_POST['method'];
    $s_id = $_POST['sellerId'];
    $cart_id = $_POST['cartId'];


    include("dbconn.php");

    // Set the desired time zone
    date_default_timezone_set('Asia/Kuala_Lumpur');

    // Get the current date and time
    $current_date = date('Y-m-d');
    $current_time = date('H:i:s');

    // Update the order status
    $update_query = "UPDATE orders
                     INNER JOIN product ON product.product_id = orders.product_id
                     SET orders.order_status = 'payment'
                     WHERE product.seller_id = '$s_id'
                     AND (orders.order_status = '🟡' OR orders.order_status = '🟢' OR orders.order_status = '🔴')
                     AND orders.order_status NOT LIKE '%[0-9]%'
                     AND orders.cart_id = '$cart_id'
                     AND orders.cart_id = '$cart_id'";
    $update_result = mysqli_query($dbc, $update_query);

    // Insert into payment table
    $sql = "INSERT INTO `payment` (`payment_id`, `customer_id`, `cart_id`, `payment_amount`, `payment_date`, `payment_time`, `payment_method`, `payment_proof`, `payment_status`)
          VALUES (NULL, '$c_id', '$cart_id', NUll, '$current_date', '$current_time', '$p_method', NULL, 'Unpaid')";

    $results = mysqli_query($dbc, $sql);

    if ($results&&$update_result) { 
        mysqli_commit($dbc); 
        $_SESSION['alert'] = "
        <script>
          Swal.fire(
              'Payment details updated!',
              'You can view your cart!',
              'success'
            )
        </script>";
        echo '<script>window.location.assign("c_orders_invoice.php?sellerId='.$s_id.'");</script>';
        exit();
    }
    else{ //If fail to delete
        mysqli_rollback($dbc);
        $_SESSION['alert'] = "
        <script>
          Swal.fire(
              'Payment details update unsuccessful!',
              'Please try again!',
              'error'
            )
        </script>";
        header("Location: c_orders_invoice.php");
        exit();
    }

    // Close the database connection
    mysqli_close($dbc);
?>
