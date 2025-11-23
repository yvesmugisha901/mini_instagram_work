<?php
session_start();
include 'config.php';

$errors = [];

if(isset($_POST['login'])){
    $user = trim($_POST['user']);
    $pass = $_POST['password'];

    // Validation
    if(empty($user)) $errors['user'] = "Username or email required";
    if(empty($pass)) $errors['password'] = "Password required";

    if(empty($errors)){
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=? OR email=?");
        $stmt->bind_param("ss", $user, $user);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            if(password_verify($pass, $row['password'])){
                $_SESSION['user'] = $row['username'];
                header("Location: dashboard.php");
                exit();
            } else {
                $errors['login'] = "Wrong password";
            }
        } else {
            $errors['login'] = "Account not found";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign In - Instagram</title>

<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body {
    font-family: 'Arial', sans-serif;
    background: #fafafa;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.container { display: flex; justify-content: center; align-items: center; width: 100%; }
.form-box {
    background: white;
    padding: 40px;
    border: 1px solid #dbdbdb;
    border-radius: 10px;
    width: 350px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}
.logo {
    font-family: 'Lucida Handwriting', cursive;
    font-size: 36px;
    margin-bottom: 20px;
}
input {
    width: 100%;
    padding: 12px;
    margin: 8px 0;
    border-radius: 5px;
    border: 1px solid #dbdbdb;
    background: #fafafa;
    font-size: 14px;
}
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
.google-btn {
    background: #4285F4;
    margin-top: 10px;
}
.error {
    color: red;
    font-size: 12px;
    margin-bottom: 5px;
    text-align: left;
}
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
            <input type="text" name="user" placeholder="Username or Email" value="<?= htmlspecialchars($_POST['user'] ?? '') ?>">
            <div class="error"><?= $errors['user'] ?? '' ?></div>

            <input type="password" name="password" placeholder="Password">
            <div class="error"><?= $errors['password'] ?? '' ?></div>

            <div class="error"><?= $errors['login'] ?? '' ?></div>

            <button type="submit" name="login">Sign In</button>
        </form>

        <div class="divider">OR</div>
        <button class="google-btn" onclick="googleLogin()">Sign In with Google</button>

        <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
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
