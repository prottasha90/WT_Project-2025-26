<?php

require_once '../helpers/auth_helper.php';

// Handle Profile Picture Upload
if ($action === 'upload_profile_pic') {
    requireLogin();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_pic'])) {
        $userId = $_SESSION['user_id'];
        $targetDir = "../public/uploads/";
        $jsonFile = "../data/user_images.json";
        
        $file = $_FILES['profile_pic'];
        $fileName = basename($file["name"]);
        $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        // Generate unique filename
        $newFileName = "profile_" . $userId . "_" . time() . "." . $imageFileType;
        $targetFile = $targetDir . $newFileName;
        
        $uploadOk = 1;
        $errorMsg = "";

        // Check if image file is a actual image or fake image
        $check = getimagesize($file["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $errorMsg = "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size (Limit to 5MB)
        if ($file["size"] > 5000000) {
            $errorMsg = "Sorry, your file is too large (Max 5MB).";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            $errorMsg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            header("Location: index.php?action=profile&error=" . urlencode($errorMsg));
            exit();
        } else {
            if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                
                // Update JSON map
                $jsonData = file_exists($jsonFile) ? file_get_contents($jsonFile) : "{}";
                $images = json_decode($jsonData, true) ?? [];
                
                // Remove old image if exists to save space (Optional, but good practice)
                if (isset($images[$userId])) {
                    $oldFile = $targetDir . $images[$userId];
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }

                $images[$userId] = $newFileName;
                file_put_contents($jsonFile, json_encode($images, JSON_PRETTY_PRINT));

                header("Location: index.php?action=profile&success=Profile Picture Updated");
                exit();
            } else {
                header("Location: index.php?action=profile&error=Sorry, there was an error uploading your file.");
                exit();
            }
        }
    } else {
         header("Location: index.php?action=profile");
         exit();
    }
}
?>
