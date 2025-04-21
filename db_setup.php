<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_system";
$sql_file = "database.sql";

// Create connection without database name first
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die('<div style="color:red;margin:20px;">Connection failed: ' . $conn->connect_error . '</div>');
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    $success_message = "Database created or already exists successfully<br>";
} else {
    die('<div style="color:red;margin:20px;">Error creating database: ' . $conn->error . '</div>');
}

// Select the database
$conn->select_db($dbname);

// Read SQL file content
$sql_content = file_get_contents($sql_file);

if ($sql_content === false) {
    die('<div style="color:red;margin:20px;">Error reading SQL file: ' . $sql_file . '</div>');
}

// Execute SQL statements
$success = true;
$error_message = "";
$info_message = "";

// Split SQL content into DDL (table creation) and DML (data insertion) parts
$sql_parts = explode("-- Insert sample users", $sql_content);
$table_sql = $sql_parts[0]; // DDL for table creation

// Execute the table creation part
if(!empty(trim($table_sql))) {
    if($conn->query($table_sql) !== TRUE) {
        $success = false;
        $error_message .= "Error creating tables: " . $conn->error . "<br>";
    }
}

// Only proceed with data insertion if tables were created successfully
if($success && count($sql_parts) > 1) {
    // Check if any users already exist
    $result = $conn->query("SELECT COUNT(*) as count FROM users");
    $row = $result->fetch_assoc();
    $user_count = $row['count'];
    
    if($user_count == 0) {
        // No users exist, safe to insert sample data
        $data_sql = "-- Insert sample users" . $sql_parts[1];
        if($conn->query($data_sql) !== TRUE) {
            // Non-critical error - tables exist but sample data insertion failed
            $info_message .= "Note: Sample data was not inserted (this is normal if running setup again): " . $conn->error . "<br>";
        } else {
            $success_message .= "Sample users created successfully.<br>";
        }
    } else {
        // Users already exist, skip insertion
        $info_message .= "Sample users already exist - skipping data insertion.<br>";
    }
}

// Close connection
$conn->close();

// Output result with styled HTML
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding: 40px;
            background-color: #f8f9fa;
        }
        .setup-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .success-icon {
            color: #28a745;
            font-size: 3rem;
            margin-bottom: 20px;
        }
        .error-icon {
            color: #dc3545;
            font-size: 3rem;
            margin-bottom: 20px;
        }
        .info-text {
            color: #17a2b8;
        }
    </style>
</head>
<body>
    <div class="container setup-container">
        <?php if ($success): ?>
            <div class="text-center">
                <div class="success-icon">✓</div>
                <h2 class="text-success">Database Setup Successful</h2>
                <p><?php echo $success_message; ?></p>
                
                <?php if (!empty($info_message)): ?>
                    <div class="alert alert-info">
                        <p class="info-text"><?php echo $info_message; ?></p>
                    </div>
                <?php endif; ?>
                
                <p>The database structure has been created in the '<?php echo htmlspecialchars($dbname); ?>' database.</p>
                <div class="mt-4">
                    <a href="login.php" class="btn btn-primary">Go to Login Page</a>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center">
                <div class="error-icon">×</div>
                <h2 class="text-danger">Database Setup Failed</h2>
                <p>There was an error setting up the database:</p>
                <div class="alert alert-danger">
                    <?php echo $error_message; ?>
                </div>
                <div class="mt-4">
                    <a href="db_setup.php" class="btn btn-primary">Try Again</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
