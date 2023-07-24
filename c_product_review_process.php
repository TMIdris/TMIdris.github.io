<?php
    // Assign data from customer form into variables
    session_start();
    $c_id = $_SESSION['id'];
    $p_id = $_POST['productId'];
    $r_comm = $_POST['comment'];
    $r_rate = $_POST['rating'];

    // Connection to the database
    include("dbconn.php");

    $review_sql = "SELECT * FROM review WHERE customer_id = $c_id AND product_id = '$p_id'";

    $review_result = mysqli_query($dbc, $review_sql);

    if ($review_result = !NULL && mysqli_num_rows($review_result) > 0){
      $sql = "UPDATE `review` SET 
                     `review_comment` = '$r_comm',
                     `review_rating` = '$r_rate'
               WHERE `customer_id` = '$c_id'
               AND   `product_id` = '$p_id'";
    }else{
      $sql = "INSERT INTO `review` (`review_id`, `customer_id`, `product_id`, `review_comment`, `review_rating`)
            VALUES (NULL, '$c_id', '$p_id', '$r_comm', '$r_rate')";
    }

    $results = mysqli_query($dbc, $sql);

    if($results){ //jika berjaya update
        mysqli_commit($dbc); 
        $_SESSION['alert'] = "
        <script>
          Swal.fire(
              'Review Submitted!',
              '',
              'success'
            )
        </script>";
        header("Location: c_orders_received_list_info.php");
        exit();
    }
    else{ //If fail to delete
        $_SESSION['alert'] = "
        <script>
        Swal.fire({
        {
          icon: 'error',
          title: 'Oops...',
          text: 'Review Submit Cancelled!!'
        })
        </script>";
        header("Location: c_orders_received_list_info.php");
        mysqli_rollback($dbc);
        exit();
    }

    // Close the database connection
    mysqli_close($dbc);
?>