<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <head>
        <link rel="stylesheet" href="styleRegister.css">
    </head>
    <header class="register-header" style="text-align:center; padding-top: 56px;">
        <h1>My Contacts Hub</h1>
    </header>
</head>

<body>
    <div class="container_index">
        <div class="screen">
            <div class="screen-content">
                <h2 style="text-align:center; padding-top: 40px; color: white;">Register</h2>
                <form class="register" method="post" action="./API/registerUser.php">
                    <div class="register-field">
                        <input type="text" class="register-input" id="user_name" name="user_name"
                            placeholder="Enter your username" required>
                    </div>
                    <div class="register-field">
                        <input type="password" class="register-input" id="password" name="password"
                            placeholder="Enter your password" required>
                    </div>
                    <div class="register-field">
                        <input type="password" class="register-input" id="confirm_password" name="confirm_password"
                            placeholder="Confirm your password" required>
                    </div>
                    <div class="register-field">
                        <input type="email" class="register-input" id="email" name="email"
                            placeholder="Enter your email" required>
                    </div>
                    <button class="register-button register-submit" type="submit" name="submit">
                        Register <i class="button-icon fas fa-chevron-right"></i>
                    </button>
                    <div style="padding-left: 12px; padding-top: 24px; ">
                        <p style="color: #FFF; font-weight: 650;">Already have an account?
                            <a style="color: #FFF" href="index.php">Log In</a>
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