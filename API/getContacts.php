<?php
include "../conn.php";
session_start();

function isPostmanRequest()
{
    return isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Postman') !== false;
}

function searchContacts($user_id)
{
    global $conn;
    $searchTerm = $_POST["search"];
            $_SESSION['id'] = $user_id;

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
        if (isPostmanRequest() && count($searchResults) > 0) {
            echo "Search Results Found!\n";
        }
        else {
            if (isPostmanRequest()) {
                echo "No Search Results Found!\n";
            }
        }
        return $searchResults;
    } else {
        if (isPostmanRequest()) {
            echo "Search failed: " . mysqli_error($conn);
        }
        return [];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isPostmanRequest()) {
        echo "POST request received\n";
    }
    $user_id = $_SESSION['id'];
    $searchResults = searchContacts($user_id);
    $_SESSION['searchResults'] = $searchResults;
    echo "<script> window.location='../search.php'; </script>";
}
else {
    echo "<script> window.location='../dashboard.php';</script>";
}
?>