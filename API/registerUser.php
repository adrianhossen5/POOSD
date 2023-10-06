<?php
include "../conn.php";

function getRequestInfo()
{
    return json_decode(file_get_contents('php://input'), true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = getRequestInfo();
    $username = $data['user_name'];
    $password = $data['password'];
    $confirm_password = $data["confirm_password"];
    $email = $data['email'];

    $errors = [];
    $response = array('success' => false, 'message' => 'Failed to register!');

    if ($password !== $confirm_password) {
        $response = array('success' => false, 'message' => 'Passwords do not match!');
        http_response_code(400); // Bad Request
    } else {
        $sql = 'SELECT username FROM users WHERE username = ?';

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $response = array('success' => false, 'message' => 'This username is already taken!');
            http_response_code(400); // Bad Request
        } else {
            $stmt->close();
            $sql = 'SELECT email FROM users WHERE email = ?';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $response = array('success' => false, 'message' => 'This email is already taken!');
                http_response_code(400); // Bad Request
            } else {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $response = array('success' => false, 'message' => 'Wrong email format!');
                } else {
                    $sql = 'SELECT id, username, password_hash FROM users WHERE username = ?';
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $sql = 'INSERT INTO `users` (`id`, `username`, `password_hash`, `email`) 
                    VALUES (UUID(), ?, ?, ?)';
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('sss', $username, $hashed_password, $email);

                    if ($stmt->execute()) {
                        $response = array('success' => true, 'message' => 'Sucessfully registered!');
                        http_response_code(200); // OK
                    } else {
                        $response = array('success' => false, 'message' => 'Failed to register!');
                        http_response_code(400); // Bad Request
                    }
                }
            }
        }
    }


    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    header('Location: /index.php');
}
