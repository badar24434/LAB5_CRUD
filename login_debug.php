<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();

// Include database connection
require_once "config.php";

echo "<h1>Login System Debug</h1>";

// Check PHP version
echo "<h2>Environment</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p>Content Type: " . $_SERVER['HTTP_ACCEPT'] . "</p>";

// Test database connection
echo "<h2>Database Connection</h2>";
if ($conn->connect_error) {
    echo "<p style='color:red'>Database connection failed: " . $conn->connect_error . "</p>";
} else {
    echo "<p style='color:green'>Database connection: OK</p>";
    
    // Check users table
    $result = $conn->query("SHOW TABLES LIKE 'users'");
    if ($result->num_rows > 0) {
        echo "<p style='color:green'>Users table: Found</p>";
        
        // Check user accounts
        $result = $conn->query("SELECT id, username, category, status FROM users");
        echo "<p>Total user accounts: " . $result->num_rows . "</p>";
        
        echo "<h3>User Accounts</h3>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Username</th><th>Category</th><th>Status</th></tr>";
        
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["category"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "<p style='color:red'>Users table: Not found</p>";
    }
}

// Check current session
echo "<h2>Current Session</h2>";
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    echo "<p>User is logged in as: " . htmlspecialchars($_SESSION["username"]) . " (ID: " . $_SESSION["id"] . ")</p>";
    echo "<p>User category: " . htmlspecialchars($_SESSION["category"]) . "</p>";
    echo "<p><a href='logout.php'>Log out</a></p>";
} else {
    echo "<p>No active login session.</p>";
    echo "<p><a href='login.php'>Go to login page</a></p>";
}

// Output processor information
echo "<h2>Test Login Form</h2>";
?>

<form method="post" action="login_process.php">
  <div>
    <label>Username:</label>
    <input type="text" name="username" value="student1">
  </div>
  <div>
    <label>Password:</label>
    <input type="text" name="password" value="password123">
  </div>
  <div>
    <label>Category:</label>
    <select name="category">
      <option value="student">Student</option>
      <option value="admin">Admin</option>
      <option value="lecturer">Lecturer</option>
    </select>
  </div>
  <div>
    <input type="submit" value="Test Login">
  </div>
</form>

<p><a href="check_student.php">Check Student Account</a> | <a href="reset_student_pwd.php">Reset Student Password</a></p>
<p><a href="db_setup.php">Reinitialize Database</a></p>
