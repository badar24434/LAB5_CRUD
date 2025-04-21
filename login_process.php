<?php
// Start session
session_start();

// Include database connection
require_once "config.php";

// Process only if it's a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $response = array();

  // Get input values
  $username = trim($_POST["username"]);
  $password = trim($_POST["password"]);
  $category = trim($_POST["category"]);

  // Basic validation
  if (empty($username) || empty($password) || empty($category)) {
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode([
      "status" => "error",
      "message" => "All fields are required."
    ]);
    exit;
  }

  // Prepare a select statement
  $sql = "SELECT id, username, password, category FROM users WHERE username = ? AND category = ? AND status = 'active'";

  if ($stmt = $conn->prepare($sql)) {
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("ss", $username, $category);

    // Execute the statement
    if ($stmt->execute()) {
      // Store result
      $stmt->store_result();

      // Check if username exists
      if ($stmt->num_rows == 1) {
        // Bind result variables
        $stmt->bind_result($id, $username, $db_password, $user_category);

        if ($stmt->fetch()) {
          // Verify password (plain text comparison)
          if ($password === $db_password) {
            // Password is correct; no need to call session_start() again

            // Store data in session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $id;
            $_SESSION["username"] = $username;
            $_SESSION["category"] = $user_category;

            // Determine redirect based on user category
            $redirect = "";
            switch ($user_category) {
              case "admin":
                $redirect = "admin_dashboard.php";
                break;
              case "student":
                $redirect = "student_dashboard.php";
                break;
              case "lecturer":
                $redirect = "lecturer_dashboard.php";
                break;
              default:
                $redirect = "index.php";
            }

            header("Content-Type: application/json; charset=UTF-8");
            echo json_encode([
              "status" => "success",
              "message" => "Login successful",
              "redirect" => $redirect
            ]);
            exit;
          } else {
            header("Content-Type: application/json; charset=UTF-8");
            echo json_encode([
              "status" => "error",
              "message" => "Invalid username or password"
            ]);
            exit;
          }
        }
      } else {
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode([
          "status" => "error",
          "message" => "No account found with that username and category."
        ]);
        exit;
      }
    } else {
      header("Content-Type: application/json; charset=UTF-8");
      echo json_encode([
        "status" => "error",
        "message" => "Oops! Something went wrong. Please try again later."
      ]);
      exit;
    }

    // Close statement
    $stmt->close();
  }

  // Close connection
  $conn->close();
}
?>
