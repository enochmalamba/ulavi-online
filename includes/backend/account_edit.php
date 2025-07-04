<?php
require_once('init.php');
require_once("config.php");
require_once('functions.php');

// Function to sanitize input
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to handle file uploads
function handleFileUpload($fileInput, $targetDir, $allowedTypes, $maxSize = 10000000) {
    if (!isset($fileInput['error']) || is_array($fileInput['error'])) {
        throw new RuntimeException('Invalid parameters.');
    }

    // Check for errors
    switch ($fileInput['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            return null; // No file was uploaded
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    // Check file size
    if ($fileInput['size'] > $maxSize) {
        throw new RuntimeException('Exceeded filesize limit.');
    }

    // Check file type
    $fileType = strtolower(pathinfo($fileInput['name'], PATHINFO_EXTENSION));
    if (!in_array($fileType, $allowedTypes)) {
        throw new RuntimeException('Invalid file format.');
    }

    // Generate unique filename
    $filename = uniqid() . '.' . $fileType;
    $targetFile = $targetDir . $filename;

    // Move the file
    if (!move_uploaded_file($fileInput['tmp_name'], $targetFile)) {
        throw new RuntimeException('Failed to move uploaded file.');
    }

    return $filename;
}

// Password update
if (isset($_POST['update_password'])) {
    try {
        if ($_POST['new_password'] !== $_POST['confirm_password']) {
            throw new Exception("Passwords do not match!");
        }

        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE community_people SET password = ? WHERE user_id = ?");
        $stmt->bind_param("si", $new_password, $_SESSION['user_id']);
        
        if (!$stmt->execute()) {
            throw new Exception("Password update failed: " . $stmt->error);
        }
        
        $_SESSION['update_message'] = "Password updated successfully!";
    } catch (Exception $e) {
        $_SESSION['update_message'] = $e->getMessage();
    }
}

// Email update
if (isset($_POST['update_email'])) {
    try {
        $new_email = filter_var($_POST['new_email'], FILTER_SANITIZE_EMAIL);
        
        if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format!");
        }

        $stmt = $conn->prepare("UPDATE community_people SET email = ? WHERE user_id = ?");
        $stmt->bind_param("si", $new_email, $_SESSION['user_id']);
        
        if (!$stmt->execute()) {
            throw new Exception("Email update failed: " . $stmt->error);
        }
        
        $_SESSION['update_message'] = "Email updated successfully!";
    } catch (Exception $e) {
        $_SESSION['update_message'] = $e->getMessage();
    }
}

// Gender/identity update 
if (isset($_POST['update_gender'])) {
    try {
        $allowed_genders = ['male', 'female', 'non-binary', 'prefer_not_to_say', 'other'];
        $new_gender = in_array($_POST['gender'], $allowed_genders) ? $_POST['gender'] : 'prefer_not_to_say';
        
        $stmt = $conn->prepare("UPDATE user_profile SET gender = ? WHERE user_id = ?");
        $stmt->bind_param("si", $new_gender, $_SESSION['user_id']);
        
        if (!$stmt->execute()) {
            throw new Exception("Gender update failed: " . $stmt->error);
        }
        
        $_SESSION['update_message'] = "Identity (gender) updated successfully!";
    } catch (Exception $e) {
        $_SESSION['update_message'] = $e->getMessage();
    }
}

// Location update 
if (isset($_POST['update_location'])) {
    try {
        $new_location = sanitizeInput($_POST['new_location']);
        
        $stmt = $conn->prepare("UPDATE user_profile SET user_location = ? WHERE user_id = ?");
        $stmt->bind_param("si", $new_location, $_SESSION['user_id']);
        
        if (!$stmt->execute()) {
            throw new Exception("Location update failed: " . $stmt->error);
        }
        
        $_SESSION['update_message'] = "Location updated successfully!";
    } catch (Exception $e) {
        $_SESSION['update_message'] = $e->getMessage();
    }
}

// Username update  
if (isset($_POST['save_username'])) {
    try {
        $new_username = sanitizeInput($_POST['new_username']);
        
        if (strlen($new_username) < 3 || strlen($new_username) > 50) {
            throw new Exception("Username must be between 3-50 characters!");
        }
        
        // Check if username already exists (excluding current user)
        $check_stmt = $conn->prepare("SELECT user_id FROM community_people WHERE username = ? AND user_id != ?");
        $check_stmt->bind_param("si", $new_username, $_SESSION['user_id']);
        $check_stmt->execute();
        
        if ($check_stmt->get_result()->num_rows > 0) {
            throw new Exception("Username already taken!");
        }
        
        $stmt = $conn->prepare("UPDATE community_people SET username = ? WHERE user_id = ?");
        $stmt->bind_param("si", $new_username, $_SESSION['user_id']);
        
        if (!$stmt->execute()) {
            throw new Exception("Username update failed: " . $stmt->error);
        }
        
        $_SESSION['update_message'] = "Username updated successfully!";
    } catch (Exception $e) {
        $_SESSION['update_message'] = $e->getMessage();
    }
}

// Profession update
if (isset($_POST['save_profession'])) {
    try {
        $new_profession = sanitizeInput($_POST['new_profession']);
        
        $stmt = $conn->prepare("UPDATE user_profile SET user_title = ? WHERE user_id = ?");
        $stmt->bind_param("si", $new_profession, $_SESSION['user_id']);
        
        if (!$stmt->execute()) {
            throw new Exception("Profession update failed: " . $stmt->error);
        }
        
        $_SESSION['update_message'] = "Profession updated successfully!";
    } catch (Exception $e) {
        $_SESSION['update_message'] = $e->getMessage();
    }
}

// Profile picture update
if (isset($_POST['update_profile_picture'])) {
    try {
       $targetDir = dirname(__DIR__, 2) . "/uploads/profiles/";
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        
        // Create directory if it doesn't exist
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        
        $filename = handleFileUpload($_FILES['profile_picture'], $targetDir, $allowedTypes);
        
        if ($filename) {
            // First get old filename to delete it
            $stmt = $conn->prepare("SELECT profile_photo FROM user_profile WHERE user_id = ?");
            $stmt->bind_param("i", $_SESSION['user_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $oldPhoto = $result->fetch_assoc()['profile_photo'];
            
            // Delete old photo if it exists
            if ($oldPhoto && file_exists($targetDir . $oldPhoto)) {
                unlink($targetDir . $oldPhoto);
            }
            
            // Update database with new filename
            $stmt = $conn->prepare("UPDATE user_profile SET profile_photo = ? WHERE user_id = ?");
            $stmt->bind_param("si", $filename, $_SESSION['user_id']);
            
            if (!$stmt->execute()) {
                throw new Exception("Profile picture update failed: " . $stmt->error);
            }
            
            $_SESSION['update_message'] = "Profile picture updated successfully!";
        } else {
            throw new Exception("No file was uploaded or there was an error.");
        }
    } catch (Exception $e) {
        $_SESSION['update_message'] = $e->getMessage();
    }
}

// Bio update
if (isset($_POST['update_bio'])) {
    try {
        $new_bio = sanitizeInput($_POST['new_bio']);
        
        $stmt = $conn->prepare("UPDATE user_profile SET bio = ? WHERE user_id = ?");
        $stmt->bind_param("si", $new_bio, $_SESSION['user_id']);
        
        if (!$stmt->execute()) {
            throw new Exception("Bio update failed: " . $stmt->error);
        }
        
        $_SESSION['update_message'] = "Bio updated successfully!";
    } catch (Exception $e) {
        $_SESSION['update_message'] = $e->getMessage();
    }
}

get_profile();
// After all updates, redirect back to profile page with current section
$redirectUrl = "../../user.php";
if (isset($_SESSION['current_section'])) {
    $redirectUrl .= "?cs=" . urlencode($_SESSION['current_section']);
}

// Store update message in session
if (isset($_SESSION['update_message'])) {
    $_SESSION['update_message'] = [
        'text' => $_SESSION['update_message'],
        'type' => isset($e) ? 'error' : 'success' // Determine if it's an error or success
    ];
}

header("Location: " . $redirectUrl);
exit();