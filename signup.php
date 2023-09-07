<?php
include "conn.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Manager</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #5D5B5A;
            color: #fff;
            text-align: center;
            padding: 1rem;
        }
        .container {
            max-width: 400px;
            margin: 2rem auto;
            padding: 1rem;
            background-color: #fff;
            border: 0.5rem solid #5D5B5A;
        }
        h1 {
            margin-top: 0;
        }
        .button-container {
            text-align: center;
            margin-top: 1rem;
        }
        .add-button {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <h1 style="padding-top: 24px;">Contact Manager</h1>
    </header>
    <div class="container">
        <h2 style="text-align: center; color: #5D5B5A;">Sign-Up</h2>
        <!-- // add post request here -->
        <form class="signup-form" action="your_login_endpoint.php" method="post" style="max-width: 400px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">
            <div class="form-group" style="margin-bottom: 24px;">
                <label for="fname">First Name</label>
                <input type="text" id="fname" name="fname" required style="width: 93.5%; padding: 10px; border: 1px solid #ccc; border-radius: 3px; font-size: 16px;">
            </div>
            <div class="form-group" style="margin-bottom: 24px;">
                <label for="lname">Last Name</label>
                <input type="text" id="lname" name="lname" required style="width: 93.5%; padding: 10px; border: 1px solid #ccc; border-radius: 3px; font-size: 16px;">
            </div>
            <div class="form-group" style="margin-bottom: 24px;">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required style="width: 93.5%; padding: 10px; border: 1px solid #ccc; border-radius: 3px; font-size: 16px;">
            </div>
            <div class="form-group" style="margin-bottom: 24px;">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required style="width: 93.5%; padding: 10px; border: 1px solid #ccc; border-radius: 3px; font-size: 16px;">
            </div>
            <div class="form-group" style="margin-bottom: 24px;">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required style="width: 93.5%; padding: 10px; border: 1px solid #ccc; border-radius: 3px; font-size: 16px;">
            </div>
            <div class="button-container" style="text-align: center;">
                <button class="add-button">Sign-up</button>
            </div>
        </form>
        <div class="button-container">
            <button class="add-button" onclick="location.href='index.php'" type="button">
                Sign-in
            </button>
        </div>
    </div>
</body>
</html>
