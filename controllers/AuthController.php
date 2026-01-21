<?php

require_once '../models/User.php';
require_once '../helpers/auth_helper.php';

// Handle Login Submission
if ($action === 'login_post') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Simple validation
    if (empty($email) || empty($password)) {
        header("Location: index.php?action=login&error=Fields cannot be empty");
        exit();
    }

    $conn = dbConnect();
    $user = verifyUser($conn, $email, $password);

    if ($user) {
        startSession();
        session_regenerate_id(true); // Prevent session fixation
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];

        // set cookie if requested
        if (isset($_POST['remember_me'])) {
             // Set cookie for 30 days
             // Ideally we should use a token table, but for simplicity/student: base64 ID
             $cookieValue = base64_encode($user['id']);
             setcookie('remember_me', $cookieValue, time() + (86400 * 30), "/"); 
        }

        if ($user['role'] === 'director') {
            header("Location: index.php?action=admin_dashboard");
        } else {
            header("Location: index.php?action=astronaut_dashboard");
        }
    } else {
        header("Location: index.php?action=login&error=Invalid credentials");
    }
}

// Handle Register Submission
if ($action === 'register_post') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Basic Validation
    if (empty($fullname) || empty($email) || empty($password)) {
        header("Location: index.php?action=register&error=All fields are required");
        exit();
    }

    $conn = dbConnect();
    
    // Check if user exists
    if (findUserByEmail($conn, $email)) {
        header("Location: index.php?action=register&error=Email already registered");
        exit();
    }

    // Create User
    if (createUser($conn, $fullname, $email, $password, $role)) {
        header("Location: index.php?action=login&success=Registration successful. Please login.");
    } else {
        header("Location: index.php?action=register&error=System error during registration");
    }
}

// Handle Password Update
if ($action === 'update_password_post') {
    requireLogin(); // Ensure user is logged in
    $userId = $_SESSION['user_id'];
    $newPassword = $_POST['new_password'];

    if (strlen($newPassword) < 6) {
        header("Location: index.php?action=profile&error=Password too short");
        exit();
    }

    $conn = dbConnect();
    if (updatePassword($conn, $userId, $newPassword)) {
        header("Location: index.php?action=profile&success=Password updated successfully");
    } else {
        header("Location: index.php?action=profile&error=Update failed");
    }
}
?>
