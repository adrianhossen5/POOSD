<?php
session_start();

include "conn.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function authenticateUser($conn, $username, $password) {
    $sql = "SELECT user_id, username, password_hash FROM users WHERE username = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        echo "Stored Password Hash: " . $row['password_hash'] . "<br>";
        echo "User-Provided Password: " . $password . "<br>";
        $flag = password_verify($password, $row['password_hash']);
        if ($flag) {
            echo"yyyy";
        } else {
            echo"nnnn";
        }
        if (password_verify($password, $row['password_hash'])) {
            echo "Authentication successful!<br>";

            return $row['user_id'];
        }
    }
    echo "Authentication failed<br>";
    return false;
}


    if (isset($_POST['submit'])) {
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    $errors = [];

    if (empty($user_name)) {
        $errors[] = "Username is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }
    if (empty($errors)) {
        // Authenticate the user
    $user_id = authenticateUser($conn, $user_name, $_POST['password']);

        if ($user_id !== false) {
            // Authentication successful
            $_SESSION['user_id'] = $user_id;
            echo "Authentication successful"; 
            header("Location: dashboard.php");
            exit;
        } else {
            $error_message = "Invalid username or password";
        }
    } else {
        foreach ($errors as $error) {
            $error_message .= $error . "<br>";
        }
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <header>
        <h1>My Contacts Hub</h1>
    </header>
    
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #ffffff;
        }

        header {
            background-color: #007bff;
            text-align: center;
            padding: 20px 0;
            color: #fff;
        }

        .login-container {
            background-color: #ffffff;
            width: 400px;
            margin: 100px auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .login-title {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }

        .login-form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-size: 16px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 95%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
        }

        input[type="checkbox"] {
            margin-right: 5px;
        }

        .remember-me {
            font-size: 14px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .remember-me label {
            margin-right: 5px;
        }

        .login-button {
            background-color: #007BFF;
            color: #ffffff;
            font-size: 16px;
            padding: 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
        }

        .register-link a {
            text-decoration: none;
            color: #007BFF;
        }
    </style>
</head>

    
<body>
    
    <div class="login-container">
        <h2 class="login-title">Login</h2>
        <form class="login-form" method="post">
            <div class="form-group">
                <label for="user_name">User Name:</label>
                <input type="text" id="user_name" name="user_name" placeholder="Enter your user name" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <div class="remember-me">
                <input type="checkbox" id="remember_me" name="remember_me">
                <label for="remember_me">Remember Me</label>
                <a href="forgot.php" style="margin-left: auto;">Forgot Password?</a>
            </div>  

            <button class="login-button" type="submit" name="submit">Login</button>
        </form>

        <div class="register-link">
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </div>
    </div>
</body>
</html>
