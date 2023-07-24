<?php
	session_start();
	$p_id = $_GET['productId'];
	include("dbconn.php");

  // Delete the order
  $delete_sql = "DELETE FROM review WHERE product_id = '$p_id'";
  $delete_result = mysqli_query($dbc, $delete_sql);

	if($delete_result){ //jika berjaya delete dan update
	    mysqli_commit($dbc); 
        $_SESSION['alert'] = "
        <script>
          Swal.fire(
              'Review Successfully Deleted!',
              'You can view your cart!',
              'success'
            )
        </script>";
        header("Location: c_orders_received_list.php");
        exit();
	}
	else{ //If fail to delete
		mysqli_rollback($dbc);
		$_SESSION['alert'] = "
        <script>
          Swal.fire(
              'Review Unsuccessfully deleted!',
              'Please try again!',
              'error'
            )
        </script>";
        header("Location: c_orders_received_list.php");
        exit();
	}
?>