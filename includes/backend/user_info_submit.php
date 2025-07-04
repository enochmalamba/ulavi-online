<?php
require_once('init.php'); 
require_once('config.php');
require_once('functions.php');
session_start();

// Validate CSRF token
if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
    die("CSRF token validation failed");
}

if (!isset($_SESSION['user_id'])) {
    header("Location: signup.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle user_info1.php form (basic info)
if (isset($_POST['enter_user_data1'])) {
    $dob = $_POST['birthday'];
    $location = sanitize_input($_POST['location']);
    $gender = $_POST['gender'];
    
    // UPDATE instead of INSERT
    $stmt = $conn->prepare("UPDATE user_profile SET dob = ?, user_location = ?, gender = ? WHERE user_id = ?");
    $stmt->bind_param("sssi", $dob, $location, $gender, $user_id);
    
    if ($stmt->execute()) {
        // Update session data
        $_SESSION['dob'] = $dob;
        $_SESSION['location'] = $location;
        $_SESSION['gender'] = $gender;
        
        $_SESSION['data_submit_msg'] = "Data submitted successfully!";
        header("Location: ../../user_info2.php");
        exit();
    } else {
        // Handle error
        header("Location: ../../user_info1.php?error=database");
        exit();
    }
}

// Handle user_info2.php form (profile details)
if (isset($_POST['enter_user_data2'])) {
    $title = sanitize_input($_POST['title']);
    $bio = sanitize_input($_POST['bio']);
    
    // Handle file upload
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
        $imgName = uniqid() . basename($_FILES['profile_photo']['name']);
        $uploadDir = dirname(__DIR__, 2) . "/uploads/profiles/";
        $imgSavePath = $uploadDir . $imgName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }

        if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $imgSavePath)) {
            $relativeImgPath = "uploads/profiles/" . $imgName;
            
            // UPDATE with photo
            $stmt = $conn->prepare("UPDATE user_profile SET profile_photo = ?, user_title = ?, bio = ? WHERE user_id = ?");
            $stmt->bind_param("sssi", $relativeImgPath, $title, $bio, $user_id);
            
            // Update session
            $_SESSION['profile_photo'] = $relativeImgPath;
        }
    } else {
        // UPDATE without photo
        $stmt = $conn->prepare("UPDATE user_profile SET user_title = ?, bio = ? WHERE user_id = ?");
        $stmt->bind_param("ssi", $title, $bio, $user_id);
    }

    if ($stmt->execute()) {
        // Update session data
        $_SESSION['title'] = $title;
        $_SESSION['bio'] = $bio;
        
        unset($_SESSION['data_submit_msg']);
        header("Location: ../../home.php");
        exit();
    } else {
        header("Location: ../../user_info2.php?error=database");
        exit();
    }
}