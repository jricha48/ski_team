<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize the form inputs
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $design = $_FILES['design'];

    // Check if the file was uploaded without errors
    if ($design['error'] !== UPLOAD_ERR_OK) {
        echo "An error occurred during file upload.";
        exit;
    }

    // Validate file size (limit to 5MB)
    if ($design['size'] > 5000000) {
        echo "Sorry, your file is too large. Limit is 5MB.";
        exit;
    }

    // Allowed MIME types
    $allowed_mime_types = ['image/jpeg', 'image/png', 'application/pdf'];

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $file_mime_type = $finfo->file($design['tmp_name']);

    if (!in_array($file_mime_type, $allowed_mime_types)) {
        echo "Invalid file type.";
        exit;
    }

    // Set the target directory for the uploads
    $target_dir = "uploads/";

    // Check if directory exists, if not create it
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Generate a unique file name
    $ext = pathinfo($design['name'], PATHINFO_EXTENSION);
    $unique_name = uniqid('design_', true) . '.' . $ext;
    $target_file = $target_dir . $unique_name;

    // Move the uploaded file
    if (move_uploaded_file($design['tmp_name'], $target_file)) {
        echo "Your design has been successfully uploaded. Thank you!";
        // Optionally, you can send a confirmation email to the user or save details to a database
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
