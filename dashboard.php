<?php
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: index.php");
  exit();
}

include "conn.php";

$user_id = $_SESSION['id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Contacts</title>
  <header class="header" style="text-align:center; padding-top: 56px;">
    <h1>My Contacts Hub</h1>
  </header>

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
      min-height: 55vh;
    }

    .container_dashboard {
      width: 100%;
      height: 90px;
      display: flex;
    }

    .screen {
      background: linear-gradient(90deg, #5D54A4, #7C78B8);
      position: relative;
      height: auto;
      width: 90%;
      box-shadow: 0px 0px 24px #5C5696;
      min-height: 40vh;
      margin-top: 45px;
    }

    .screen-content {
      z-index: 1;
      position: relative;
      height: 100%;
    }

    .button-location {
      width: auto;
      margin-left: 5px;
      padding-left: 30px;
      padding-top: 30px;
      align-items: left;
      display: flex;
    }

    .submit-button {
      background: #fff;
      text-align: center;
      font-size: 16px;
      margin-top: 8px;
      padding: 12px;
      border-radius: 12px;
      border: 1px solid #D4D3E8;
      text-transform: uppercase;
      font-weight: 700;
      display: inline-block;
      align-items: center;
      justify-content: center;
      /* Center horizontally */
      width: auto;
      color: #4C489D;
      box-shadow: 0px 2px 2px #5C5696;
      cursor: pointer;
      transition: .2s;
    }

    .add-button {
      background: #fff;
      text-align: center;
      font-size: 16px;
      margin-top: 8px;
      padding: 12px;
      border-radius: 12px;
      border: 1px solid #D4D3E8;
      text-transform: uppercase;
      font-weight: 700;
      display: inline-block;
      align-items: center;
      justify-content: center;
      margin-right: 12px;
      width: 150px;
      color: #4C489D;
      box-shadow: 0px 2px 2px #5C5696;
      cursor: pointer;
      transition: .2s;
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

    .header {
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

    .submit-button:hover {
      border-color: #6A679E;
      outline: none;
    }

    input::placeholder {
      color: white;
    }


    .button-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: auto;
    }

    .log-out-button {
      width: 101.8px;
      font-size: 16px;
      position: absolute;
      margin-left: 85%;
    }

    .button-text {
      display: flex;
      margin-right: 5px;
    }

    table {
      width: 95%;
      margin: 0 auto;
      border-collapse: collapse;
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
  </style>
</head>
<body>
  <div class="container_index">
    <div class="screen">
      <div class="screen-content">
        <!-- <div class="all:unset; container-2"> -->
        <?php
        if (isset($_GET["msg"])) {
          $msg = $_GET["msg"];
          echo '<div>' . $msg . '</div>';
        }
        ?>
        <form class="button-location" method="post">

          <div class="button-container container_dashboard">

            <a href="add_new.php" class="add-button">
              Add Contact
            </a>

            <a href="search.php" class="submit-button">
              Search
            </a>

            <a href="index.php" class="submit-button log-out-button">
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

                  <button class="edit-delete-button">
                    <a href="edit.php?contact_id=<?php echo $row["id"] ?>">Edit</a>
                  </button>

                  <button class="edit-delete-button">
                    <a href="delete.php?contact_id=<?php echo $row["id"] ?>">Delete</a>
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