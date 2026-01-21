<?php

function startSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Check for cookie if session is not set
    if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_me'])) {
        // Decode cookie (In a real app, use a secure token, but for student level, we decode the ID carefully)
        // Format: encoded user_id
        $userId = base64_decode($_COOKIE['remember_me']);
        if (is_numeric($userId)) {
             $conn = dbConnect();
             $user = getUserById($conn, $userId);
             if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
             }
        }
    }
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: index.php?action=login");
        exit();
    }
}

function requireRole($role) {
    requireLogin();
    if ($_SESSION['user_role'] !== $role) {
        // Redirect to their own dashboard if they try to access unauthorized pages
        if ($_SESSION['user_role'] === 'director') {
            header("Location: index.php?action=admin_dashboard");
        } else {
            header("Location: index.php?action=astronaut_dashboard");
        }
        exit();
    }
}

function logout() {
    // 1. Unset all session variables
    $_SESSION = array();

    // 2. Delete the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // 3. Destroy Session
    session_destroy();

    // 4. Delete Remember Me Cookie
    if (isset($_COOKIE['remember_me'])) {
        setcookie('remember_me', '', time() - 3600, "/");
        unset($_COOKIE['remember_me']); // Unset from current request
    }

    // 5. Redirect
    header("Location: index.php?action=login");
    exit();
}
?>
