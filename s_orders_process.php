<?php
  session_start();
  $o_id = $_POST['orderId']; //dptkan drpd echo
  $o_status = $_POST['status'];
  /*$p_id = $_GET['productId'];
  $o_qty = $_GET['orderQuantity'];
  $new_qty = $_POST['newOrderQuantity'];*/
  include("dbconn.php");

    // Update the order quantity
    $update_sql = "UPDATE orders SET order_status = '$o_status' WHERE order_id = '$o_id'";
    $update_result = mysqli_query($dbc, $update_sql);

  if($update_result){ //jika berjaya delete dan update
      mysqli_commit($dbc); 
        $_SESSION['alert'] = "
        <script>
          Swal.fire(
              'Order Successfully Updated!',
              'You can view your cart!',
              'success'
            )
        </script>";
        header("Location: seller_orders.php");
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
        header("Location: seller_orders.php");
        exit();
  }
?>