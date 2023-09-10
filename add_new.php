<?php
session_start();
include "conn.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); 
    exit();
}

if (isset($_POST["submit"])) {
    $user_id = $_SESSION['user_id']; 

    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);

    $sql = "INSERT INTO `contacts` (`contact_id`, `user_id`, `first_name`, `last_name`, `email`, `phone_number`) 
            VALUES (NULL, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $user_id, $first_name, $last_name, $email, $phone_number);

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
    <link rel="stylesheet" type="text/css" href="styles.css">

<body>
    <header>
    <h1>My Contacts Hub</h1>
    </header>
    <div class="container1">
        <h3>Add New Contact</h3>
        <form method="post">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" placeholder="Enter your first name" required>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" placeholder="Enter your last name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email address" required>
            
            <label for="phone_number">Phone Number:</label>
            <input type="tel" id="phone_number" name="phone_number" placeholder="Enter your phone number (000-000-0000)" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required>

            <input type="submit" name="submit" value="Add">
            <a href="dashboard.php">Cancel</a>

        </form>
    </div>
</body>
</html>
