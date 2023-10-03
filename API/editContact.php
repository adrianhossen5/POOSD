<?php
include "../conn.php";
session_start();

function isPostmanRequest()
{
    return isset($_SERVER['HTTP_USER_AGENT']) && 
        strpos($_SERVER['HTTP_USER_AGENT'], 'Postman') !== false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isPostmanRequest()) {
        echo "POST request received\n";
    }

    $user_id = $_SESSION['id'];
    $contact_id = $_POST['contact_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];

    $check_email_sql = 'SELECT COUNT(*) FROM `contacts` WHERE `email` = ? AND `user_id` = ? 
                        AND `id` != ?' ;
    $check_email_stmt = $conn->prepare($check_email_sql);
    $check_email_stmt->bind_param("sss", $email, $user_id, $contact_id);
    $check_email_stmt->execute();
    $check_email_result = $check_email_stmt->get_result();
    $email_count = $check_email_result->fetch_row()[0];

    $check_phone_sql = 'SELECT COUNT(*) FROM `contacts` WHERE `phone_number` = ? 
                        AND `user_id` = ? AND `id` != ?';
    $check_phone_stmt = $conn->prepare($check_phone_sql);
    $check_phone_stmt->bind_param("sss", $phone_number, $user_id, $contact_id);
    $check_phone_stmt->execute();
    $check_phone_result = $check_phone_stmt->get_result();
    $phone_count = $check_phone_result->fetch_row()[0];

    if ($email_count > 0) {
        $alert = "<script>alert('Email Already Exists!'); 
            window.location='../dashboard.php';</script>";
        echo $alert;
        exit();
    } else if ($phone_count > 0) {
        $alert = "<script>alert('Phone Number Already Exists!'); 
            window.location='../dashboard.php';</script>";
        echo $alert;
        exit();
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $alert = "<script>alert('Wrong email format!'); 
                window.location='../dashboard.php';</script>";
            echo $alert;
            exit();
        } else {
            $sql = "UPDATE `contacts` SET `first_name`='$first_name',`last_name`='$last_name',
            `email`='$email',`phone_number`='$phone_number' 
            WHERE `id`='$contact_id'";

            $result = mysqli_query($conn, $sql);

            if ($result && isPostmanRequest()) {
                echo "Contact id: " . $contact_id . "updated successfully!\n";
            } else if (isPostmanRequest()){
                echo "Failed to update contact id: " . $contact_id . "!\n";
            }

            echo "<script> window.location='../dashboard.php';</script>";
        }
    }
}
else {
    echo "<script> window.location='../dashboard.php';</script>";
}
?>