<?php
include "../conn.php";
session_start();

function isPostmanRequest()
{
    return isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Postman') !== false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isPostmanRequest()) {
    echo "POST request received\n";
  }
  $user_id = $_SESSION['id'];
  $contact_id = $_GET["contact_id"];
  $sql = "DELETE FROM `contacts` WHERE `id` = '$contact_id' AND `user_id` = '$user_id'";
  $result = mysqli_query($conn, $sql);
  
  if ($result) {
    header("Location: ../dashboard.php");
  } else {
    echo "Failed: " . mysqli_error($conn);
    header("Location: ../dashboard.php");
  }
}
else {
  echo "<script> window.location='../dashboard.php';</script>";
}
?>