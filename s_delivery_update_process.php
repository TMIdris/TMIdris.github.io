<?php
  session_start();
  $d_id = $_POST['deliveryId']; //dptkan drpd echo
  $d_status = $_POST['status'];
  /*$p_id = $_GET['productId'];
  $o_qty = $_GET['orderQuantity'];
  $new_qty = $_POST['newOrderQuantity'];*/
  include("dbconn.php");

    // Update the order quantity
  $update_sql = "UPDATE delivery SET delivery_status = '$d_status' WHERE delivery_id = '$d_id'";
  $update_result = mysqli_query($dbc, $update_sql);

  if($update_result){ //jika berjaya delete dan update
      mysqli_commit($dbc); 
        $_SESSION['alert'] = "
        <script>
          Swal.fire(
              'Status Successfully Updated!',
              'You can view your cart!',
              'success'
            )
        </script>";
        header("Location: s_delivery.php");
        exit();
  }
  else{ //If fail to delete
    mysqli_rollback($dbc);
    $_SESSION['alert'] = "
        <script>
          Swal.fire(
              'Status Unsuccessfully Updated!',
              'Please try again!',
              'error'
            )
        </script>";
        header("Location: s_delivery.php");
        exit();
  }
?>