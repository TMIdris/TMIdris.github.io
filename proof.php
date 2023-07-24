<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Payment Proof</title>
    <style>
        /* CSS to make the image larger and nicely fit the screen */
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f2f2f2;
        }
        img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>
<body>

    <?php
    include("dbconn.php");

    $p_id = $_GET['payId'];

    // Retrieve the payment_proof using payment_id
    $sql = "SELECT payment_proof FROM payment WHERE payment_id = '$p_id'";
    $result = mysqli_query($dbc, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $payment_proof_base64 = base64_encode($row['payment_proof']);
    } else {
        echo "Image not found.";
        exit();
    }
    ?>

    <img src="data:image/png;base64,<?php echo $payment_proof_base64; ?>" alt="">

</body>
</html>
