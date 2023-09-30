<?php
include "../conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contact_id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];

    $sql = "UPDATE `contacts` SET `first_name`='$first_name',`last_name`='$last_name',
    `email`='$email',`phone_number`='$phone_number' 
    WHERE `id`='$contact_id'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Return a success response (e.g., JSON)
        echo json_encode(["message" => "Contact updated successfully"]);
    } else {
        // Return an error response (e.g., JSON)
        echo json_encode(["error" => "Failed to update contact"]);
    }

    header("Location: ../dashboard.php");
}
?>
