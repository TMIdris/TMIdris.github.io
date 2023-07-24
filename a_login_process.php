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

    $sql = "SELECT * FROM admin WHERE admin_name='$name' AND admin_password='$pass'";
    $results=mysqli_query($dbc,$sql);

    if (mysqli_num_rows($results) === 1) {
        $row = mysqli_fetch_assoc($results);
        if ($row['admin_name'] === $name && $row['admin_password'] === $pass) {
            $_SESSION['a_name'] = $row['admin_name'];
            $_SESSION['a_id'] = $row['admin_id'];
            $_SESSION['alert'] = "
            <script>
              Swal.fire(
                  'Sign in Complete!',
                  'You can continue shopping!',
                  'success'
                )
            </script>";
            header("Location: a_index.php");
            exit();
        }else{
            header("Location: a_login.php?error=*Incorrect Username or password");
            exit();
        }
    }else{
        header("Location: a_login.php?error=*Incorrect Username or password");
        exit();
    }
}else{
    header("Location: a_login1.php");
    exit();
}


