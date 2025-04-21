<?php
// Database configuration
define('DB_SERVER', 'localhost');  // MySQL server - typically 'localhost' for XAMPP
define('DB_USERNAME', 'root');     // Default XAMPP username
define('DB_PASSWORD', '');         // Default XAMPP password (blank)
define('DB_NAME', 'user_system');  // Database name - you'll need to create this

// Attempt to connect to MySQL database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
