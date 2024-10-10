<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form inputs
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $design = $_FILES['design'];

    // Directory where uploaded designs will be stored
    $target_dir = "uploads/";

    // Check if the uploads directory exists, if not, create it
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Set the file path where the uploaded file will be stored
    $target_file = $target_dir . basename($design["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate file size (limit to 5MB)
    if ($design["size"] > 5000000) {
        echo "Sorry, your file is too large. Limit is 5MB.";
        $uploadOk = 0;
    }

    // Only allow certain file formats
    if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "pdf") {
        echo "Sorry, only JPG, JPEG, PNG & PDF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Try to move the file to the target directory
        if (move_uploaded_file($design["tmp_name"], $target_file)) {
            echo "The file ". basename($design["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
