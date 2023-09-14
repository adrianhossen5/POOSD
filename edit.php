<?php
include "conn.php";

$contact_id = $_GET["contact_id"];

if (isset($_POST["submit"])) {
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $phone_number = $_POST['phone_number'];

  $sql = "UPDATE `contacts` SET `first_name`='$first_name',`last_name`='$last_name',
  `email`='$email',`phone_number`='$phone_number' 
  WHERE `id`='$contact_id'";
  
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
<header class="edit-header" style="text-align:center; padding-top: 56px;">
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
            min-height: 90vh;
        }

        .screen {
            background: linear-gradient(90deg, #5D54A4, #7C78B8);
            position: relative;
            height: 625px;
            width: 380px;
            box-shadow: 0px 0px 24px #5C5696;
        }

        .screen-content {
            z-index: 1;
            position: relative;
            height: 100%;
        }

        .screen-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0;
            -webkit-clip-path: inset(0 0 0 0);
            clip-path: inset(0 0 0 0);
        }

        .screen-background-shape {
            transform: rotate(45deg);
            position: absolute;
        }

        .screen-background-shape1 {
            height: 400px;
            width: 520px;
            background: #FFF;
            top: -50px;
            right: 120px;
            border-radius: 0 72px 0 0;
        }

        .screen-background-shape2 {
            height: 220px;
            width: 220px;
            background: #6C63AC;
            top: -172px;
            right: 0;
            border-radius: 32px;
        }

        .screen-background-shape3 {
            height: 540px;
            width: 190px;
            background: linear-gradient(270deg, #5D54A4, #6A679E);
            top: -24px;
            right: 0;
            border-radius: 32px;
        }

        .screen-background-shape4 {
            height: 400px;
            width: 200px;
            background: #7E7BB9;
            top: 420px;
            right: 50px;
            border-radius: 60px;
        }

        .edit {
            width: 320px;
            padding-left: 36px;
            padding-top: 64px;
        }

        .edit-field {
            padding: 20px 0px;
            position: relative;
        }

        .edit-icon {
            position: absolute;
            top: 30px;
            color: #7875B5;
        }

        .edit-input {
            border: none;
            font-size: 16px;
            border-bottom: 2px solid #D1D1D4;
            color: #FFF;
            background: none;
            padding: 10px;
            padding-left: 12px;
            padding-top: 20px;
            font-weight: 700;
            width: 70%;
            margin-left:60px;
            transition: .2s;
            position: center;

        }

        .edit-input:active,
        .edit-input:focus,
        .edit-input:hover {
            outline: none;
            border-bottom-color: #6A679E;
        }

        .edit-submit {
            background: #fff;
            text-align: center;
            font-size: 16px;
            margin-top: 40px;
            padding: 15px;
            border-radius: 26px;
            border: 1px solid #D4D3E8;
            text-transform: uppercase;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Center horizontally */
            width: 35%;
            color: #4C489D;
            box-shadow: 0px 2px 2px #5C5696;
            cursor: pointer;
            transition: .2s;
        }

        .edit-header {
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

        .edit-submit:hover {
            border-color: #6A679E;
            outline: none;
        }

        .button-icon {
            font-size: 24px;
            color: #7875B5;
            display: flex; /* Use flexbox to arrange the buttons horizontally */

            justify-content: center; /* Space them evenly within the container */
            
            margin-top: 20px; /* Adjust this margin as needed */
        }

        input::placeholder {
            color: white;
        }

        .label-deco{
          color: white; 
          margin-left:60px; 
        }
    </style>
<body>
  
  <div class="container_index">
    <div class="screen">
      <div class="screen-content">
      <h2 style="text-align:center; padding-top: 46px; color: white;">Edit</h2>

    <?php
      $sql = "SELECT * FROM `contacts` WHERE id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $contact_id);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
    ?>
    
      <form style= "margin-top:45px;" action="" method="post">

        <div style="margin-top:40px;">
        <label class="label-deco">First Name:</label>
            <input type="text" class="edit-input" id="first_name" name="first_name"
            value="<?php echo $row['first_name'] ?>">
        </div>

        <div style="margin-top:25px;">
        <label style="color: white; margin-left:60px;">Last Name:</label>
            <input type="text" class="edit-input" id="last_name" name="last_name"
            value="<?php echo $row['last_name'] ?>">
        </div>

        <div style="margin-top:25px;">
        <label style="color: white; margin-left:60px;">Email:</label>
            <input type="text" class="edit-input" id="email" name="email"
            value="<?php echo $row['email'] ?>">
        </div>

        <div style="margin-top:25px;">
        <label style="color: white; margin-left:60px;">Phone Number:</label>
            <input type="text" class="edit-input"  id="phone_number" name="phone_number"
            value="<?php echo $row['phone_number'] ?>">
        </div>

        <div class="button-icon">
          <button class="edit-button edit-submit" type="submit" name="submit" value="Update">
            UPDATE 
          </button>
        
          <button class="edit-button edit-submit" style="margin-left:3%; type="submit" name="submit" href="dashboard.php">
              CANCEL 
          </button>
        </div>
      </form>
    </div>
        <div class="screen-background">
                <span class="screen-background-shape screen-background-shape4"></span>
                <span class="screen-background-shape screen-background-shape3"></span>
                <span class="screen-background-shape screen-background-shape2"></span>
            </div>
    </div>
  </div>
</body>

</html>
