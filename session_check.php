<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not redirect to login page
function check_login($required_category = null) {
  if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
  }

  // If specific category required, check it
  if ($required_category !== null && $_SESSION["category"] !== $required_category) {
    header("location: unauthorized.php");
    exit;
  }
}

// Function to check if user is admin
function is_admin() {
  return isset($_SESSION["category"]) && $_SESSION["category"] === "admin";
}

// Function to check if user is student
function is_student() {
  return isset($_SESSION["category"]) && $_SESSION["category"] === "student";
}

// Function to check if user is lecturer
function is_lecturer() {
  return isset($_SESSION["category"]) && $_SESSION["category"] === "lecturer";
}
?>
