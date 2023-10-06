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

function searchContacts($user_id, $searchTerm)
{
    global $conn;

    $sql = "SELECT * FROM `contacts` WHERE `user_id` = ? AND (
           `first_name` LIKE ? OR
           `last_name` LIKE ? OR
           `email` LIKE ? OR
           `phone_number` LIKE ?)";

    $stmt = $conn->prepare($sql);
    $searchTerm = "%" . $searchTerm . "%"; // Add wildcard characters for partial search
    $stmt->bind_param("sssss", $user_id, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();

    if ($stmt->error) {
        return [];
    }

    $result = $stmt->get_result();

    if ($result) {
        $searchResults = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $searchResults;
    } else {
        return [];
    }
}

function getRequestInfo()
{
    return json_decode(file_get_contents('php://input'), true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = getRequestInfo();
    $user_id = $_SESSION['id'];
    $searchResults = searchContacts($user_id, $data['search']);

    if (!empty($searchResults)) {
        $response = array(
            'success' => true,
            'message' => 'Contacts retrieved successfully',
            'contacts' => $searchResults
        );
        http_response_code(200); // Set HTTP status code to 200 OK
    } else {
        $response = array(
            'success' => false,
            'message' => 'No contacts found or an error occurred'
        );
        http_response_code(400); // Set HTTP status code to 404 Not Found (or another appropriate code)
    }

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    header("location: /index.php");
}
