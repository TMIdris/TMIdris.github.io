<?php
    session_start();
    $c_id = $_SESSION['id'];
    $cart_id = $_GET['cartId'];
    $s_id = $_GET['sellerId'];
    $pay_id = $_GET['payId'];
    $pay_amt = $_GET['paymentAmount'];

    include("dbconn.php");

    $cust_query = "SELECT * FROM customer WHERE customer_id = '$c_id'";
    $cust_result = mysqli_query($dbc, $cust_query);
    $cust_row = mysqli_fetch_assoc($cust_result);
    $cust_address = $cust_row['customer_address'];

    // Update order status
    $update_query = "UPDATE `orders` o
                    INNER JOIN `product` p ON o.product_id = p.product_id
                    INNER JOIN `cart` c ON c.cart_id = o.cart_id
                    INNER JOIN `payment` pa ON pa.cart_id = c.cart_id
                    SET o.order_status = '$pay_id'
                    WHERE o.cart_id = '$cart_id'
                    AND p.seller_id = '$s_id'
                    AND pa.payment_id = '$pay_id'
                    AND o.order_status = 'payment'";
    $update_result = mysqli_query($dbc, $update_query);

    
    // Get payment method
    $payment_query = "SELECT *
                      FROM payment p
                      JOIN cart c ON p.cart_id = c.cart_id
                      WHERE p.payment_id = '$pay_id'";
    $payment_result = mysqli_query($dbc, $payment_query);
    $payment_row = mysqli_fetch_assoc($payment_result);
    $method = $payment_row['payment_method'];

    // Add delivery details
    $sql = "INSERT INTO `delivery` (`delivery_id`, `payment_id`, `delivery_address`, `delivery_status`)
            VALUES (NULL, '$pay_id', '$cust_address', '🟡')";

    $results = mysqli_query($dbc, $sql);


    if ($results&&$update_result) { 
        mysqli_commit($dbc); // display message box Record Been Added
         if ($method == 'Cash on Delivery') { 
            $update_query = "UPDATE payment SET payment_amount = '$pay_amt', payment_status = 'paid on delivery' WHERE payment_id = '$pay_id'";
            $update_result = mysqli_query($dbc, $update_query);
            if ($update_result){

            echo '<script>alert("Please make payment after your product delivered");</script>';

            echo '<script>window.location.assign("c_orders_list.php");</script>';}

            else{
                mysqli_rollback($dbc);
                // display error message
                echo '<script>alert("Payment details update unsuccessful");</script>';
                // go back to frmproduct.php page
                echo '<script>window.location.assign("c_orders_list.php");</script>';
            }
        } else { 
            // Update the payment amount
            $update_query = "UPDATE payment SET payment_amount = '$pay_amt', payment_status = 'paid online' 
                             WHERE payment_id = '$pay_id'";
            $update_result = mysqli_query($dbc, $update_query);
            if ($update_result){
            echo '<script>alert("Please complete your payment");</script>';
            // go back to frmproduct.php page
            echo '<script>window.location.assign("c_orders_payment_approval_frm.php?payId='.$pay_id.'&&sellerId='.$s_id.'");</script>';}
            else{
                mysqli_rollback($dbc);
                // display error message
                echo '<script>alert("Payment details update unsuccessful");</script>';
                // go back to frmproduct.php page
                echo '<script>window.location.assign("c_orders_list.php");</script>';
            }
        }
    } else {
        mysqli_rollback($dbc);
        // display error message
        echo '<script>alert("Payment details update unsuccessful");</script>';
        // go back to frmproduct.php page
        echo '<script>window.location.assign("c_orders_list.php");</script>';
    }

   

    // Close the database connection
    mysqli_close($dbc);
?>
