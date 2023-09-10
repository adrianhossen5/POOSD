<?php
session_start();

// Check if the user is not logged in, redirect to the login page
// if (!isset($_SESSION['user_id'])) {
//     header("Location: index.php"); // Redirect to your login page
//     exit();
// }

include "conn.php";

// Get the user ID from the session
// $user_id = $_SESSION['user_id'];
$user_id = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Contacts</title>
</head>
  <link rel="stylesheet" type="text/css" href="styles.css">


<body>
  <header>
    <h1>My Contacts Hub</h1>
  </header>

  <div class="container">
    <?php
    if (isset($_GET["msg"])) {
      $msg = $_GET["msg"];
      echo '<div>' . $msg . '</div>';
    }
    ?>

    <a href="add_new.php">Add New Contact</a>
    <a href="search.php">Search</a>
    <a href="index.php">out</a>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Phone Number</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM `contacts` WHERE `user_id` = $user_id";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
          <tr>
            <td><?php echo $row["contact_id"] ?></td>
            <td><?php echo $row["first_name"] ?></td>
            <td><?php echo $row["last_name"] ?></td>
            <td><?php echo $row["email"] ?></td>
            <td><?php echo $row["phone_number"] ?></td>
            <td>
              <a href="edit.php?contact_id=<?php echo $row["contact_id"] ?>">Edit</a>
              <a href="delete.php?contact_id=<?php echo $row["contact_id"] ?>">Delete</a>
            </td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
</body>

</html>
