<?php
    session_start();
    $c_id = $_SESSION['id'];
    $pay_id = $_POST['payId'];
    $pay_acc = $_POST['account'];
    $image = $_FILES["image"];

    $info = getimagesize($image["tmp_name"]);
    if(!$info)
    {
        die("File is not an image");
    }
    $name = $image["name"];
    $type = $image["type"];
    $blob = addslashes(file_get_contents($image["tmp_name"]));


    include("dbconn.php");

    $delivery_query = "SELECT delivery_id FROM delivery d 
                      INNER JOIN payment p ON p.payment_id = d.payment_id 
                      WHERE p.payment_id = '$pay_id'";
    $delivery_result = mysqli_query($dbc, $delivery_query);
    $delivery_row = mysqli_fetch_assoc($delivery_result);
    $delivery_id = $delivery_row['delivery_id'];


    // Update the payment amount
    $update_query = "UPDATE payment SET payment_proof = '".$blob."', payment_account = '$pay_acc', payment_status = 'Payment done' WHERE payment_id = '$pay_id'";
    $update_result = mysqli_query($dbc, $update_query);

    $update_delivery_query = "UPDATE delivery SET delivery_status = '🟠' WHERE delivery_id = '$delivery_id'";
    $update_delivery_result = mysqli_query($dbc, $update_delivery_query);


    if($update_result && $update_delivery_result){ //jika berjaya update
        mysqli_commit($dbc);
        Print '<script>alert("Payment Proof Succesfully Updated.");</script>';
        Print '<script>window.location.assign("c_delivery_list.php");</script>';
    }
    else{ //If fail to delete
        mysqli_rollback($dbc);
        Print '<script>alert("Payment Proof is failed to be Updated.");</script>';
        Print '<script>window.location.assign("c_orders_payment_approval_frm.php");</script>';
    }

   

    // Close the database connection
    mysqli_close($dbc);
?>
