<?php
include "../conn.php";
session_start();

function searchContacts($user_id)
{
    global $conn;
    $searchTerm = $_POST["search"];

    $sql = "SELECT * FROM `contacts` WHERE `user_id` = ? AND (
           `first_name` LIKE ? OR
           `last_name` LIKE ? OR
           `email` LIKE ? OR
           `phone_number` LIKE ?)";

    $stmt = $conn->prepare($sql);
    $searchTerm = "%" . $searchTerm . "%"; // Add wildcard characters for partial search
    $stmt->bind_param("sssss", $user_id, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $searchResults = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $searchResults;
    } else {
        echo "Search failed: " . mysqli_error($conn);
        return [];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchResults = searchContacts($user_id);
    $_SESSION['searchResults'] = $searchResults;
    header("Location: ../search.php");
}
?>