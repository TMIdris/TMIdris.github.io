<?php
session_start();
$c_id = $_SESSION['id'];
$p_name = $_POST['name'];
$p_desc = $_POST['description'];
$p_price = $_POST['price'];
$p_stock = $_POST['stock'];

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

$seller_query = "SELECT * FROM seller s INNER JOIN customer c ON c.customer_id = s.customer_id WHERE c.customer_id = '$c_id'";
$seller_result = mysqli_query($dbc, $seller_query);
$seller_row = mysqli_fetch_assoc($seller_result);
$s_id = $seller_row['seller_id'];

$sql = "INSERT INTO `product` (`product_id`, `seller_id`, `product_name`, `product_description`, `product_price`, `product_stock`, `product_sold`, `product_photo`)
        VALUES (NULL, '$s_id', '$p_name', '$p_desc', '$p_price', '$p_stock', 0,'".$blob."')";

$results = mysqli_query($dbc, $sql);

if ($results) { //if successful insert
  mysqli_commit($dbc);
  $_SESSION['alert'] = "
  <script>
    Swal.fire(
      'Product Added!',
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
      text: 'Product Not Added!!'
    })
  </script>";
  header("Location: s_page.php");
  mysqli_rollback($dbc);
  exit();
}

// Close the database connection
mysqli_close($dbc);
?>