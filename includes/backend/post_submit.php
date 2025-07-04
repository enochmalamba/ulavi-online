<?php
// MUST be first - initialize session and validate user
require_once 'init.php';

// Verify user is logged in
if (!isset($_SESSION['user_id']) || !validate_session()) {
    header("Location: ../../signin.php");
    exit();
}

if (isset($_POST['create_post'])) {
    // Validate CSRF token
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        die("CSRF token validation failed");
    }

    // Get the text for the post
    $title = sanitize_input($_POST['title']);
    $content = sanitize_input($_POST['content']);
    $category = "Arts";
    $user_id = $_SESSION['user_id']; // Now guaranteed to exist

    // Handle file upload
    if (isset($_FILES['post_image']) && $_FILES['post_image']['error'] === UPLOAD_ERR_OK) {
        $imageName = uniqid() . $_FILES['post_image']['name'];
        $imageTempPath = $_FILES['post_image']['tmp_name'];

        // Path two directories up
        $baseDir = dirname(dirname(__DIR__));
        $targetDir = $baseDir . '/uploads/post-images/';
        $imageSavePath = $targetDir . basename($imageName);
        $relativePath = 'uploads/post-images/' . basename($imageName);

        // Create directory if needed
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        // Prepare statement with image
        if (move_uploaded_file($imageTempPath, $imageSavePath)) {
            $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content, media_url, category) VALUES (?,?,?,?,?)");
            $stmt->bind_param("issss", $user_id, $title, $content, $relativePath, $category);
        } else {
            error_log("File upload failed: " . $_FILES['post_image']['error']);
            header("Location: ../../home.php?error=upload");
            exit();
        }
    } else {
        // Prepare statement without image
        $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content, category) VALUES (?,?,?,?)");
        $stmt->bind_param("isss", $user_id, $title, $content, $category);
    }

    // Execute the query
    if ($stmt->execute()) {
        $last_id = $conn->insert_id;
        header("Location: ../../post.php?post_id={$last_id}");
        exit();
    } else {
        error_log("Database error: " . $stmt->error);
        header("Location: ../../home.php?error=database");
        exit();
    }
} else {
    header("Location: ../../home.php");
    exit();
}