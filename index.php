<!-- <?php
session_start();

include "conn.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function authenticateUser($conn, $username, $password)
{
    $sql = "SELECT id, username, password_hash FROM users WHERE username = ?";

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
            echo "yyyy";
        } else {
            echo "nnnn";
        }
        if (password_verify($password, $row['password_hash'])) {
            echo "Authentication successful!<br>";

            return $row['id'];
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
            $_SESSION['id'] = $user_id;
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
            font-family: MonoLisa, sans-serif;
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
            margin-bottom: 30px;
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
            margin-bottom: 20px;
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
                <input type="text" id="user_name" name="user_name" placeholder="Enter your user name" 
                required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" 
                required>
            </div>

            <div class="remember-me">
                <a href="forgot.php" style="text-align:middle">Forgot Password?</a>
            </div>  

            <button class="login-button" type="submit" name="submit">Login</button>
        </form>
        <div class="register-link">
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </div>
    </div>
</body>
</html> -->

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <header class="login-header" style="text-align:center; padding-top: 56px;">
        <h1>My Contacts Hub</h1>
    </header>
</head>

<body>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Raleway:400,700');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Raleway, sans-serif;
        }

        body {
            background: linear-gradient(90deg, #C7C5F4, #776BCC);
        }

        .container_index {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 70vh;
        }

        .screen {
            background: linear-gradient(90deg, #5D54A4, #7C78B8);
            position: relative;
            height: 424px;
            width: 360px;
            box-shadow: 0px 0px 24px #5C5696;
        }

        .screen-content {
            z-index: 1;
            position: relative;
            height: 100%;
        }

        .screen-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0;
            -webkit-clip-path: inset(0 0 0 0);
            clip-path: inset(0 0 0 0);
        }

        .screen-background-shape {
            transform: rotate(45deg);
            position: absolute;
        }

        .screen-background-shape1 {
            height: 400px;
            width: 520px;
            background: #FFF;
            top: -50px;
            right: 120px;
            border-radius: 0 72px 0 0;
        }

        .screen-background-shape2 {
            height: 220px;
            width: 220px;
            background: #6C63AC;
            top: -172px;
            right: 0;
            border-radius: 32px;
        }

        .screen-background-shape3 {
            height: 540px;
            width: 190px;
            background: linear-gradient(270deg, #5D54A4, #6A679E);
            top: -24px;
            right: 0;
            border-radius: 32px;
        }

        .screen-background-shape4 {
            height: 400px;
            width: 200px;
            background: #7E7BB9;
            top: 420px;
            right: 50px;
            border-radius: 60px;
        }

        .login {
            width: 320px;
            padding-left: 36px;
            padding-top: 64px;
        }

        .login-field {
            padding: 20px 0px;
            position: relative;
        }

        .login-icon {
            position: absolute;
            top: 30px;
            color: #7875B5;
        }

        .login-input {
            border: none;
            font-size: 16px;
            border-bottom: 2px solid #D1D1D4;
            color: #FFF;
            background: none;
            padding: 10px;
            padding-left: 12px;
            font-weight: 700;
            width: 100%;
            transition: .2s;
        }

        .login-input:active,
        .login-input:focus,
        .login-input:hover {
            outline: none;
            border-bottom-color: #6A679E;
        }

        .login-submit {
            background: #fff;
            text-align: center;
            font-size: 16px;
            margin-top: 20px;
            padding: 15px;
            border-radius: 26px;
            border: 1px solid #D4D3E8;
            text-transform: uppercase;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Center horizontally */
            width: 100%;
            color: #4C489D;
            box-shadow: 0px 2px 2px #5C5696;
            cursor: pointer;
            transition: .2s;
        }

        .login-header {
            background: #fff;
            text-align: center;
            font-size: 16px;
            padding: 48px;
            border: 1px solid #D4D3E8;
            text-transform: uppercase;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            color: #4C489D;
            box-shadow: 0px 2px 2px #5C5696;
            cursor: pointer;
            transition: .2s;
        }

        .login-submit:hover {
            border-color: #6A679E;
            outline: none;
        }

        .button-icon {
            font-size: 24px;
            color: #7875B5;
        }

        input::placeholder {
            color: white;
        }
    </style>
    <div class="container_index">
        <div class="screen">
            <div class="screen-content">

                <form class="login" method="post">
                    <div class="login-field">
                        <input type="text" class="login-input" id="user_name" name="user_name"
                            placeholder="Enter your username" required>
                    </div>
                    <div class="login-field">
                        <input type="password" class="login-input" id="password" name="password"
                            placeholder="Enter your password" required>
                    </div>
                    <button class="login-button login-submit" type="submit" name="submit">
                        Log in <i class="button-icon fas fa-chevron-right"></i>
                    </button>
                    <div style="padding-left: 12px; padding-top: 24px; ">
                        <p style="color: #FFF; font-weight: 650;">Don't have an account?
                            <a style="color: #FFF" href="register.php">Register</a>
                        </p>
                        <i class="button-icon fas fa-chevron-right"></i>
                    </div>
                </form>
            </div>
            <div class="screen-background">
                <span class="screen-background-shape screen-background-shape4"></span>
                <span class="screen-background-shape screen-background-shape3"></span>
                <span class="screen-background-shape screen-background-shape2"></span>
            </div>
        </div>
    </div>
</body>

</html>