<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <head>
        <link rel="stylesheet" href="./Styling/styleIndex.css">
    </head>
    <header class="login-header" style="text-align:center; padding-top: 56px;">
        <h1>My Contacts Hub</h1>
    </header>

</head>

<body>
    <div class="container_index">
        <div class="screen">
            <div class="screen-content">
                <form class="login" method="post" action="./API/loginUser.php" id="loginForm">
                    <div class="login-field">
                        <input type="text" class="login-input" id="user_name" name="user_name" placeholder="Enter your username" required>
                    </div>
                    <div class="login-field">
                        <input type="password" class="login-input" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <button class="login-submit" type="submit" name="submit" id="submit">
                        Log in <i class="button-icon fas fa-chevron-right"></i>
                    </button>
                    <div style="padding-left: 12px; padding-top: 24px; ">
                        <p style="color: #FFF; font-weight: 650;">Don't have an account?
                            <a style="color: #FFF" href="register.php">Register</a>
                        </p>
                        <i class="button-icon fas fa-chevron-right"></i>
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