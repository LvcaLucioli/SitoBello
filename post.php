<?php
require_once __DIR__ . '/config.inc.php';

$target_dir = "convenzioni/"; 
$target_file = $target_dir . basename($_FILES["logo"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["logo"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["logo"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif"
) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["logo"]["name"])) . " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$connection = mysqli_connect($hostname, $username, $password, $db_name) or die("failed connection");
$query = "INSERT INTO `conventions` (`company_name`, `city`, `address`, `phone`, `description`, `logo_path`) VALUES ('" . $_POST['company_name'] . "', '" . $_POST['city'] . "', '" . $_POST['address'] . "', '" . $_POST['phone'] . "', '" . $_POST['description'] . "', '" . $target_file . "')";
if (mysqli_query($connection, $query)) {
    echo 'ok';
} else {
    echo 'not so ok';
    echo mysqli_error($connection);
}
