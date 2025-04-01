<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // LOGIN PROCESS
    if (isset($_POST['login'])) {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Invalid email format!";
            header("Location: login.php");
            exit();
        }

        $stmt = $conn->prepare("SELECT id, first_name, last_name, contact_number, email, password, event, profile_pic, created_at FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // ✅ Store user details in the session
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user'] = $row['first_name'];
                $_SESSION['last_name'] = $row['last_name'];
                $_SESSION['contact_number'] = $row['contact_number'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['event'] = $row['event'];
                $_SESSION['profile_pic'] = $row['profile_pic'] ?: "default.png";
                $_SESSION['registration_date'] = date("F j, Y", strtotime($row['created_at']));

                header("Location: homepage.php");
                exit();
            } else {
                $_SESSION['error'] = "Incorrect password!";
            }
        } else {
            $_SESSION['error'] = "No user found with this email!";
        }
        $stmt->close();
        header("Location: login.php");
        exit();
    }

    // REGISTRATION PROCESS
    if (isset($_POST['register'])) {
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $contact_number = trim($_POST['contact_number']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);
        $event = trim($_POST['event']);

        if ($password !== $confirm_password) {
            $_SESSION['error'] = "Passwords do not match!";
            header("Location: login.php");
            exit();
        }

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $profile_pic = "default.png";

        // Handle Profile Picture Upload
        if (!empty($_FILES["profile_pic"]["name"])) {
            $target_dir = "uploads/profile_pics/";
            if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

            $profile_pic = time() . "_" . basename($_FILES["profile_pic"]["name"]);
            $target_file = $target_dir . $profile_pic;

            // Validate File Type (Optional)
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $file_type = mime_content_type($_FILES["profile_pic"]["tmp_name"]);
            if (!in_array($file_type, $allowed_types)) {
                $_SESSION['error'] = "Invalid file type for profile picture!";
                header("Location: login.php");
                exit();
            }

            if (!move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
                $_SESSION['error'] = "Failed to upload profile picture!";
                header("Location: login.php");
                exit();
            }
        }

        // Check if the email already exists
        $check_email_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check_email_stmt->bind_param("s", $email);
        $check_email_stmt->execute();
        $check_email_result = $check_email_stmt->get_result();
        if ($check_email_result->num_rows > 0) {
            $_SESSION['error'] = "Email is already registered!";
            header("Location: login.php");
            exit();
        }

        // Insert user data into the database
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, contact_number, email, password, event, profile_pic, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssssss", $first_name, $last_name, $contact_number, $email, $hashed_password, $event, $profile_pic);

        if ($stmt->execute()) {
            // ✅ Retrieve the inserted user ID
            $user_id = $stmt->insert_id;

            // ✅ Store user details in the session
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user'] = $first_name;
            $_SESSION['last_name'] = $last_name;
            $_SESSION['contact_number'] = $contact_number;
            $_SESSION['email'] = $email;
            $_SESSION['event'] = $event;
            $_SESSION['profile_pic'] = $profile_pic;
            $_SESSION['registration_date'] = date("F j, Y");

            header("Location: homepage.php");
            exit();
        } else {
            $_SESSION['error'] = "Registration failed!";
        }
        $stmt->close();
    }

    header("Location: login.php");
    exit();
}
?>
