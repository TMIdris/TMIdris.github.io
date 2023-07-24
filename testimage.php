<?php
    $conn = mysqli_connect("localhost", "root", "", "blob");
    $sql = "CREATE TABLE IF NOT EXISTS `images` (
        `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `image` LONGBLOB NOT NULL,
        `name` TEXT NOT NULL,
        `type` VARCHAR (11) NOT NULL
    )";
    mysqli_query($conn, $sql);
?>
<<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>
<body>

<form method="POST" action="upload.php" enctype="multipart/form-data">
    <p>
        <label>Upload Image</label>
        <input type="file" name="image" accept="image/*" required />
    </p>
    <input type="submit" value="Upload" />
</form>

</body>
</html>

