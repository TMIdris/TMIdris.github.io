<?php
    // Assign data from customer form into variables
    $c_name = $_POST['name'];
    $c_password = $_POST['password'];
    $c_email = $_POST['email'];
    $c_address = $_POST['address'];
    $c_contact = $_POST['contact'];
    $hashedPassword = password_hash($c_password, PASSWORD_BCRYPT);

    // Connection to the database
    include("dbconn.php");

    // SQL Statement to insert data from the form into the customer table
    $sql = "INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_password`, `customer_email`, `customer_address`, `customer_contact`)
        VALUES (NULL, '$c_name', '$hashedPassword', '$c_email', '$c_address', '$c_contact')";

    $results = mysqli_query($dbc, $sql);

    if ($results) {
        $customer_id = mysqli_insert_id($dbc); // Get the last inserted customer_id

        // SQL Statement to insert data into the cart table
        $sql = "INSERT INTO `cart` (`cart_id`, `customer_id`)
            VALUES (NULL, '$customer_id')";

        $results_cart = mysqli_query($dbc, $sql);

        if ($results_cart) {
            mysqli_commit($dbc); // Commit the transaction
            $_SESSION['alert'] = "
            <script>
              Swal.fire(
                  'Sign up Complete!',
                  'Please log in',
                  'success'
                )
            </script>";
            header("Location: login.php");
            //echo '<script>alert("Signup Successful");</script>';
            //echo '<script>window.location.assign("login.php");</script>';
        } else {
            mysqli_rollback($dbc); // Rollback the transaction
            $_SESSION['alert'] = "
            <script>
              Swal.fire(
                  'Sign up Unsuccessful!',
                  'Please sign up again',
                  'error'
                )
            </script>";
            header("Location: signup.php");
            //echo '<script>alert("Signup Unsuccessful");</script>';
            //echo '<script>window.location.assign("signup.php");</script>';
        }
    } else {
        mysqli_rollback($dbc); // Rollback the transaction
        $_SESSION['alert'] = "
        <script>
          Swal.fire(
              'Sign up Unsuccessful!',
              'Please sign up again',
               'error'
            )
        </script>";
        header("Location: signup.php");
        //echo '<script>alert("Signup Unsuccessful");</script>';
        //echo '<script>window.location.assign("signup.php");</script>';
    }

    // Close the database connection
    mysqli_close($dbc);
?>