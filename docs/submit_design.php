<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize the form inputs
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $design = $_FILES['design'];

    // Check if the file was uploaded without errors
    if ($design['error'] !== UPLOAD_ERR_OK) {
        // Redirect back to the form with an error message
        header('Location: index.php?error=upload');
        exit;
    }

    // Validate file size (limit to 5MB)
    if ($design['size'] > 5000000) {
        // Redirect back to the form with an error message
        header('Location: index.php?error=size');
        exit;
    }

    // Allowed MIME types
    $allowed_mime_types = ['image/jpeg', 'image/png', 'application/pdf'];

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $file_mime_type = $finfo->file($design['tmp_name']);

    if (!in_array($file_mime_type, $allowed_mime_types)) {
        // Redirect back to the form with an error message
        header('Location: index.php?error=type');
        exit;
    }

    // Set the target directory for the uploads
    $target_dir = "uploads/";

    // Check if directory exists, if not create it
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Generate a unique file name
    $ext = pathinfo($design['name'], PATHINFO_
