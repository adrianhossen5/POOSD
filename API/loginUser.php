<?php
session_start();
include "../conn.php";

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

$data = getRequestInfo();
$user_name = $data['username']; // Make sure this matches the key in your JavaScript code
$password = $data['password']; // Make sure this matches the key in your JavaScript code
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
