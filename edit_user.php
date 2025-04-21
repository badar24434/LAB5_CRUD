<?php
// Include session check
require_once "session_check.php";
// Verify user is admin
check_login("admin");

// Include database connection
require_once "config.php";

// Check if ID parameter is set and valid
if(!isset($_GET["id"]) || empty($_GET["id"])) {
  header("location: admin_dashboard.php");
  exit;
}

$id = intval($_GET["id"]);
$user = null;

// Fetch user data
$sql = "SELECT id, username, category, status FROM users WHERE id = ?";
if($stmt = $conn->prepare($sql)) {
  $stmt->bind_param("i", $id);
  if($stmt->execute()) {
    $result = $stmt->get_result();
    if($result->num_rows == 1) {
      $user = $result->fetch_assoc();
    } else {
      // No user found with the ID
      header("location: admin_dashboard.php");
      exit;
    }
  } else {
    echo "Error executing query.";
  }
  $stmt->close();
} else {
  echo "Error preparing statement.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <style>
    .navbar {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">User Management System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="admin_dashboard.php">Dashboard</a>
        </li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
          <span class="nav-link">Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?> (Admin)</span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main Content -->
<div class="container">
  <div class="row">
    <div class="col-md-8 mx-auto">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Edit User</h5>
        </div>
        <div class="card-body">
          <div id="editUserMessage"></div>

          <?php if($user): ?>
            <form id="editUserForm">
              <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
                <small class="form-text text-muted">Username cannot be changed.</small>
              </div>

              <div class="form-group">
                <label for="new_password">New Password (leave blank to keep current):</label>
                <input type="password" class="form-control" id="new_password" name="new_password">
              </div>

              <div class="form-group">
                <label for="category">Category:</label>
                <select class="form-control" id="category" name="category" required>
                  <option value="admin" <?php if($user['category'] == 'admin') echo 'selected'; ?>>Admin</option>
                  <option value="student" <?php if($user['category'] == 'student') echo 'selected'; ?>>Student</option>
                  <option value="lecturer" <?php if($user['category'] == 'lecturer') echo 'selected'; ?>>Lecturer</option>
                </select>
              </div>

              <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status" required>
                  <option value="active" <?php if($user['status'] == 'active') echo 'selected'; ?>>Active</option>
                  <option value="inactive" <?php if($user['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
                </select>
              </div>

              <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
              <input type="hidden" name="action" value="update">

              <div class="form-group">
                <button type="submit" class="btn btn-primary">Update User</button>
                <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
              </div>
            </form>
          <?php else: ?>
            <div class="alert alert-danger">User not found.</div>
            <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    // Handle edit user form submission
    $("#editUserForm").submit(function(e) {
      e.preventDefault();

      $.ajax({
        type: "POST",
        url: "user_processing.php",
        data: $(this).serialize(),
        dataType: "json",
        success: function(response) {
          if (response.status === "success") {
            $("#editUserMessage").html('<div class="alert alert-success">' + response.message + '</div>');
            setTimeout(function() {
              window.location.href = "admin_dashboard.php";
            }, 1000);
          } else {
            $("#editUserMessage").html('<div class="alert alert-danger">' + response.message + '</div>');
          }
        },
        error: function() {
          $("#editUserMessage").html('<div class="alert alert-danger">An error occurred.</div>');
        }
      });
    });
  });
</script>
</body>
</html>
