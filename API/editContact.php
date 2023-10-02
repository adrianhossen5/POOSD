<?php
include "../conn.php";

if (isset($_POST['submit'])) {
    session_start();
    $user_id = $_SESSION['id'];
    $contact_id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];

    $check_email_sql = 'SELECT COUNT(*) FROM `contacts` WHERE `email` = ? AND `user_id` = ? AND `id` != ?' ;
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

    if ($email_count > 0) {
        $alert = "<script>alert('Email Already Exists!'); window.location='../dashboard.php';</script>";
        echo $alert;
        exit();
    } else if ($phone_count > 0) {
        $alert = "<script>alert('Phone Number Already Exists!'); window.location='../dashboard.php';</script>";
        echo $alert;
        exit();
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $alert = "<script>alert('Wrong email format!'); window.location='../dashboard.php';</script>";
            echo $alert;
            exit();
        } else {
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
    }
}
?>