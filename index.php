<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="./JS/jquery.js"></script>
    <script src="./JS/login.js" type=""></script>
    <link rel="stylesheet" href="styleIndex.css" />
    <header class="login-header" style="text-align: center; padding-top: 56px">
      <h1>My Contacts Hub</h1>
    </header>
  </head>

  <body>
    <div class="container_index">
      <div class="screen">
        <div class="screen-content">
          <form id="loginForm">
            <div class="login-field">
              <input
                type="text"
                class="login-input"
                id="user_name"
                placeholder="Enter your username"
                required
              />
            </div>
            <div class="login-field">
              <input
                type="password"
                class="login-input"
                id="password"
                placeholder="Enter your password"
                required
              />
            </div>
            <button class="login-submit" type="submit">
              Log in <i class="button-icon fas fa-chevron-right"></i>
            </button>
            <div style="padding-left: 12px; padding-top: 24px">
              <p style="color: #fff; font-weight: 650">
                Don't have an account?
                <a style="color: #fff" href="register.php">Register</a>
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
