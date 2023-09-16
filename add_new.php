<?php
session_start();
include "conn.php";

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST["submit"])) {
    $user_id = $_SESSION['id'];
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);

    $sql = "INSERT INTO `contacts` (`id`, `user_id`, `first_name`, `last_name`, `email`, `phone_number`) 
            VALUES (UUID(), ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $user_id, $first_name, $last_name, $email, $phone_number);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $alert="<script>alert('Wrong email format'); window.location='add_new.php';</script>";
        echo $alert;
        exit();
    }

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<style>
    @import url('https://fonts.googleapis.com/css?family=Raleway:400,700');

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: Raleway, sans-serif;
    }

    body {
        background: linear-gradient(90deg, #C7C5F4, #776BCC);
    }

    .container_index {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 90vh;
    }

    .screen {
        background: linear-gradient(90deg, #5D54A4, #7C78B8);
        position: relative;
        height: 580px;
        width: 375px;
        box-shadow: 0px 0px 24px #5C5696;
    }

    .screen-content {
        z-index: 1;
        position: relative;
        height: 100%;
    }

    .screen-background {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 0;
        -webkit-clip-path: inset(0 0 0 0);
        clip-path: inset(0 0 0 0);
    }

    .screen-background-shape {
        transform: rotate(45deg);
        position: absolute;
    }

    .screen-background-shape1 {
        height: 400px;
        width: 520px;
        background: #FFF;
        top: -50px;
        right: 120px;
        border-radius: 0 72px 0 0;
    }

    .screen-background-shape2 {
        height: 220px;
        width: 220px;
        background: #6C63AC;
        top: -172px;
        right: 0;
        border-radius: 32px;
    }

    .screen-background-shape3 {
        height: 540px;
        width: 190px;
        background: linear-gradient(270deg, #5D54A4, #6A679E);
        top: -24px;
        right: 0;
        border-radius: 32px;
    }

    .screen-background-shape4 {
        height: 400px;
        width: 200px;
        background: #7E7BB9;
        top: 420px;
        right: 50px;
        border-radius: 60px;
    }

    .add-new {
        width: 320px;
        padding-left: 36px;
        padding-top: 24px;
        font-weight: bold;
    }

    .add-new-field {
        padding: 20px 0px;
        position: relative;
    }

    .add-new-icon {
        position: absolute;
        top: 30px;
        color: #7875B5;
    }

    .add-new-input {
        border: none;
        font-size: 16px;
        border-bottom: 2px solid #D1D1D4;
        color: #FFF;
        background: none;
        padding: 10px;
        padding-left: 12px;
        font-weight: 300;
        width: 100%;
        transition: .2s;
    }

    .add-new-input:active,
    .add-new-input:focus,
    .add-new-input:hover {
        outline: none;
        border-bottom-color: #6A679E;
    }

    .add-new-submit {
        background: #fff;
        text-align: center;
        font-size: 16px;
        margin-top: 20px;
        padding: 15px;
        border-radius: 14px;
        border: 1px solid #D4D3E8;
        text-transform: uppercase;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        /* Center horizontally */
        width: 100%;
        color: #4C489D;
        box-shadow: 0px 2px 2px #5C5696;
        cursor: pointer;
        transition: .2s;
    }

    .add-new-header {
        background: #fff;
        text-align: center;
        font-size: 16px;
        padding: 48px;
        border: 1px solid #D4D3E8;
        text-transform: uppercase;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        color: #4C489D;
        box-shadow: 0px 2px 2px #5C5696;
        cursor: pointer;
        transition: .2s;
        text-align: center;
        padding-top: 56px;
    }

    .add-new-submit:hover {
        border-color: #6A679E;
        outline: none;
    }

    .button-icon {
        font-size: 24px;
        color: #7875B5;
    }

    input::placeholder {
        color: white;
    }
</style>

<header class="add-new-header">
    <h1>My Contacts Hub</h1>
</header>

<body>

    <div class="container_index">
        <div class="screen">
            <div class="screen-content">
                <h2 style="text-align:center; padding-top: 36px; color: white;">Add New Contact</h2>
                <form class="add-new" method="post">
                    <div class="add-new-field">
                        <input type="text" class="add-new-input" id="first_name" name="first_name"
                            placeholder="First Name" required>
                    </div>
                    <div class="add-new-field">
                        <input type="text" class="add-new-input" id="last_name" name="last_name" placeholder="Last Name"
                            required>
                    </div>
                    <div class="add-new-field">
                        <input type="email" class="add-new-input" id="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="add-new-field">
                        <input type="number" class="add-new-input" id="phone_number" name="phone_number"
                            placeholder="Phone Number" required>
                    </div>
                    <button class="add-new-button add-new-submit" type="submit" name="submit">
                        Add Contact<i class="button-icon fas fa-chevron-right"></i>
                    </button>
                    <div style="padding-left: 12px; padding-top: 24px; ">
                        <a style="color: #FFF" href="dashboard.php">Cancel</a>
                        <i class="button-icon fas fa-chevron-right"></i>
                    </div>
                </form>
            </div>
            <div class="screen-background">
                <span class="screen-background-shape screen-background-shape4"></span>
                <span class="screen-background-shape screen-background-shape3"></span>
                <span class="screen-background-shape screen-background-shape2"></span>
            </div>
        </div>
    </div>

</body>

</html>