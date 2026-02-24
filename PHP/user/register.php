<?php
session_start();
require(__DIR__ . '/../config/db.php');

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    if ($password !== $confirm) {
        $_SESSION['error'] = "Passwords do not match!";
        header("Location: register.php");
        exit();
    }

    $check = mysqli_query($conn, "SELECT * FROM registration WHERE username='$username' OR email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $_SESSION['error'] = "Username or email already exists!";
        header("Location: register.php");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $insert = mysqli_query($conn, "INSERT INTO registration (username, email, password, role) 
        VALUES ('$username', '$email', '$hashed_password', 'user')");

    if ($insert) {
        $_SESSION['success'] = "Registration successful! You can login now.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error'] = "Something went wrong!";
        header("Location: register.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register - BikeXo</title>

<style>

/* Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

/* Background */
body {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
}

/* Register Box */
.register-box {
    width: 400px;
    padding: 40px;
    border-radius: 15px;
    background: #ffffff;
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    animation: slideUp 0.6s ease;
}

/* Animation */
@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Heading */
.register-box h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #2c5364;
}

/* Inputs */
.register-box input {
    width: 100%;
    padding: 12px;
    margin-bottom: 18px;
    border-radius: 8px;
    border: 1px solid #ccc;
    outline: none;
    font-size: 14px;
    transition: 0.3s;
}

.register-box input:focus {
    border-color: #2c5364;
    box-shadow: 0 0 8px rgba(44,83,100,0.3);
}

/* Button */
.register-box button {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: none;
    background: linear-gradient(135deg, #2c5364, #203a43);
    color: #fff;
    font-size: 15px;
    cursor: pointer;
    transition: 0.3s;
}

.register-box button:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 15px rgba(0,0,0,0.3);
}

/* Error Message */
.error {
    background: #ffe0e0;
    color: #d8000c;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
    text-align: center;
    font-size: 14px;
}

/* Success Message */
.success {
    background: #e0ffe5;
    color: #2e7d32;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
    text-align: center;
    font-size: 14px;
}

</style>

</head>
<body>

<div class="register-box">
<h2>Create Account</h2>

<?php
if(isset($_SESSION['error'])) { 
    echo "<p class='error'>".$_SESSION['error']."</p>"; 
    unset($_SESSION['error']); 
}
if(isset($_SESSION['success'])) { 
    echo "<p class='success'>".$_SESSION['success']."</p>"; 
    unset($_SESSION['success']); 
}
?>

<form action="register.php" method="POST">
<input type="text" name="username" placeholder="Username" required>
<input type="email" name="email" placeholder="Email Address" required>
<input type="password" name="password" placeholder="Password" required>
<input type="password" name="confirm" placeholder="Confirm Password" required>
<button type="submit" name="register">Register</button>
<p>Already have an account? <a href="login.php">Login</a></p>
</form>

</div>

</body>
</html>
