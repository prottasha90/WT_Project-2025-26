<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beyond Orbit | Mission Management</title>
    <link rel="stylesheet" href="css/style.css">
    
    <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'director'): ?>
        <link rel="stylesheet" href="css/admin.css">
    <?php elseif(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'astronaut'): ?>
        <link rel="stylesheet" href="css/astronaut.css">
    <?php endif; ?>
</head>
<body>

<header>
    <div class="logo">Beyond Orbit</div>
    <nav>
        <?php if(isLoggedIn()): ?>
            <?php if($_SESSION['user_role'] == 'director'): ?>
                <a href="index.php?action=admin_dashboard">Dashboard</a>
                <a href="index.php?action=manage_missions">Missions</a>
                <a href="index.php?action=assign_astronaut">Assignments</a>
                <a href="index.php?action=manage_supplies">Logistics</a>
            <?php else: ?>
                <a href="index.php?action=astronaut_dashboard">Dashboard</a>
                <a href="index.php?action=my_missions">My Missions</a>
                <a href="index.php?action=request_supply">Supplies</a>
            <?php endif; ?>
            <a href="index.php?action=profile">Profile</a>
            <a href="index.php?action=logout" style="color: var(--accent-color);">Logout</a>
        <?php else: ?>
            <a href="index.php?action=login">Login</a>
            <a href="index.php?action=register">Register</a>
        <?php endif; ?>
    </nav>
</header>

<main class="container">
