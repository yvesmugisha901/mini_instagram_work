<?php
session_start();
include 'config.php';


$errors = [];

if(isset($_POST['signup'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Validation
    if(empty($username)) $errors['username'] = "Username is required";
    if(empty($email)) $errors['email'] = "Email is required";
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Invalid email format";
    if(empty($password)) $errors['password'] = "Password is required";
    elseif(strlen($password) < 6) $errors['password'] = "Password must be at least 6 characters";
    if($password !== $confirm) $errors['confirm'] = "Passwords do not match";

    // Check if username or email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username=? OR email=?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows > 0) $errors['exists'] = "Username or email already taken";

    // Insert user if no errors
    if(empty($errors)){
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed);
        if($stmt->execute()){
            $_SESSION['user'] = $username;
            header("Location: signin.php");
            exit();
        } else {
            $errors['db'] = "Database error. Try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up - Instagram</title>

<!-- Integrated CSS -->
<style>
/* Basic reset */
* { margin: 0; padding: 0; box-sizing: border-box; }

/* Body style */
body {
    font-family: 'Arial', sans-serif;
    background: #fafafa;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Form container */
.container { display: flex; justify-content: center; align-items: center; width: 100%; }

/* Form box */
.form-box {
    background: white;
    padding: 40px;
    border: 1px solid #dbdbdb;
    border-radius: 10px;
    width: 350px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

/* Logo */
.logo {
    font-family: 'Lucida Handwriting', cursive;
    font-size: 36px;
    margin-bottom: 20px;
}

/* Inputs */
input {
    width: 100%;
    padding: 12px;
    margin: 8px 0;
    border-radius: 5px;
    border: 1px solid #dbdbdb;
    background: #fafafa;
    font-size: 14px;
}

/* Buttons */
button {
    width: 100%;
    padding: 12px;
    margin-top: 12px;
    border: none;
    border-radius: 5px;
    font-weight: bold;
    font-size: 14px;
    cursor: pointer;
    color: white;
    background: linear-gradient(45deg, #405DE6, #5851DB);
    transition: 0.3s;
}
button:hover { opacity: 0.9; }

/* Google button */
.google-btn {
    background: #4285F4;
    margin-top: 10px;
}

/* Error messages */
.error {
    color: red;
    font-size: 12px;
    margin-bottom: 5px;
    text-align: left;
}

/* Divider */
.divider {
    margin: 15px 0;
    color: #999;
    font-size: 12px;
}
</style>
</head>

<body>
<div class="container">
    <div class="form-box">
        <h1 class="logo">Instagram</h1>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
            <div class="error"><?= $errors['username'] ?? '' ?></div>

            <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            <div class="error"><?= $errors['email'] ?? '' ?></div>

            <input type="password" name="password" placeholder="Password">
            <div class="error"><?= $errors['password'] ?? '' ?></div>

            <input type="password" name="confirm_password" placeholder="Confirm Password">
            <div class="error"><?= $errors['confirm'] ?? '' ?></div>

            <div class="error"><?= $errors['exists'] ?? '' ?></div>
            <div class="error"><?= $errors['db'] ?? '' ?></div>

            <button type="submit" name="signup">Sign Up</button>
        </form>

        <div class="divider">OR</div>
        <button class="google-btn" onclick="googleLogin()">Sign Up with Google</button>

        <p>Already have an account? <a href="signin.php">Sign In</a></p>
    </div>
</div>

<script>
function googleLogin(){
    alert("Google login simulated!");
    window.location.href = "dashboard.php";
}
</script>
</body>
</html>
