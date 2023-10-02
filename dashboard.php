<?php
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: index.php");
  exit();
}

include "conn.php";

$_SESSION['searchResults'] = [];
$user_id = $_SESSION['id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./styling/styleDashboard.css">
  <title>My Contacts</title>
  <header class="header" style="text-align:center; padding-top: 56px;">
    <h1>My Contacts Hub</h1>
  </header>
</head>

<body>
  <div class="container_index">
    <div class="screen">
      <div class="screen-content">
        <?php
        if (isset($_GET["msg"])) {
          $msg = $_GET["msg"];
          echo '<div>' . $msg . '</div>';
        }
        ?>
        <form class="button-location" method="post">

          <div class="button-container container_dashboard">

            <a href="add_new.php" class="submit-button">
              Add Contact
            </a>
            <a style="padding-left: 16px"></a>
            <a href="search.php" id="search-submit-button" class="submit-button" style="margin-right: auto;">
              Search
            </a>

            <a href="index.php" class="submit-button">
              <span class="button-text">Log out</span>
            </a>
          </div>
        </form>

        <table style="margin-bottom:30px;">
          <thead>
            <tr>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Phone Number</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
            <?php
            $sql = "SELECT * FROM `contacts` WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
            ?>
              <tr>
                <td>
                  <?php echo $row["first_name"] ?>
                </td>
                <td>
                  <?php echo $row["last_name"] ?>
                </td>
                <td>
                  <?php echo $row["email"] ?>
                </td>
                <td>
                  <?php echo $row["phone_number"] ?>
                </td>
                <td>

                  <button class="edit-delete-button" type="button" onclick="location.href='./edit.php?contact_id=<?php echo $row['id'] ?>'">
                    Edit
                  </button>
                  <button class="edit-delete-button" type="button" onclick="location.href='./API/deleteContact.php?contact_id=<?php echo $row['id'] ?>'">
                    Delete
                  </button>
                </td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

</html>