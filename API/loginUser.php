<?php
include "../conn.php";
session_start();

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

    return false;
}

if (isset($_POST['submit'])) {
    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION['id'];
    }
    else {
        header('Location: ../index.php');
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
        // Authenticate the user
        $user_id = authenticateUser($conn, $user_name, $_POST['password']);

        if ($user_id !== false) {
            // Authentication successful
            $_SESSION['id'] = $user_id;
            echo "Authentication successful";
            header("Location: ../dashboard.php");
            exit();
        } else {
            $error_message = "Invalid username or password";
            echo "<script>alert('Invalid username or password'); 
                window.location='../index.php'; </script>";
            exit();
        }
    } else {
        foreach ($errors as $error) {
            $error_message .= $error . "<br>";
            header("Location: ../index.php");
        }
    }
}
?>