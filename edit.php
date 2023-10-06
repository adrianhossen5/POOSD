<?php
include "conn.php";
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleEdit.css">
    <script src="./JS/jquery.js"></script>
    <script src="./JS/edit.js" type=""></script>
</head>
<header class="header" style="text-align:center; padding-top: 56px;">
    <h1>Contastic</h1>
</header>

<body>
    <div class="container_index">
        <div class="screen">
            <div class="screen-content">
                <h2 style="text-align:center; padding-top: 46px; color: white;">Edit</h2>

                <form style="margin-top:45px;" id="editForm">
                    <input hidden id="id" name="contact_id"></input>
                    <div style="margin-top:40px;">
                        <label class="label-deco">First Name:</label>
                        <input type="text" class="edit-input" id="first_name" name="first_name" required>
                    </div>

                    <div style="margin-top:25px;">
                        <label style="color: white; margin-left:60px;">Last Name:</label>
                        <input type="text" class="edit-input" id="last_name" name="last_name" required>
                    </div>

                    <div style="margin-top:25px;">
                        <label style="color: white; margin-left:60px;">Email:</label>
                        <input type="email" class="edit-input" id="email" name="email" required>
                    </div>

                    <div style="margin-top:25px;">
                        <label style="color: white; margin-left:60px;">Phone Number:</label>
                        <input type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" class="edit-input" id="phone_number" name="phone_number" required>
                    </div>

                    <div class="button-icon">
                        <button class="edit-button edit-submit" type="submit">
                            Update
                        </button>

                        <button class="edit-button edit-submit" style="margin-left:3%;" type="button" onclick="location.href='dashboard.php'">
                            Cancel
                        </button>
                    </div>
                </form>
                <script>
                    // Function to parse query parameters from the URL
                    function getQueryParameters() {
                        const queryParams = new URLSearchParams(window.location.search);
                        const params = {};
                        for (const [key, value] of queryParams) {
                            params[key] = value;
                        }
                        return params;
                    }
            
                    // Function to populate form fields with query parameter values
                    function populateFormFields() {
                        const params = getQueryParameters();
                        document.getElementById("first_name").value = params.first_name;
                        document.getElementById("last_name").value = params.last_name;
                        document.getElementById("phone_number").value = params.phone_number;
                        document.getElementById("email").value = params.email;
                        document.getElementById("id").value = params.id;
                    }
            
                    // Call the populateFormFields function when the page loads
                    window.onload = populateFormFields;
                </script>
            </div>
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