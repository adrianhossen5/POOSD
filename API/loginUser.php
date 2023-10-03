<?php
include "../conn.php";
session_start();

function isPostmanRequest()
{
    return isset($_SERVER['HTTP_USER_AGENT']) && 
        strpos($_SERVER['HTTP_USER_AGENT'], 'Postman') !== false;
}

function authenticateUser($conn, $username, $password)
{
    $sql = "SELECT id, username, password_hash FROM users WHERE username = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password_hash'])) {
            return $row['id'];
        }
    }

    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isPostmanRequest()) {
        echo "POST request received\n";
    }
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
        $user_id = authenticateUser($conn, $user_name, $_POST['password']);

        if ($user_id !== false) {
            $_SESSION['id'] = $user_id;
            if (isPostmanRequest()) {
                echo "Authentication successful for user id" . $user_id . "!\n";
            }
            echo "<script> window.location='../dashboard.php'; </script>";
            exit();
        } else {
            if (isPostmanRequest()) {
                echo "Authentication Failed!\n";
            }
            $error_message = "Invalid username or password";
            echo "<script>alert('Invalid username or password'); 
                window.location.href='../index.php'; </script>";
            exit();
        }
    } else {
        foreach ($errors as $error) {
            echo "<script> window.location='../index.php'; </script>";
            exit();
        }
    }
}
else {
    echo "<script> window.location='../index.php';</script>";
    exit();
}
?>