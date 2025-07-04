<?php
function get_profile() {
    global $conn; 
    // Check if user_id is set in session
    if (!isset($_SESSION['user_id'])) {
        error_log("get_profile error: user_id not set in session");
        return;
    }
    $stmt = $conn->prepare("SELECT user_role, user_title, dob, gender, user_location, profile_photo, bio FROM user_profile WHERE user_id = ?");
    $stmt->bind_param('i', $_SESSION['user_id']);
    if ($stmt->execute()) {
        $profileResult = $stmt->get_result();
        if($profileResult->num_rows === 1) {
            $profileData = $profileResult->fetch_assoc();
            $_SESSION['role'] = $profileData['user_role'];
            $_SESSION['title'] = $profileData['user_title'];
            $_SESSION['dob'] = $profileData['dob'];
            $_SESSION['gender'] = $profileData['gender'];
            $_SESSION['location'] = $profileData['user_location'];
            $_SESSION['profile_photo'] = $profileData['profile_photo'];
            $_SESSION['bio'] = $profileData['bio'];
        }
    } else {
        error_log("get_profile error: " . $stmt->error);
    }
}

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    $data = nl2br($data);
    return $data;
}

function validate_session() {
    // Check if all required session variables are set
    if (!isset($_SESSION['user_id'], $_SESSION['logged_in'], $_SESSION['ip_address'], $_SESSION['user_agent'])) {
        return false;
    }
    
    // Check IP address (optional)
    if ($_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR']) {
        return false;
    }
    
    // Check user agent
    if ($_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
        return false;
    }
    
    // Check last activity (30 minute timeout)
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
        return false;
    }
    
    // Update last activity
    $_SESSION['last_activity'] = time();
    
    return true;
}

function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validate_csrf_token($token) {
    return isset($_SESSION['csrf_token'], $token) && hash_equals($_SESSION['csrf_token'], $token);
}

function format_time($timestamp) {
    $time_diff = time() - $timestamp;
    $seconds = $time_diff;
    $minutes = floor($seconds / 60);
    $hours = floor($minutes / 60);
    $days = floor($hours / 24);
    $weeks = floor($days / 7);
    $months = floor($weeks / 4);
    $years = floor($months / 12);

    if ($seconds < 60) {
        return 'just now';
    } elseif ($minutes < 60) {
        return $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ago';
    } elseif ($hours < 24) {
        return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
    } elseif ($days < 7) {
        return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
    } elseif ($weeks < 4) {
        return $weeks . ' week' . ($weeks > 1 ? 's' : '') . ' ago';
    } elseif ($months < 12) {
        return $months . ' month' . ($months > 1 ? 's' : '') . ' ago';
    } else {
        return date('j F Y', $timestamp);
    }
}