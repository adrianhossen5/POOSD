<?php
session_start();
include "../conn.php";

if (!isset($_SESSION['id'])) {
  $response = array('success' => false, 'message' => "Unauthorized.");
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
  $contact_id = $data['contact_id'];

  $sql = "DELETE FROM `contacts` WHERE `id` = ? AND `user_id` = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $contact_id, $user_id);

  if ($stmt->execute()) {
    if ($stmt->affected_rows === 0) {
      $response = array('success' => false, 'message' => 'Contact not found.');
      header('Content-Type: application/json');
      echo json_encode($response);
      exit();
    }
    $response = array('success' => true, 'message' => 'Contact deleted successfully.');
  } else {
    // Handle the error gracefully and provide a specific error message
    $response = array('success' => false, 'message' => 'Error deleting contact.');
  }

  http_response_code(200);
  header('Content-Type: application/json');
  echo json_encode($response);
} else {
  header("location: /dashboard.php");
}
