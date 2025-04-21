<?php
// Include session check
require_once "session_check.php";
// Verify user is admin
check_login("admin");

// Include database connection
require_once "config.php";

// Process form submissions for CRUD operations
$message = "";
$message_class = "";

// Process user deletion
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Don't allow admins to delete themselves
    if ($id == $_SESSION['id']) {
        $message = "You cannot delete your own account!";
        $message_class = "alert-danger";
    } else {
        $delete_sql = "DELETE FROM users WHERE id = ?";
        if ($stmt = $conn->prepare($delete_sql)) {
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
$message = "User deleted successfully!";
$message_class = "alert-success";
} else {
$message = "Error deleting user!";
$message_class = "alert-danger";
}
$stmt->close();
}
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <style>
    .action-buttons .btn {
      margin-right: 5px;
    }
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
        <li class="nav-item active">
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
  <h2>Admin Dashboard</h2>
  <p>Manage all system users.</p>

  <?php if (!empty($message)): ?>
  <div class="alert <?php echo $message_class; ?>"><?php echo $message; ?></div>
  <?php endif; ?>

  <!-- Create User Button -->
  <div class="mb-3">
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addUserModal">
      <i class="fas fa-user-plus"></i> Add New User
    </button>
  </div>

  <!-- Users Table -->
  <div class="card">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">User Accounts</h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead class="thead-light">
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Category</th>
            <th>Status</th>
            <th>Created</th>
            <th>Actions</th>
          </tr>
          </thead>
          <tbody>
          <?php
                            // Fetch all users
                            $sql = "SELECT id, username, category, status, created_at FROM users ORDER BY id ASC";
                            $result = $conn->query($sql);

          if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
          echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["category"]) . "</td>";

            // Status with color coding
            $status_class = ($row["status"] == 'active') ? 'badge-success' : 'badge-danger';
            echo "<td><span class='badge " . $status_class . "'>" . htmlspecialchars($row["status"]) . "</span></td>";

            echo "<td>" . $row["created_at"] . "</td>";
            echo "<td class='action-buttons'>";
              echo "<a href='edit_user.php?id=" . $row["id"] . "' class='btn btn-sm btn-primary'><i class='fas fa-edit'></i> Edit</a>";

              // Prevent deleting oneself
              if ($row["id"] != $_SESSION['id']) {
              echo "<a href='#' onclick='confirmDelete(" . $row["id"] . ")' class='btn btn-sm btn-danger'><i class='fas fa-trash'></i> Delete</a>";
              }

              echo "</td>";
            echo "</tr>";
          }
          } else {
          echo "<tr><td colspan='6' class='text-center'>No users found</td></tr>";
          }
          ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="addUserForm" action="user_process.php" method="post">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Add New User</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div id="addUserMessage"></div>

          <div class="form-group">
            <label for="new_username">Username:</label>
            <input type="text" class="form-control" id="new_username" name="new_username" required>
          </div>

          <div class="form-group">
            <label for="new_password">Password:</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
          </div>

          <div class="form-group">
            <label for="new_category">Category:</label>
            <select class="form-control" id="new_category" name="new_category" required>
              <option value="admin">Admin</option>
              <option value="student">Student</option>
              <option value="lecturer">Lecturer</option>
            </select>
          </div>

          <div class="form-group">
            <label for="new_status">Status:</label>
            <select class="form-control" id="new_status" name="new_status" required>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="action" value="create">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Create User</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // Function to confirm user deletion
  function confirmDelete(userId) {
    if (confirm("Are you sure you want to delete this user?")) {
      window.location.href = "admin_dashboard.php?delete=" + userId;
    }
  }

  $(document).ready(function() {
    // Handle add user form submission
    $("#addUserForm").submit(function(e) {
      e.preventDefault();

      $.ajax({
        type: "POST",
        url: "user_processing.php",
        data: $(this).serialize(),
        dataType: "json",
        success: function(response) {
          if (response.status === "success") {
            $("#addUserMessage").html('<div class="alert alert-success">' + response.message + '</div>');
            setTimeout(function() {
              location.reload();
            }, 1000);
          } else {
            $("#addUserMessage").html('<div class="alert alert-danger">' + response.message + '</div>');
          }
        },
        error: function() {
          $("#addUserMessage").html('<div class="alert alert-danger">An error occurred.</div>');
        }
      });
    });
  });
</script>
</body>
</html>
