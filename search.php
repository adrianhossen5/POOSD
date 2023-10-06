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
  <link rel="stylesheet" href="styleSearch.css" />
  <script src="./JS/jquery.js"></script>
  <script src="./JS/search.js" type=""></script>
  <script src="./JS/delete.js" type=""></script>
  <script>
    function editContact(firstName, lastName, phoneNumber, email, id) {
      const url = `edit.php?first_name=${firstName}&last_name=${lastName}&phone_number=${phoneNumber}&email=${email}&id=${id}`;
      window.location.href = url;
    }
  </script>
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<body>

    <header class="search-header" style="text-align:center; padding-top: 56px;">
        <h1>Contastic</h1>
    </header>

  <div class="container_index">
    <div class="screen" style="margin-top: 10px">
      <h2 style="text-align: center; padding-top: 36px; color: white">
        Contact Search
      </h2>
      <div class="screen-content">
        <form id="searchForm">
          <div class="search-field">
            <input type="text" class="search-input" id="search" placeholder="Name, email, or phone number" />
          </div>
          <div class="button-container">
            <button class="search-submit" style="margin-left: 13%" type="submit" name="submit">
              Search
            </button>
            <button class="search-submit" style="margin-left: 13%" type="button" onclick="location.href='dashboard.php'">
              Cancel
            </button>
          </div>
        </form>
      </div>
      <div class='table-screen'>
        <table id="searchTable" style="margin-bottom: 30px "></table>
      </div>
    </div>
  </div>
</body>

</html>