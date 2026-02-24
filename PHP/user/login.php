<?php
session_start();
require(__DIR__ . '/../config/db.php');

if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM registration WHERE username='$username' OR email='$username' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1){
        $user = mysqli_fetch_assoc($result);

        if(password_verify($password, $user['password'])){

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if($user['role'] == 'admin'){
                header("Location:/admin/dashboard.php");
            } else {
                header("Location:/BikeXo/index.html");
            }
            exit();
        } else {
            $_SESSION['error'] = "Incorrect password!";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "User not found!";
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - BikeXo</title>

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

/* Login Box */
.login-box {
    width: 400px;
    padding: 40px;
    border-radius: 15px;
    background: #ffffff;
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    animation: fadeIn 0.6s ease;
}

/* Animation */
@keyframes fadeIn {
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
.login-box h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #2c5364;
}

/* Inputs */
.login-box input {
    width: 100%;
    padding: 12px;
    margin-bottom: 18px;
    border-radius: 8px;
    border: 1px solid #ccc;
    outline: none;
    font-size: 14px;
    transition: 0.3s;
}

.login-box input:focus {
    border-color: #2c5364;
    box-shadow: 0 0 8px rgba(44,83,100,0.3);
}

/* Button */
.login-box button {
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

.login-box button:hover {
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
</style>

</head>
<body>

<div class="login-box">
<h2>Welcome Back</h2>

<?php
if(isset($_SESSION['error'])) { 
    echo "<p class='error'>".$_SESSION['error']."</p>"; 
    unset($_SESSION['error']); 
}
?>

<form action="login.php" method="POST">
<input type="text" name="username" placeholder="Username or Email" required>
<input type="password" name="password" placeholder="Password" required>
<button type="submit" name="login">Login</button>
</form>

</div>

</body>
</html>