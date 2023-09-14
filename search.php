<?php
include "conn.php";

function searchContacts($searchTerm, $user_id) {
   global $conn;

   $sql = "SELECT * FROM `contacts` WHERE `user_id` = ? AND (
           `first_name` LIKE ? OR
           `last_name` LIKE ? OR
           `email` LIKE ? OR
           `phone_number` LIKE ?)";

   $stmt = $conn->prepare($sql);
   $searchTerm = "%" . $searchTerm . "%"; // Add wildcard characters for partial search
   $stmt->bind_param("sssss", $user_id, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
   $stmt->execute();
   $result = $stmt->get_result();

   if ($result) {
      $searchResults = mysqli_fetch_all($result, MYSQLI_ASSOC);
      return $searchResults;
   } else {
      echo "Search failed: " . mysqli_error($conn);
      return [];
   }
}

session_start();
if (isset($_SESSION['id'])) {
   $user_id = $_SESSION['id'];

   if (isset($_POST["search"])) {
       $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);
       $searchResults = searchContacts($searchTerm, $user_id);
   }
} else {
   header("Location: index.php"); // Redirect to the login page if the user is not logged in
   exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<body> 
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
            height: 275px;
            width: 500px;
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

        .search {
            width: 320px;
            padding-left: 36px;
            padding-top: 64px;
        }

        .search-field {
            padding: 20px 0px;
            position: relative;
        }

        .search-icon {
            position: absolute;
            top: 30px;
            color: #7875B5;
        }

        .search-input {
            border: none;
            font-size: 16px;
            border-bottom: 2px solid #D1D1D4;
            color: #FFF;
            background: none;
            padding: 10px;
            padding-left: 12px;
            margin-left:10%;
            font-weight: 400;
            width: 80%;
            transition: .2s;
        }

        .search-input:active,
        .search-input:focus,
        .search-input:hover {
            outline: none;
            border-bottom-color: #6A679E;
        }

        .search-submit {
            background: #fff;
            text-align: center;
            font-size: 16px;
            margin-top: 20px;
            padding: 15px;
            border-radius: 26px;
            border: 1px solid #D4D3E8;
            text-transform: uppercase;
            font-weight: 700;
            display: inline-block;
            align-items: center;
            justify-content: center;
            /* Center horizontally */
            width: 30%;
            color: #4C489D;
            box-shadow: 0px 2px 2px #5C5696;
            cursor: pointer;
            transition: .2s;
            
        }

        .search-header {
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
        }

        .search-submit:hover {
            border-color: #6A679E;
            outline: none;
        }


        .button-icon {
            text-align: center; /* Center the buttons horizontally */
            margin-top: 20px;
        }

        input::placeholder {
            color: white;
        }
    </style>

    <header class="search-header" style="text-align:center; padding-top: 56px;">
        <h1>My Contacts Hub</h1>
    </header>

    <div class="container_index">
        
        <div class="screen" style="margin-top: 10px;">
            
            <h2 style="text-align:center; padding-top: 36px; color: white;">Contact Search</h2>
            <div class="screen-content">

                <form method="post" >

                <div class="search-field">
                    <input type="text" class="search-input" id="user_name" name="user_name"
                        placeholder="Enter your name, email or phone number please" required>
                </div>

                <div class="button-container">
                    <button class="search-submit" style="margin-left: 13%;" type="submit" name="submit">
                        Search
                    </button>
                

                    <button class="search-submit" style="margin-left: 13%;" type="submit" name="submit">
                        <a href="dashboard.php">Cancel</a>
                    </button>
                </div>
                </form>

                <?php
                if (isset($searchResults) && !empty($searchResults)) {
                    echo "<h3>Search Results:</h3>";
                    echo "<ul>";
                    foreach ($searchResults as $contact) {
                        echo "<li>";
                        echo "Name: " . $contact['first_name'] . " " . $contact['last_name'] . "<br>";
                        echo "Email: " . $contact['email'] . "<br>";
                        echo "Phone: " . $contact['phone_number'] . "<br>";
                        echo '<div class="action-buttons">';
                        echo '<a href="edit.php?contact_id=' . $contact["id"] . '">Edit</a>';
                        echo '<a href="delete.php?contact_id=' . $contact["id"] . '">Delete</a>';
                        echo '</div>';
                        echo "</li>";
                    }
                    echo "</ul>";
                } elseif (isset($searchResults) && empty($searchResults)) {
                    echo "<p>No results found.</p>";
                }
                ?>
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
