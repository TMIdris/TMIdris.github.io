<?php
	session_start();
	$p_id = $_GET['productId'];
	include("dbconn.php");

  // Delete the order
  $delete_sql = "DELETE FROM product WHERE product_id = '$p_id'";
  $delete_result = mysqli_query($dbc, $delete_sql);

	if($delete_result && $update_result){ //jika berjaya delete dan update
	    mysqli_commit($dbc); 
        $_SESSION['alert'] = "
        <script>
          Swal.fire(
              'Product Successfully Deleted!',
              'You can view your cart!',
              'success'
            )
        </script>";
        header("Location: s_page.php");
        exit();
	}
	else{ //If fail to delete
		mysqli_rollback($dbc);
		$_SESSION['alert'] = "
        <script>
          Swal.fire(
              'Product Unsuccessfully deleted!',
              'Please try again!',
              'error'
            )
        </script>";
        header("Location: s_page.php");
        exit();
	}
?>