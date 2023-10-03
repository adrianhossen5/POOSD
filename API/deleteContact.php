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
  $contact_id = $_POST['contact_id'];
  $sql = "DELETE FROM `contacts` WHERE `id` = '$contact_id' AND `user_id` = '$user_id'";
  $result = mysqli_query($conn, $sql);
  
  if ($result) {
    if (isPostmanRequest()) {
      echo "Contact id: " . $contact_id . " Deleted!\n";
    }
    echo "<script> window.location='../dashboard.php';</script>";
  } else {
    echo "Failed to Delete Contact id: " . $contact_id  . "\n";
    echo "<script> window.location='../dashboard.php';</script>";
  }
}
else {
  echo "<script> window.location='../dashboard.php';</script>";
  exit();
}
?>