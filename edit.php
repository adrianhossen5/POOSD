<?php
include "conn.php";
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ./index.php");
}
else if (isset($_GET["contact_id"])) {
    $contact_id = $_GET["contact_id"];
} else {
    header("Location: ./dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleEdit.css">
</head>
<header class="header" style="text-align:center; padding-top: 56px;">
    <h1>My Contacts Hub</h1>
</header>

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

                <form style="margin-top:45px;" action="./API/editContact.php" method="post">
                    <input hidden id="id" name="id" value=<?php echo $row['id'] ?>></input>
                    <div style="margin-top:40px;">
                        <label class="label-deco">First Name:</label>
                        <input type="text" class="edit-input" id="first_name" name="first_name" 
                            value="<?php echo $row['first_name'] ?>" required>
                    </div>

                    <div style="margin-top:25px;">
                        <label style="color: white; margin-left:60px;">Last Name:</label>
                        <input type="text" class="edit-input" id="last_name" name="last_name" 
                            value="<?php echo $row['last_name'] ?>" required>
                    </div>

                    <div style="margin-top:25px;">
                        <label style="color: white; margin-left:60px;">Email:</label>
                        <input type="email" class="edit-input" id="email" name="email" 
                            value="<?php echo $row['email'] ?>" required>
                    </div>

                    <div style="margin-top:25px;">
                        <label style="color: white; margin-left:60px;">Phone Number:</label>
                        <input type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" class="edit-input" 
                            id="phone_number" name="phone_number" value="<?php echo $row['phone_number'] ?>" required>
                    </div>

                    <div class="button-icon">
                        <button class="edit-button edit-submit" type="submit" name="submit" 
                            value="Update">
                            Update
                        </button>

                        <button class="edit-button edit-submit" style="margin-left:3%;" type="button" 
                            onclick="location.href='dashboard.php'">
                            Cancel
                        </button>
                </form>
            </div>
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