<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['profile_pic'])) {
    $uploadDir = "../uploads/profile_pics/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create directory if not exists
    }

    $file = $_FILES['profile_pic'];
    $fileName = basename($file["name"]);
    $fileTmpName = $file["tmp_name"];
    $fileSize = $file["size"];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    // Validate file
    if (!in_array($fileExt, $allowed)) {
        $_SESSION['error'] = "Only JPG, JPEG, PNG, and GIF files are allowed!";
        header("Location: dashboard.php");
        exit();
    }

    if ($fileSize > 2 * 1024 * 1024) { // Limit file size to 2MB
        $_SESSION['error'] = "File size must be less than 2MB!";
        header("Location: dashboard.php");
        exit();
    }

    // Rename file to prevent conflicts
    $newFileName = "profile_" . $user_id . "." . $fileExt;
    $uploadPath = $uploadDir . $newFileName;

    if (move_uploaded_file($fileTmpName, $uploadPath)) {
        // Update user profile picture in the database
        $stmt = $conn->prepare("UPDATE users SET profile_pic = ? WHERE id = ?");
        $stmt->bind_param("si", $newFileName, $user_id);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Profile picture updated!";
        } else {
            $_SESSION['error'] = "Database update failed!";
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "File upload failed!";
    }
}

header("Location: dashboard.php");
exit();
?>
