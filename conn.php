<?php
$servername = "localhost";
$username = "root";
$password = "Reef.2003!";
$dbname = "contact_manager_uuid";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
