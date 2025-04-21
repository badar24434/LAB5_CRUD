<?php
// Include session check
require_once "session_check.php";
// Verify user is admin
check_login("admin");

// Include database connection
require_once "config.php";

// Process only if it's a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = array();
    $action = isset($_POST["action"]) ? $_POST["action"] : "";

    // Handle different CRUD operations
    switch ($action) {
        case "create":
            // Create a new user
            $new_username = trim($_POST["new_username"]);
            $new_password = trim($_POST["new_password"]);
            $new_category = trim($_POST["new_category"]);
            $new_status = trim($_POST["new_status"]);

            // Validate inputs
            if (empty($new_username) || empty($new_password) || empty($new_category) || empty($new_status)) {
                $response = array(
                    "status" => "error",
                    "message" => "All fields are required."
                );
                break;
            }

            // Check if username already exists
            $check_sql = "SELECT id FROM users WHERE username = ?";
            if ($check_stmt = $conn->prepare($check_sql)) {
                $check_stmt->bind_param("s", $new_username);
                $check_stmt->execute();
                $check_stmt->store_result();

                if ($check_stmt->num_rows > 0) {
                    $response = array(
                        "status" => "error",
                        "message" => "Username already exists."
                    );
                    $check_stmt->close();
                    break;
                }
                $check_stmt->close();
            }

            // Store the password directly (no hashing)
            $password = $new_password;

            // Insert new user
            $insert_sql = "INSERT INTO users (username, password, category, status) VALUES (?, ?, ?, ?)";
            if ($insert_stmt = $conn->prepare($insert_sql)) {
                $insert_stmt->bind_param("ssss", $new_username, $password, $new_category, $new_status);

                if ($insert_stmt->execute()) {
                    $response = array(
                        "status" => "success",
                        "message" => "User created successfully."
                    );
                } else {
                    $response = array(
                        "status" => "error",
                        "message" => "Error creating user: " . $conn->error
                    );
                }
                $insert_stmt->close();
            } else {
                $response = array(
                    "status" => "error",
                    "message" => "Error preparing statement: " . $conn->error
                );
            }
            break;

        case "update":
            // Update existing user
            $id = intval($_POST["id"]);
            $category = $_POST["category"];
            $status = $_POST["status"];
            $new_password = trim($_POST["new_password"]);

            // Start with update query without password
            $sql = "UPDATE users SET category = ?, status = ?";
            $param_types = "ss";
            $params = array($category, $status);

            // If new password is provided, include it in the update
            if (!empty($new_password)) {
                // Store password directly (no hashing)
                $password = $new_password;
                $sql .= ", password = ?";
                $param_types .= "s";
                $params[] = $password;
            }

            // Complete the query with WHERE clause
            $sql .= " WHERE id = ?";
            $param_types .= "i";
            $params[] = $id;

            // Prepare and execute the statement
            if ($stmt = $conn->prepare($sql)) {
                // Create references to the items in the $params array for bind_param
                $refs = array();
                foreach($params as $key => $value)
                    $refs[$key] = &$params[$key];
                
                // Use call_user_func_array to bind the parameters dynamically
                call_user_func_array(array($stmt, 'bind_param'), array_merge(array($param_types), $refs));

                if ($stmt->execute()) {
                    $response = array(
                        "status" => "success",
                        "message" => "User updated successfully."
                    );
                } else {
                    $response = array(
                        "status" => "error",
                        "message" => "Error updating user: " . $stmt->error
                    );
                }

                $stmt->close();
            } else {
                $response = array(
                    "status" => "error",
                    "message" => "Error preparing statement: " . $conn->error
                );
            }
            break;

        default:
            $response = array(
                "status" => "error",
                "message" => "Invalid action."
            );
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

// If not a POST request, redirect to dashboard
header("location: admin_dashboard.php");
exit();
?>
