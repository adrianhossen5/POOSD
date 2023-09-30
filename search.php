<?php
include "conn.php";

function searchContacts($user_id)
{
    global $conn;
    $searchTerm = $_POST["search"];

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
    if (isset($_POST['search'])) {
        $searchResults = searchContacts($user_id);
    }
} else {
    header("Location: index.php"); // Redirect to the login page if the user is not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Raleway:400,700');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Raleway, sans-serif;
            text-decoration: none;
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

        .container_index2 {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 55vh;
        }

        .screen {
            background: linear-gradient(90deg, #5D54A4, #7C78B8);
            position: relative;
            height: 275px;
            width: 500px;
            box-shadow: 0px 0px 24px #5C5696;
            margin-bottom:30%;

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
            margin-left: 10%;
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
            border-radius: 16px;
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
            text-align: center;
            /* Center the buttons horizontally */
            margin-top: 20px;
        }

        .edit-delete-button {
            background: #fff;
            text-align: center;
            font-size: 12px;
            margin-top: 8px;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #D4D3E8;
            text-transform: uppercase;
            font-weight: 550;
            display: inline-block;
            align-items: center;
            width: auto;
            color: #4C489D;
            box-shadow: 0px 2px 2px #5C5696;
            cursor: pointer;
            transition: .2s;
        }

        .table-screen {
            background: linear-gradient(90deg, #5D54A4, #7C78B8);
            position: relative;
            height: auto;
            width: 150%;
            box-shadow: 0px 0px 24px #5C5696;
            margin-left: -26%;
            padding-top:30px;
            padding-bottom:5px;
        }

    table {
      width: 95%;
      margin: 0 auto;
      border-collapse: collapse;
      height:100%;
    }

    th,
    td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #D4D3E8;
    }

    th {
      background: #fff;
      color: #4C489D;
      text-transform: uppercase;
    }

    tr:nth-child(even) {
      background: #D1C4E9;
    }

    tr:nth-child(odd) {
      background: #B39DDB;
      /* Slightly Darker Purple */
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

                <form method="post">

                    <div class="search-field">
                        <input type="text" class="search-input" id="search" name="search"
                            placeholder="Name, email, or phone number">
                    </div>

                    <div class="button-container">
                        <button class="search-submit" style="margin-left: 13%;" type="submit" name="submit">
                            Search
                        </button>
                        <button class="search-submit" style="margin-left: 13%;" type="button"
                        onclick="location.href='dashboard.php'">
                            Cancel
                        </button>
                </form>
                
            </div>
            
        </div>
            <?php
            if (isset($searchResults) && !empty($searchResults)) {
                echo "<div class='table-screen'>
                <table style='margin-bottom:30px;'>
                        <thead>
                            <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>";

                foreach ($searchResults as $contact) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $contact["first_name"] ?>
                        </td>
                        <td>
                            <?php echo $contact["last_name"] ?>
                        </td>
                        <td>
                            <?php echo $contact["email"] ?>
                        </td>
                        <td>
                            <?php echo $contact["phone_number"] ?>
                        </td>
                        <td>

                            <button class="edit-delete-button">
                                <a href="edit.php?contact_id=<?php echo $contact["id"] ?>">Edit</a>
                            </button>

                            <button class="edit-delete-button">
                                <a href="delete.php?contact_id=<?php echo $contact["id"] ?>">Delete</a>
                            </button>

                        </td>
                    </tr>
                    <?php
                }
                echo "</div>";
            }
            ?>
        </div>
        </div>
</body>
</html>