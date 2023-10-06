<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <head>
      <link rel="stylesheet" href="styleRegister.css" />
    </head>
    <script src="./JS/jquery.js"></script>
    <script src="./JS/register.js" type=""></script>
    <header
      class="register-header"
      style="text-align: center; padding-top: 56px"
    >
      <h1>Contastic</h1>
    </header>
  </head>

  <body>
    <div class="container_index">
      <div class="screen">
        <div class="screen-content">
          <h2 style="text-align: center; padding-top: 40px; color: white">
            Register
          </h2>
          <form class="register" id="registerForm">
            <div class="register-field">
              <input
                type="text"
                class="register-input"
                id="user_name"
                placeholder="Enter your username"
                required
              />
            </div>
            <div class="register-field">
              <input
                type="password"
                class="register-input"
                id="password"
                placeholder="Enter your password"
                required
              />
            </div>
            <div class="register-field">
              <input
                type="password"
                class="register-input"
                id="confirm_password"
                placeholder="Confirm your password"
                required
              />
            </div>
            <div class="register-field">
              <input
                type="email"
                class="register-input"
                id="email"
                placeholder="Enter your email"
                required
              />
            </div>
            <button
              class="register-button register-submit"
              type="submit"
            >
              Register <i class="button-icon fas fa-chevron-right"></i>
            </button>
            <div style="padding-left: 12px; padding-top: 24px">
              <p style="color: #fff; font-weight: 650">
                Already have an account?
                <a class="login-button" style="color: #fff" href="index.php">Log In</a>
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
