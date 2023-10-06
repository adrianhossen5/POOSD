<?php
session_start();
include "../conn.php";

if (!isset($_SESSION['id'])) {
    $response = array('success' => false, 'message' => "Unauthorized");
    http_response_code(401); // Unauthorized
    header('Content-Type: application/json');
    echo json_encode($response);
    header("location: /index.php");
    exit();
}

function getRequestInfo()
{
    return json_decode(file_get_contents('php://input'), true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = getRequestInfo();
    $user_id = $_SESSION['id'];
    $first_name = mysqli_real_escape_string($conn, $data['first_name']);
    $last_name = mysqli_real_escape_string($conn, $data['last_name']);
    $email = mysqli_real_escape_string($conn, $data['email']);
    $phone_number = mysqli_real_escape_string($conn, $data['phone_number']);

    // Check for duplicate email and phone number
    $check_email_sql = 'SELECT COUNT(*) FROM `contacts` WHERE `email` = ? AND `user_id` = ?';
    $check_email_stmt = $conn->prepare($check_email_sql);
    $check_email_stmt->bind_param("ss", $email, $user_id);
    $check_email_stmt->execute();
    $email_count = $check_email_stmt->get_result()->fetch_row()[0];

    $check_phone_sql = 'SELECT COUNT(*) FROM `contacts` WHERE `phone_number` = ? AND `user_id` = ?';
    $check_phone_stmt = $conn->prepare($check_phone_sql);
    $check_phone_stmt->bind_param("ss", $phone_number, $user_id);
    $check_phone_stmt->execute();
    $phone_count = $check_phone_stmt->get_result()->fetch_row()[0];

    $response = array('success' => false, 'message' => "Unknown error.");

    if ($email_count > 0) {
        $response = array('success' => false, 'message' => "Email Already Exists.");
    } else if ($phone_count > 0) {
        $response = array('success' => false, 'message' => "Phone Number Already Exists.");
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response = array('success' => false, 'message' => "Invalid Email Format.");
        } else {
            $sql = "INSERT INTO `contacts` (`id`, `user_id`, `first_name`, `last_name`, `email`, `phone_number`) 
            VALUES (UUID(), ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $user_id, $first_name, $last_name, $email, $phone_number);

            if ($stmt->execute()) {
                $response = array('success' => true, 'message' => 'Contact added successfully.');
            }
        }
    }

    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    header("location: /dashboard.php");
}
