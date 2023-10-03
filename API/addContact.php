<?php
include "../conn.php";
session_start();

function isPostmanRequest()
{
    return isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Postman') !== false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isPostmanRequest()) {
        echo "POST request received\n";
    }

    $user_id = $_SESSION['id'];
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);

    $check_email_sql = 'SELECT COUNT(*) FROM `contacts` WHERE `email` = ? AND `user_id` = ?';
    $check_email_stmt = $conn->prepare($check_email_sql);
    $check_email_stmt->bind_param("ss", $email, $user_id);
    $check_email_stmt->execute();
    $check_email_result = $check_email_stmt->get_result();
    $email_count = $check_email_result->fetch_row()[0];

    $check_phone_sql = 'SELECT COUNT(*) FROM `contacts` WHERE `phone_number` = ? AND `user_id` = ?';
    $check_phone_stmt = $conn->prepare($check_phone_sql);
    $check_phone_stmt->bind_param("ss", $phone_number, $user_id);
    $check_phone_stmt->execute();
    $check_phone_result = $check_phone_stmt->get_result();
    $phone_count = $check_phone_result->fetch_row()[0];

    if ($email_count > 0) {
        if (isPostmanRequest()) {
            echo "Email Already Exists!\n";
        }
        echo "<script>alert('Email Already Exists!'); window.location.href='../add_new.php';</script>";
        exit();
    } else if ($phone_count > 0) {
        if (isPostmanRequest()) {
            echo "Phone Number Already Exists!\n";
        }
        echo "<script>alert('Phone Number Already Exists!'); window.location.href='../add_new.php';</script>";
        exit();
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Wrong email format!'); window.location.href='../add_new.php';</script>";
            exit();
        } else {
            $sql = "INSERT INTO `contacts` (`id`, `user_id`, `first_name`, `last_name`, `email`, `phone_number`) 
                VALUES (UUID(), ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $user_id, $first_name, $last_name, $email, $phone_number);

            if ($stmt->execute()) {

                if (isPostmanRequest()) {
                    echo "Contact " . $first_name ." Added!\n";
                }

                echo "<script> window.location='../dashboard.php';</script>";
                exit();
            }
        }
    }

    $stmt->close();
}
else {
    echo "<script> window.location='../dashboard.php';</script>";
    exit();
}
?>