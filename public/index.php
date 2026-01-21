<?php
// Main Entry Point (Router)

require_once '../helpers/auth_helper.php';
require_once '../helpers/profile_helper.php';
require_once '../models/Database.php';
require_once '../models/User.php';

startSession();

// Get the action from URL, default to login
$action = isset($_GET['action']) ? $_GET['action'] : 'login';

// Routing
switch ($action) {
    case 'login':
        if (isLoggedIn()) {
            // content negotiation based on role if they are already logged in
            if ($_SESSION['user_role'] === 'director') {
                header("Location: index.php?action=admin_dashboard");
            } else {
                header("Location: index.php?action=astronaut_dashboard");
            }
            exit();
        }
        include '../views/auth/login.php';
        break;

    case 'register':
        include '../views/auth/register.php';
        break;

    // POST Actions
    case 'login_post':
    case 'register_post':
    case 'update_password_post':
        include '../controllers/AuthController.php';
        break;

    case 'upload_profile_pic':
        include '../controllers/ProfileController.php';
        break;
        
    case 'profile':
        requireLogin();
        include '../views/common/profile.php';
        break;

    case 'logout':
        logout();
        break;

    // Director Routes
    case 'admin_dashboard':
        requireRole('director');
        include '../controllers/AdminController.php'; // Will load Logic + View
        break;
    
    case 'manage_missions':
    case 'create_mission':
    case 'edit_mission':
    case 'delete_mission':
        requireRole('director');
        include '../controllers/AdminController.php';
        break;

    case 'assign_astronaut':
    case 'process_assignment':
    case 'api_get_recent_logs':
    case 'manage_supplies':
        requireRole('director');
        include '../controllers/AdminController.php';
        break;

    // Astronaut Routes
    case 'astronaut_dashboard':
        requireRole('astronaut');
        include '../controllers/AstronautController.php';
        break;

    case 'my_missions':
    case 'submit_log':
        requireRole('astronaut');
        include '../controllers/AstronautController.php';
        break;
    
    case 'request_supply':
        requireRole('astronaut');
        include '../controllers/AstronautController.php';
        break;

    default:
        // 404 or default
        include '../views/auth/login.php';
        break;
}
?>
