<?php
    // Assign data from customer form into variables
    session_start();
    $c_id = $_SESSION['id'];

    // Connection to the database
    include("dbconn.php");

    $customer_query = "SELECT * FROM customer WHERE customer_id = '$c_id'";
    $customer_result = mysqli_query($dbc, $customer_query);
    $customer_row = mysqli_fetch_assoc($customer_result);
    $c_name = $customer_row['customer_name'];
    $c_email = $customer_row['customer_email'];
    $c_contact = $customer_row['customer_contact'];
    //$c_address = $customer_row['customer_address'];
    $c_photo = $customer_row['customer_photo'];

    $seller_sql = "SELECT * FROM seller WHERE customer_id = $c_id";

    $seller_result = mysqli_query($dbc, $seller_sql);

    if ($seller_result = !NULL && mysqli_num_rows($seller_result) > 0){
        mysqli_commit($dbc); 
        header("Location: s_page.php");
        exit();
    }else{
      $sql = "INSERT INTO `seller` (`seller_id`, `customer_id`, `seller_name`, `seller_shop_name`, `seller_email`, `seller_contact`, `seller_bank`, `seller_account`)
            VALUES (NULL, '$c_id', NULL, NULL, '$c_email', '$c_contact', NULL, NULL)";

    $results = mysqli_query($dbc, $sql);

    if($results){
        mysqli_commit($dbc); 
        $_SESSION['alert'] = "<script>Swal.fire('Welcome to seller page!', 'Please complete the new seller form!')</script>";
        header("Location: s_signup.php");
        exit();}
    else{ 
        header("Location: index.php");
        mysqli_rollback($dbc);
        exit();}
    }



    // Close the database connection
    mysqli_close($dbc);
?>