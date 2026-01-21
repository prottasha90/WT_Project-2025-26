<?php

function dbConnect() {
    $host = 'localhost';
    $dbname = 'beyond_orbit_db';
    $username = 'root'; // Default XAMPP username
    $password = '';     // Default XAMPP password

    $conn = mysqli_connect($host, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    return $conn;
}
?>
