<?php
	session_start();
	$o_id = $_GET['orderId']; //dptkan drpd echo
	$p_id = $_GET['productId'];
	$o_qty = $_GET['orderQuantity'];
	$new_qty = $_POST['newOrderQuantity'];
	include("dbconn.php");

    // Update the order quantity
    $update_sql = "UPDATE orders SET order_quantity = '$new_qty' WHERE order_id = '$o_id'";
    $update_result = mysqli_query($dbc, $update_sql);

    // Update the product quantity
    $update_sql = "UPDATE product SET product_stock = product_stock + '$o_qty' WHERE product_id = '$p_id'";
    $update_result = mysqli_query($dbc, $update_sql);

    // Update the product quantity after the new quantity entered
    $update_entered_sql = "UPDATE product SET product_stock = product_stock - '$new_qty' WHERE product_id = '$p_id'";
    $update_entered_result = mysqli_query($dbc, $update_entered_sql);

	if($update_result && $update_entered_result){ //jika berjaya delete dan update
	    mysqli_commit($dbc); 
        $_SESSION['alert'] = "
        <script>
          Swal.fire(
              'Order Successfully Updated!',
              'You can view your cart!',
              'success'
            )
        </script>";
        header("Location: c_orders_list.php");
        exit();
	}
	else{ //If fail to delete
		mysqli_rollback($dbc);
		$_SESSION['alert'] = "
        <script>
          Swal.fire(
              'Order Unsuccessfully Updated!',
              'Please try again!',
              'error'
            )
        </script>";
        header("Location: c_orders_list.php");
        exit();
	}
?>