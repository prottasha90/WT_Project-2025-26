<?php

function sanitize($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validatePassword($password) {
    // Min 6 chars
    return strlen($password) >= 6;
}
?>
