<?php
// Start session
session_start();

// Check if user is already logged in, redirect if needed
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  // Redirect based on user category
  $redirect = "index.php";
  if (isset($_SESSION["category"])) {
    switch ($_SESSION["category"]) {
      case "admin":
        $redirect = "admin_dashboard.php";
        break;
      case "student":
        $redirect = "student_dashboard.php";
        break;
      case "lecturer":
        $redirect = "lecturer_dashboard.php";
        break;
    }
    header("location: " . $redirect);
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User System - Login</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style>
    body {
      background-color: #f8f9fa;
    }
    .login-container {
      max-width: 400px;
      margin: 100px auto;
      padding: 20px;
      background: white;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .login-header {
      text-align: center;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="login-container">
    <div class="login-header">
      <h2>User Login</h2>
    </div>

    <div id="message-container"></div>

    <form id="loginForm" action="login_process.php" method="post">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" id="username" name="username" required>
      </div>

      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>

      <div class="form-group">
        <label for="category">Category:</label>
        <select class="form-control" id="category" name="category" required>
          <option value="">Select Role</option>
          <option value="admin">Admin</option>
          <option value="student">Student</option>
          <option value="lecturer">Lecturer</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
  </div>
</div>

<script>
  $(document).ready(function() {
    // Form submission using AJAX
    $("#loginForm").submit(function(e) {
      e.preventDefault();

      $.ajax({
        type: "POST",
        url: "login_process.php",
        data: $(this).serialize(),
        dataType: "json",
        success: function(response) {
          if (response.status === "success") {
            // Show success message
            $("#message-container").html('<div class="alert alert-success">' + response.message + '</div>');

            // Redirect to the appropriate dashboard
            setTimeout(function() {
              window.location.href = response.redirect;
            }, 1000);
          } else {
            // Show error message
            $("#message-container").html('<div class="alert alert-danger">' + response.message + '</div>');
          }
        },
        error: function() {
          $("#message-container").html('<div class="alert alert-danger">An error occurred during login.</div>');
        }
      });
    });
  });
</script>
</body>
</html>
