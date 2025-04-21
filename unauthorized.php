<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Unauthorized Access</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style>
    body {
      background-color: #f8f9fa;
      padding-top: 100px;
    }
    .error-container {
      max-width: 600px;
      margin: 0 auto;
      text-align: center;
    }
    .error-icon {
      font-size: 5rem;
      color: #dc3545;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="error-container">
    <div class="error-icon">&#9888;</div>
    <h1 class="mt-4">Unauthorized Access</h1>
    <p class="lead">Sorry, you don't have permission to access this page.</p>
    <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
      <?php
      // Determine redirect based on user category
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
      }
      ?>
      <p>Return to your <a href="<?php echo $redirect; ?>">dashboard</a>.</p>
    <?php else: ?>
      <p>Please <a href="login.php">login</a> to continue.</p>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
