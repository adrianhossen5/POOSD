<?php
include "../conn.php";

session_start();

$contact_id = $_GET["contact_id"];

$sql = "DELETE FROM `contacts` WHERE `id` = '$contact_id'";
$result = mysqli_query($conn, $sql);

if ($result) {
  header("Location: ../dashboard.php");
} else {
  echo "Failed: " . mysqli_error($conn);
}