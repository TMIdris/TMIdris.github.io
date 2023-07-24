<?php
	session_start();
	$o_id = $_GET['orderId']; //dptkan drpd echo
	$p_id = $_GET['productId'];
	$o_qty = $_GET['orderQuantity'];
	include("dbconn.php");

    // Delete the order
    $delete_sql = "DELETE FROM orders WHERE order_id = '$o_id'";
    $delete_result = mysqli_query($dbc, $delete_sql);

    // Update the product quantity
    $update_sql = "UPDATE product SET product_stock = product_stock + '$o_qty' WHERE product_id = '$p_id'";
    $update_result = mysqli_query($dbc, $update_sql);

	if($delete_result && $update_result){ //jika berjaya delete dan update
	    mysqli_commit($dbc); 
        $_SESSION['alert'] = "
        <script>
          Swal.fire(
              'Order Successfully Deleted!',
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
              'Order Unsuccessfully deleted!',
              'Please try again!',
              'error'
            )
        </script>";
        header("Location: c_orders_list.php");
        exit();
	}
?>