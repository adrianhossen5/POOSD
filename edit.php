<?php
include "conn.php";

$contact_id = $_GET["contact_id"];

if (isset($_POST["submit"])) {
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $phone_number = $_POST['phone_number'];

  $sql = "UPDATE `contacts` SET `first_name`='$first_name',`last_name`='$last_name',`email`='$email',`phone_number`='$phone_number' 
  WHERE contact_id = $contact_id";
  
  $result = mysqli_query($conn, $sql);

  if ($result) {
    header("Location: dashboard.php");
  } else {
    echo "Failed: " . mysqli_error($conn);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
    <link rel="stylesheet" type="text/css" href="styles.css">

<body>
    <header>
      <h1>My Contacts Hub</h1>
    </header>
  <div class="container1">
    <div>
      <h3>Edit Contacts Info</h3>
    </div>

    <?php
    $sql = "SELECT * FROM `contacts` WHERE contact_id = $contact_id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    ?>

    <div>
      <form action="" method="post">
        <div>
          <label>First Name:</label>
          <input type="text" name="first_name" value="<?php echo $row['first_name'] ?>">
        </div>

        <div>
          <label>Last Name:</label>
          <input type="text" name="last_name" value="<?php echo $row['last_name'] ?>">
        </div>

        <div>
          <label>Email:</label>
          <input type="email" name="email" value="<?php echo $row['email'] ?>">
        </div>

        <div>
          <label>Phone Number:</label>
          <input type="tel" name="phone_number" value="<?php echo $row['phone_number'] ?>">
        </div>

        <div>
          <input type="submit" name="submit" value="Update">
          <a href="dashboard.php">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</body>

</html>
