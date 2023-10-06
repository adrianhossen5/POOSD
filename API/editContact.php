<?php
include "../conn.php";
session_start();

if (!isset($_SESSION['id'])) {
    $response = array('success' => false, 'message' => "Unauthorized");
    http_response_code(401); // Unauthorized
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

function getRequestInfo()
{
    return json_decode(file_get_contents('php://input'), true);
}

echo "POST request received\n";
$data = getRequestInfo();
$user_id = $_SESSION['id'];
$first_name = mysqli_real_escape_string($conn, $data['first_name']);
$last_name = mysqli_real_escape_string($conn, $data['last_name']);
$email = mysqli_real_escape_string($conn, $data['email']);
$phone_number = mysqli_real_escape_string($conn, $data['phone_number']);
$contact_id = mysqli_real_escape_string($conn, $data['id']);

$check_email_sql = 'SELECT COUNT(*) FROM `contacts` WHERE `email` = ? AND `user_id` = ? AND `id` != ?';
$check_email_stmt = $conn->prepare($check_email_sql);
$check_email_stmt->bind_param("sss", $email, $user_id, $contact_id);
$check_email_stmt->execute();
$check_email_result = $check_email_stmt->get_result();
$email_count = $check_email_result->fetch_row()[0];

$check_phone_sql = 'SELECT COUNT(*) FROM `contacts` WHERE `phone_number` = ? AND `user_id` = ? AND `id` != ?';
$check_phone_stmt = $conn->prepare($check_phone_sql);
$check_phone_stmt->bind_param("sss", $phone_number, $user_id, $contact_id);
$check_phone_stmt->execute();
$check_phone_result = $check_phone_stmt->get_result();
$phone_count = $check_phone_result->fetch_row()[0];

$response = array('success' => false, 'message' => "Unknown error");

if ($email_count > 0) {
    // echo "Email Already Exists!";
    $response = array('success' => false, 'message' => "Email Already Exists!");
    http_response_code(400); // Bad Request
} else if ($phone_count > 0) {
    // echo "Phone Number Already Exists!";
    $response = array('success' => false, 'message' => "Phone Number Already Exists!");
    http_response_code(400); // Bad Request
} else {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // echo "Wrong email format!";
        $response = array('success' => false, 'message' => "Wrong email format!");
        http_response_code(400); // Bad Request
    } else {
        $sql = "UPDATE `contacts` SET `first_name`='$first_name',`last_name`='$last_name',
        `email`='$email',`phone_number`='$phone_number' 
        WHERE `id`='$contact_id'";

        $result = mysqli_query($conn, $sql);

        if ($stmt->execute()) {
            // echo "New record created successfully";
            $response = array('success' => true, 'message' => 'Contact updated successfully');
            http_response_code(200); // OK
        }
    }
}

header('Content-Type: application/json');
echo json_encode($response);
