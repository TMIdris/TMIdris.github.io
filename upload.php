<?php
    // assume you have a database named 'blob'
    $conn = mysqli_connect("localhost", "root", "", "blob");
    $image = $_FILES["image"];
    $info = getimagesize($image["tmp_name"]);
    if(!$info)
    {
        die("File is not an image");
    }
    $name = $image["name"];
    $type = $image["type"];
    $blob = addslashes(file_get_contents($image["tmp_name"]));
    $sql = "INSERT INTO `images` (`image`, `name`, `type`) VALUES ('" . $blob . "', '" . $name . "' , '" . $type . "')";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
    echo "File has been uploaded.";
?>