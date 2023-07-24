<?php 
session_start(); 
include "dbconn.php";

if (isset($_POST['name']) && isset($_POST['password'])) {
    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $name = validate($_POST['name']);
    $pass = validate($_POST['password']);

    $sql = "SELECT * FROM customer WHERE customer_name='$name'";
    $results = mysqli_query($dbc, $sql);

    if (mysqli_num_rows($results) === 1) {
        $row = mysqli_fetch_assoc($results);
        if (password_verify($pass, $row['customer_password'])) {
            $_SESSION['name'] = $row['customer_name'];
            $_SESSION['id'] = $row['customer_id'];
            $_SESSION['alert'] = "
            <script>
              Swal.fire(
                  'Sign in Complete!',
                  'You can continue shopping!',
                  'success'
                )
            </script>";
            header("Location: index.php");
            exit();
        } else {
            header("Location: login.php?error=*Incorrect Username or password");
            exit();
        }
    } else {
        header("Location: login.php?error=*Incorrect Username or password");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
