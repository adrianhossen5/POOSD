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
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="styleDashboard.css" />
  <title>Contastic</title>
  <script src="./JS/jquery.js"></script>
  <script src="./JS/home.js"></script>
  <script src="./JS/delete.js"></script>

  <script>
    function editContact(firstName, lastName, phoneNumber, email, id) {
      const url = `edit.php?first_name=${firstName}&last_name=${lastName}&phone_number=${phoneNumber}&email=${email}&id=${id}`;
      window.location.href = url;
    }
  </script>
  <header class="header" style="text-align: center; padding-top: 56px">
    <h1>Contastic</h1>
  </header>
</head>

<body>
  <div class="container_index">
    <div class="screen">
      <div class="screen-content">
        <form class="button-location" method="post">
          <div class="button-container container_dashboard">
            <a href="add_new.php" class="submit-button"> Add Contact </a>
            <a style="padding-left: 16px"></a>
            <a href="search.php" id="search-submit-button" class="submit-button" style="margin-right: auto">
              Search
            </a>
            <a href="./API/logout.php" class="submit-button">
              <span class="button-text">Log out</span>
            </a>
          </div>
        </form>
        <table id="contacts" style="margin-bottom: 30px"></table>
      </div>
    </div>
  </div>
</body>

</html>