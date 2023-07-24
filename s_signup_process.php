<?php
    // Assign data from customer form into variables
    session_start();
    $c_id = $_SESSION['id'];

    $s_name = $_POST['name'];
    $s_shop_name = $_POST['shopname'];
    $s_email = $_POST['email'];
    $s_contact = $_POST['contact'];
    $s_bank = $_POST['bank'];
    $s_acc = $_POST['account'];

    // Connection to the database
    include("dbconn.php");

    $seller_query = "SELECT * FROM seller s INNER JOIN customer c ON c.customer_id = s.customer_id WHERE c.customer_id = '$c_id'";
    $seller_result = mysqli_query($dbc, $seller_query);
    $seller_row = mysqli_fetch_assoc($seller_result);
    $s_id = $seller_row['seller_id'];


    // SQL Statement to insert data from the form into the customer table
    $sql = "UPDATE `seller` SET 
                   `seller_name` = '$s_name',
                   `seller_shop_name` = '$s_shop_name',
                   `seller_email` = '$s_email',
                   `seller_contact` = '$s_contact',
                   `seller_bank` = '$s_bank',
                   `seller_account` = '$s_acc'
             WHERE `seller_id` = '$s_id'";


    $results = mysqli_query($dbc, $sql);

    if($results){ //jika berjaya update
        mysqli_commit($dbc); 
        $_SESSION['alert'] = "
        <script>
          Swal.fire(
              'Complete!',
              '',
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
        Swal.fire({
        {
          icon: 'error',
          title: 'Oops...',
          text: 'error occured'
        })
        </script>";
        header("Location: s_signup.php");
        exit();
    }

    // Close the database connection
    mysqli_close($dbc);
?>