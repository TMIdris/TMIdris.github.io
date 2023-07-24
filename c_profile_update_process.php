<?php
    // Assign data from customer form into variables
    session_start();
    $c_id = $_SESSION['id'];
    $c_name = $_POST['name'];
    $c_email = $_POST['email'];
    $c_address = $_POST['address'];
    $c_contact = $_POST['contact'];
    $c_photo = $_POST['photo'];

    // Connection to the database
    include("dbconn.php");

    // SQL Statement to insert data from the form into the customer table
    $sql = "UPDATE `customer` SET 
                   `customer_name` = '$c_name',
                   `customer_email` = '$c_email',
                   `customer_address` = '$c_address',
                   `customer_contact` = '$c_contact',
                   `customer_photo` = '$c_photo'
             WHERE `customer_id` = '$c_id'";


    $results = mysqli_query($dbc, $sql);

    if($results){ //jika berjaya update
        mysqli_commit($dbc); 
        $_SESSION['alert'] = "
        <script>
          Swal.fire(
              'Profile Updated!',
              '',
              'success'
            )
        </script>";
        header("Location: c_profile.php");
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
          text: 'Profile Not Updated!!'
        })
        </script>";
        header("Location: c_orders_list.php");
        exit();
    }

    // Close the database connection
    mysqli_close($dbc);
?>