<?php
// debug_check.php
// Access this via http://localhost/BeyondOrbit/debug_check.php

require_once 'models/Database.php';

echo "<h1>Debug System Check</h1>";

// 1. Check Database Connection
echo "<h2>1. Database Connection</h2>";
try {
    $conn = dbConnect();
    echo "<p style='color:green'>[PASS] Database Connected Successfully.</p>";
} catch (Exception $e) {
    echo "<p style='color:red'>[FAIL] Connection Error: " . $e->getMessage() . "</p>";
    die();
}

// 2. Check User Table
echo "<h2>2. User Table Check</h2>";
$email = 'director@beyondorbit.com';
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
    echo "<p style='color:green'>[PASS] Director user found in Database.</p>";
    echo "<pre>";
    print_r($row);
    echo "</pre>";

    // 3. Verify Password
    echo "<h2>3. Password Verification</h2>";
    $inputPassword = 'password123';
    if (password_verify($inputPassword, $row['password_hash'])) {
        echo "<p style='color:green'>[PASS] Password 'password123' MATCHES the hash in database.</p>";
    } else {
        echo "<p style='color:red'>[FAIL] Password 'password123' DOES NOT MATCH the hash.</p>";
        echo "<p>Generating new hash for 'password123': " . password_hash($inputPassword, PASSWORD_DEFAULT) . "</p>";
    }
} else {
    echo "<p style='color:red'>[FAIL] Director user NOT FOUND. Did you import schema.sql?</p>";
}
?>
