<?php
session_start();
include "../conn.php";

function getRequestInfo()
{
  return json_decode(file_get_contents('php://input'), true);
}

$data = getRequestInfo();
$user_id = $_SESSION['id'];
$contact_id = $data['id'];

// Use prepared statement to prevent SQL injection
$sql = "DELETE FROM `contacts` WHERE `id` = ? AND `user_id` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $contact_id, $user_id);

if ($stmt->execute()) {
  $response = array('success' => true, 'message' => 'Contact deleted successfully');
  http_response_code(200); // Bad Request
} else {
  // Handle the error gracefully and provide a specific error message
  $response = array('success' => false, 'message' => 'Error deleting contact: ' . mysqli_error($conn));
  http_response_code(400); // Bad Request
}

header('Content-Type: application/json');
echo json_encode($response);
