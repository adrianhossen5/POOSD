<?php
include "../conn.php";

if (isset($_POST["submit"])) {
    $user_id = $_SESSION['id'];
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);

    $check_email_sql = "SELECT COUNT(*) FROM `contacts` WHERE `email` = ?";
    $check_email_stmt = $conn->prepare($check_email_sql);
    $check_email_stmt->bind_param("s", $email);
    $check_email_stmt->execute();
    $check_email_result = $check_email_stmt->get_result();
    $email_count = $check_email_result->fetch_row()[0];

    if ($email_count > 0) {
        $alert = "<script>alert('Email Already Exists!'); window.location='add_new.php';</script>";
        echo $alert;
        exit();
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $alert = "<script>alert('Wrong email format!'); window.location='add_new.php';</script>";
            echo $alert;
            exit();
        } else {
            $sql = "INSERT INTO `contacts` (`id`, `user_id`, `first_name`, `last_name`, `email`, `phone_number`) 
                VALUES (UUID(), ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $user_id, $first_name, $last_name, $email, $phone_number);

            if ($stmt->execute()) {
                header("Location: dashboard.php");
                exit();
            }
        }
    }
}

?>