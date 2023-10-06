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

function searchContacts($user_id)
{
    global $conn;
    $sql = "SELECT id, first_name, last_name, email, phone_number FROM `contacts` WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $searchResults = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $searchResults;
    } else {
        return [];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $user_id = $_SESSION['id'];
    $searchResults = searchContacts($user_id);
    $response = array(
        'success' => true, 'message' => 'Contacts retrieved successfully',
        'contacts' => $searchResults
    );
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    header("location: /dashboard.php");
}
