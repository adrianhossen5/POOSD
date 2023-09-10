<?php
include "conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $email = $_POST["email"]; 
    $agree = isset($_POST["agree"]) ? 1 : 0;

    $errors = [];

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match. Please try again.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO `users` (`username`, `password_hash`, `email`) 
        VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $hashed_password, $email);

    if ($stmt->execute()) {
        echo "Registration successful!";
        header("Location: index.php");
            exit;
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registration</title>
    <link rel="stylesheet" href="styles.css">
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

        .registration-container {
            background-color: #ffffff;
            width: 400px;
            margin: 100px auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .registration-title {
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
        input[type="password"],
        input[type="confirm_password"] {
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

        .login-link {
            text-align: center;
            margin-top: 15px;
        }

        /* .login-link a {
            text-decoration: none;
            
        } */
    </style>
</head>
<body>
    <div class="registration-container">
        <h2>Sign Up</h2>
        <form method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required><br>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required><br>
            
            <label for="agree">
                <input type="checkbox" id="agree" name="agree" required> I agree to the terms and conditions
            </label><br>

            <input type="submit" value="Sign Up">
            <div class="login-link">
                <p>Already have an account? <a href="index.php">Login</a></p>
            </div>
        </form>
    </div>
</body>
</html>
