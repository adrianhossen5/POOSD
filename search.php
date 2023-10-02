<?php
include "conn.php";

session_start();
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
} else {
    header("Location: index.php"); // Redirect to the login page if the user is not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="./styling/styleSearch.css">
    </head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<body>

    <header class="search-header" style="text-align:center; padding-top: 56px;">
        <h1>My Contacts Hub</h1>
    </header>

    <div class="container_index">

        <div class="screen" style="margin-top: 10px;">

            <h2 style="text-align:center; padding-top: 36px; color: white;">Contact Search</h2>
            <div class="screen-content">

                <form method="post" action="./API/getContacts.php" id="search">

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
        $searchResults = $_SESSION['searchResults'];
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
                            <a href="./API/deleteContact.php?contact_id=<?php echo $contact["id"] ?>">Delete</a>
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