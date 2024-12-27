<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login | Online Survey System</title>

<?php include('./header.php'); ?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");
?>

</head>
<style>
    body {
        width: 100%;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background-image: url('images/backgound.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        margin: 0;
    }
    .login-container {
        width: 100%;
        max-width: 400px;
        background: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .login-container img {
        max-width: 150px;
        margin-bottom: 20px;
    }
    .login-container .btn-primary {
        width: 100%;
    }
    .login-container .auth-link {
        display: block;
        margin-top: 10px;
    }
    .password-toggle {
        position: relative;
    }
    .password-toggle input {
        padding-right: 30px;
    }
    .password-toggle .toggle-icon {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
    }
</style>

<body>
  <div class="login-container">
      <div class="logo"><a href="index.php"><img src="images/logo.png" alt="Logo"></a></div>
      <div class="card">
          <div class="card-body">
              <form id="login-form">
                  <div class="form-group">
                      <label for="email" class="control-label text-dark">Email</label>
                      <input type="text" id="email" name="email" class="form-control form-control-sm">
                  </div>
                  <div class="form-group password-toggle">
                      <label for="password" class="control-label text-dark">Password</label>
                      <div style="position: relative;">
                          <input type="password" id="password" name="password" class="form-control form-control-sm">
                          <span class="toggle-icon" onclick="togglePasswordVisibility()">👁️</span>
                      </div>
                  </div>
                  <button class="btn btn-primary btn-block btn-sm">Login</button>
                  <a href="forgot-password.php" class="auth-link text-dark">Forgot password?</a>
              </form>
          </div>
      </div>
  </div>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

</body>
<script>
    function togglePasswordVisibility() {
        const passwordField = document.getElementById('password');
        const toggleIcon = document.querySelector('.toggle-icon');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleIcon.textContent = '🙈';
        } else {
            passwordField.type = 'password';
            toggleIcon.textContent = '👁️';
        }
    }

    $('#login-form').submit(function(e) {
        e.preventDefault();
        $('#login-form button').attr('disabled', true).text('Logging in...');
        if ($(this).find('.alert-danger').length > 0)
            $(this).find('.alert-danger').remove();
        $.ajax({
            url: 'ajax.php?action=login',
            method: 'POST',
            data: $(this).serialize(),
            error: err => {
                console.log(err);
                $('#login-form button').removeAttr('disabled').text('Login');
            },
            success: function(resp) {
                if (resp == 1) {
                    location.href = 'index.php?page=home';
                } else {
                    $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>');
                    $('#login-form button').removeAttr('disabled').text('Login');
                }
            }
        });
    });
</script>
</html>







<!-- 

PHP Files:
./db_connect.php:

This file is included at the beginning of the script. It likely contains the code to establish a database connection.
./header.php:

This file is included in the <head> section of the HTML. It likely contains meta tags, links to CSS files, and potentially reusable header components.
ajax.php:

The login form makes an AJAX request to this file with the action login. It likely handles the backend authentication logic by verifying the submitted credentials (email and password) against the database.
index.php?page=home:

This is the destination page after a successful login. It redirects users to the homepage/dashboard.
forgot-password.php:

This file is linked as the "Forgot password?" page, providing functionality for users to reset their passwords.
JavaScript Libraries/Functions:
ajax.php?action=login:

AJAX request to handle login actions in the backend.
JavaScript Functions in the Script:

Handles form submission and error messages.
Ensures numerical input only (e.g., for number fields).
Images/Assets:
images/backgound.jpg:

Used as a full-screen background image.
images/logo.png:

Displays the logo at the top of the login form.
CSS and UI:
Inline Styles:

body styles for background image and fixed position.
Styling for the card that contains the login form.
Dynamic Button Behavior:

The login button changes to "Logging in..." and gets disabled during submission.
To Ensure Functionality:
db_connect.php must properly establish the database connection.
ajax.php should handle authentication securely (e.g., hash comparison for passwords).
forgot-password.php must handle email/password reset workflows.

 -->