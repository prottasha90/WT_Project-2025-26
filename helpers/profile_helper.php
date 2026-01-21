<?php

function getProfileImage($userId) {
    $jsonFile = __DIR__ . '/../data/user_images.json';
    $defaultImage = 'https://ui-avatars.com/api/?name=User&background=random'; // Use a default avatar service or local asset

    if (!file_exists($jsonFile)) {
        return $defaultImage;
    }

    $jsonData = file_get_contents($jsonFile);
    $images = json_decode($jsonData, true);

    if (isset($images[$userId])) {
        // Check if file actually exists in uploads
        $filePath = 'uploads/' . $images[$userId];
        if (file_exists(__DIR__ . '/../public/' . $filePath)) {
            return $filePath;
        }
    }

    // Attempt to get user initials for dynamic default
    // This would require fetching user data, but for simplicity here we default
    // ideally we pass the user name too, but let's stick to a generic one or simple logic
    return $defaultImage; 
}
?>
