<?php
session_start();
$c_id = $_SESSION['id'];
$p_name = $_POST['name'];
$p_desc = $_POST['description'];
$p_price = $_POST['price'];
$p_stock = $_POST['stock'];
$p_id = $_POST['productId'];

$image = $_FILES["image"];
$info = getimagesize($image["tmp_name"]);
if(!$info)
{
    die("File is not an image");
}
$name = $image["name"];
$type = $image["type"];
$blob = addslashes(file_get_contents($image["tmp_name"]));

// Connection to the database
include("dbconn.php");

$sql = "UPDATE `product`
        SET `product_name` = '$p_name',
            `product_description` = '$p_desc',
            `product_price` = '$p_price',
            `product_stock` = '$p_stock',
            `product_photo` = '".$blob."'
        WHERE `product_id` = '$p_id'";

$results = mysqli_query($dbc, $sql);

if ($results) { //if successful insert
  mysqli_commit($dbc);
  $_SESSION['alert'] = "
  <script>
    Swal.fire(
      'Product Updated!',
      '',
      'success'
    )
  </script>";
  header("Location: s_page.php");
  exit();
} else { //If fail to insert
  $_SESSION['alert'] = "
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Product Not Update!!'
    })
  </script>";
  header("Location: s_page.php");
  mysqli_rollback($dbc);
  exit();
}

// Close the database connection
mysqli_close($dbc);
?>