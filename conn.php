<?php
$servername = "localhost";
$username = "super";
$password = "password";
$dbname = "contact_manager";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>