<?php
    session_start();
    $p_id = $_GET['productId'];
    $c_id = $_SESSION['id'];
    $p_qtty = $_POST['pqtty'];

    include("dbconn.php");

    // Update the product's stock in the database
    $update_query = "UPDATE product SET product_stock = product_stock - '$p_qtty', product_sold = product_sold + '$p_qtty' 
                     WHERE product_id = '$p_id'";
    $update_result = mysqli_query($dbc, $update_query);

    // Set the desired time zone
    date_default_timezone_set('Asia/Kuala_Lumpur');

    // Get the current date and time
    $current_date = date('Y-m-d');
    $current_time = date('H:i:s');

    // Retrieve the cart_id for the customer from the cart table
    $cart_query = "SELECT cart_id FROM cart WHERE customer_id = '$c_id'";
    $cart_result = mysqli_query($dbc, $cart_query);

    if ($cart_result && mysqli_num_rows($cart_result) > 0) {
        $cart_row = mysqli_fetch_assoc($cart_result);
        $cart_id = $cart_row['cart_id'];

        // Insert the order into the orders table
        $sql = "INSERT INTO `orders` (`product_id`, `customer_id`, `cart_id`, `order_date`, `order_time`, `order_quantity`, `order_status`)
            VALUES ('$p_id', '$c_id', '$cart_id', '$current_date', '$current_time', '$p_qtty', '🟢')"; //green for testing only

        $results = mysqli_query($dbc, $sql);

        if ($results && $update_result) {
            mysqli_commit($dbc); 
            $_SESSION['alert'] = "
            <script>
              Swal.fire(
                  'Added to Cart!',
                  'You can view your cart!',
                  'success'
                )
            </script>";
            header("Location: c_orders_list.php");
            exit();
        } else {
            mysqli_rollback($dbc);
            $_SESSION['alert'] = "
            <script>
            Swal.fire({
            {
              icon: 'error',
              title: 'Oops...',
              text: 'Item not added to cart!'
            })
            </script>";
            header("Location: c_orders_list.php");
            exit();
        }
    } else {
        // If the cart_id couldn't be retrieved, handle the error accordingly
        $_SESSION['alert'] = "
        <script>
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Could not retrieve cart ID!'
        })
        </script>";
        header("Location: c_orders_list.php");
        exit();
    }

    // Close the database connection
    mysqli_close($dbc);
?>
