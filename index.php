<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  // Redirect based on user category
  if (isset($_SESSION["category"])) {
    switch ($_SESSION["category"]) {
      case "admin":
        header("location: admin_dashboard.php");
        break;
      case "student":
        header("location: student_dashboard.php");
        break;
      case "lecturer":
        header("location: lecturer_dashboard.php");
        break;
      default:
        // Fallback to login page
        header("location: login.php");
    }
    exit;
  } else {
    // No category found, redirect to login
    session_unset();
    session_destroy();
    header("location: login.php");
    exit;
  }
} else {
  // Not logged in, redirect to login page
  header("location: login.php");
  exit;
}
?>
