<?php
include "../conn.php";

function isPostmanRequest()
{
    return isset($_SERVER['HTTP_USER_AGENT']) && 
    strpos($_SERVER['HTTP_USER_AGENT'], 'Postman') !== false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isPostmanRequest()) {
        echo "POST request received\n";
    }

    $username = $_POST['user_name'];
    $password = $_POST['password'];
    $confirm_password = $_POST["confirm_password"];
    $email = $_POST['email'];
    $agree = isset($_POST['agree']) ? 1 : 0;

    $errors = [];

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match. Please try again.'); 
            window.location='../register.php';</script>";
    } else {
        $sql = 'SELECT username FROM users WHERE username = ?';

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $alert = "<script>alert('This username is already taken!'); 
                window.location='../register.php';</script>";
            echo $alert;
            exit();
        }

        $stmt->close();

        $sql = 'SELECT email FROM users WHERE email = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $alert = "<script>alert('This email is already taken!');
                window.location='../register.php';</script>";
            echo $alert;
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $alert = "<script>alert('Wrong email format'); 
                window.location='../register.php';</script>";
            echo $alert;
            exit();
        }

        $stmt->close();

        $sql = 'SELECT id, username, password_hash FROM users WHERE username = ?';
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO `users` (`id`, `username`, `password_hash`, `email`) 
        VALUES (UUID(), ?, ?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $username, $hashed_password, $email);

        if ($stmt->execute()) {
            if (isPostmanRequest()) {
                echo 'Registration successful!';
            }
            echo '<script> window.location="../index.php";</script>';
            exit();
        } else {
            if (isPostmanRequest()) {
                echo "Registration failed!\n";
            }
            echo '<script>alert("Registration failed!"); 
                window.location="../register.php";</script>';
        }

        $stmt->close();
    }
}
