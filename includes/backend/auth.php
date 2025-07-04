<?php
// session starts with config.php 
require_once('init.php');
require_once('config.php');
require_once('functions.php');

if (isset($_POST['signup'])) {
    // Validate CSRF token
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        die("CSRF token validation failed");
    }

    $username = trim($_POST['username']);
    $email = strtolower(trim($_POST['email']));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email exists
    $check_stmt = $conn->prepare("SELECT user_id, email FROM community_people WHERE LOWER(email) = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        $_SESSION['email_error'] = "Email is already registered, please use a different one";
        header("Location: ../../signup.php");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO community_people (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);
    $stmt->execute();

    $last_id = $conn->insert_id;

    // Set secure session
    session_regenerate_id(true);
    $_SESSION['user_id'] = $last_id;
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['logged_in'] = true;
    $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
    $_SESSION['last_activity'] = time();

    // Set secure cookie
    setcookie(
        'user_id', 
        $last_id, 
        [
            'expires' => time() + (86400 * 30),
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]
    );

    // Create profile with default data
    $role = "Public User";
    $title = "Unknown";
    $dob = "Unknown";
    $gender = "Unknown";
    $location = "Unknown";
    $photo = "/includes/images/default_profile.jpg";
    $bio = "Hey there, I'm a member of the ULAVi.Online!";

    $profileStmt = $conn->prepare("INSERT INTO user_profile (user_id, user_role, user_title, dob, gender, user_location, profile_photo, bio) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $profileStmt->bind_param("isssssss", $last_id, $role, $title, $dob, $gender, $location, $photo, $bio);
    $profileStmt->execute();
    $profileStmt->close();

    get_profile();
    unset($_SESSION['email_error']);
    $_SESSION['account-success'] = 'Account created successfully!';
    header("Location: ../../user_info1.php");
    exit();
}

if (isset($_POST['signin'])) {
    // Validate CSRF token first
    if (empty($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
        $_SESSION['signin_error'] = "Security token invalid. Please try again.";
        header("Location: ../../signin.php");
        exit();
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($password) || empty($email)) {
        $_SESSION['signin_error'] = "Please fill in all fields";
    } else {
        $stmt = $conn->prepare("SELECT * FROM community_people WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $userdata = $result->fetch_assoc();

            if (password_verify($password, $userdata['password'])) {
                // Regenerate session ID
                session_regenerate_id(true);
                
                $_SESSION['user_id'] = $userdata['user_id'];
                $_SESSION['username'] = $userdata['username'];
                $_SESSION['email'] = $userdata['email'];
                $_SESSION['logged_in'] = true;
                $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
                $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
                $_SESSION['last_activity'] = time();

                // Set secure cookie
                setcookie(
                    'user_id', 
                    $userdata['user_id'], 
                    [
                        'expires' => time() + (86400 * 30),
                        'path' => '/',
                        'secure' => true,
                        'httponly' => true,
                        'samesite' => 'Strict'
                    ]
                );

                get_profile();
                unset($_SESSION['signin_error']);
                header("Location: ../../home.php");
                exit();
            } else {
                $_SESSION['signin_error'] = "Invalid password";
            }
        } else {
            $_SESSION['signin_error'] = "Email not found";
        }
    }
    header("Location: ../../signin.php");
    exit();
}

if (isset($_POST['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Delete session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(), 
            '', 
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    // Destroy the session
    session_destroy();

    // Delete user_id cookie
    setcookie('user_id', '', time() - 3600, '/');

    header("Location: ../../signin.php");
    exit();
}