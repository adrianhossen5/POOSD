<?php
session_start();
include "conn.php";

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styling/styleAddNew.css">
</head>

<header class="add-new-header">
    <h1>My Contacts Hub</h1>
</header>

<body>
    <div class="container_index">
        <div class="screen">
            <div class="screen-content">
                <h2 style="text-align:center; padding-top: 36px; color: white;">Add New Contact</h2>
                <form class="add-new" method="post" action="./API/addContact.php">
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
                        <span class="error" style="color: white;"></span>
                    </div>

                    <div class="add-new-field">
                        <input type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" class="add-new-input" id="phone_number"
                            name="phone_number" placeholder="Phone# Ex: (888-888-8888)">
                        <span class="validity"></span>
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