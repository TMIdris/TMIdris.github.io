<?php
  session_start();
  $pay_id = $_GET['payId']; 
  include("dbconn.php");

  // Update the delivery status
  $update_sql = "UPDATE delivery SET delivery_status = 'Received' WHERE payment_id = '$pay_id'";
  $update_result = mysqli_query($dbc, $update_sql);

  if($update_result){ //jika berjaya delete dan update
      mysqli_commit($dbc); 
        $_SESSION['alert'] = "
        <script>
          Swal.fire(
              'Confirm Received!',
              'Enjoy your product!',
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
              'Receive Cancelled!',
              'Please try again!',
              'error'
            )
        </script>";
        header("Location: c_delivery_list.php");
        exit();
  }
?>