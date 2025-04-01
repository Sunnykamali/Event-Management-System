<?php
session_start();
$error = isset($_SESSION['error']) ? $_SESSION['error'] : "";
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/Login.css">
    <script src="jawa/script.js" ></script>
</head>
<body>

    <div class="login-container">
        <div class="border-box"></div>
        <div class="form-header" id="formHeader">
            <span style="color: red;">👤</span> LOGIN <span style="color: red;">👤</span>
        </div>

        <?php if (!empty($error)): ?>
            <p class="error-msg" style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <!-- Login Form -->
        <form id="loginForm" method="POST" action="auth.php">
            <input type="email" name="email" class="input-box" placeholder="Email" required>
            <input type="password" name="password" class="input-box" placeholder="Password" required>
            <button type="submit" name="login" class="login-btn">Sign in</button>
            <div class="login-footer">
                <a href="#" onclick="switchForm('registerForm', 'REGISTRATION')">Sign up</a>
            </div>
        </form>

        <!-- Registration Form -->
        <form id="registerForm" method="POST" style="display: none;" action="auth.php" enctype="multipart/form-data">
            <input type="text" name="first_name" class="input-box" placeholder="First Name" required>
            <input type="text" name="last_name" class="input-box" placeholder="Last Name" required>
            <input type="text" name="contact_number" class="input-box" placeholder="Contact Number" required>
            <input type="email" name="email" class="input-box" placeholder="Email" required>
            <input type="password" name="password" class="input-box" placeholder="Password" required>
            <input type="password" name="confirm_password" class="input-box" placeholder="Confirm Password" required>
            <select name="event" class="input-box" required>
                <option value="">Select Event</option>
                <option value="Dance">Dance</option>
                <option value="Music">Music</option>
                <option value="Poetry">Poetry</option>
                <option value="Art">Art</option>
                <option value="Drama">Drama</option>
                <option value="Singing">Singing</option>
                <option value="Photography">Photography</option>
                <option value="Painting">Painting</option>
                <option value="Sports">Sports</option>
                <option value="Quiz">Quiz</option>
            </select>
            <input type="file" name="profile_pic" class="input-box" accept="image/*">
            <button type="submit" name="register" class="login-btn">Register</button>
        </form>
    </div>

</body>
</html>
