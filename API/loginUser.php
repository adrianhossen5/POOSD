<?php
session_start();
include "../conn.php";

if (isset($_SESSION['id'])) {
    unset($_SESSION['id']);
    session_destroy();
    header("location: ./index.php");
}

function getRequestInfo()
{
    return json_decode(file_get_contents('php://input'), true);
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


    $data = getRequestInfo();
    $user_name = $data['user_name'];
    $password = $data['password'];
    $errors = [];

    $response = array('success' => false, 'message' => 'Login failed');

    if (empty($user_name)) {
        $errors[] = "Username is required.";
        $response = array('success' => false, 'message' => 'Login failed');
        http_response_code(400); // Bad Request
    } else if (empty($password)) {
        $errors[] = "Password is required.";
        $response = array('success' => false, 'message' => 'Login failed');
        http_response_code(400); // Bad Request
    }

    if (empty($errors)) {
        $user_id = authenticateUser($conn, $user_name, $password);

        if ($user_id !== false) {
            $_SESSION['id'] = $user_id;
            $userObj['username'] = $user_name; // Make sure this matches the key in your JavaScript code
            $userObj['id'] = $_SESSION['id'];
            $response = array('success' => true, 'message' => 'Login successful', 'user' => $userObj);
            http_response_code(200); // OK
        } else {
            $error_message = "Invalid username or password";
            $response = array('success' => false, 'message' => $error_message);
            http_response_code(400); // Bad Request
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    header("location: /index.php");
}
