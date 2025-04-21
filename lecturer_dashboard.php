<?php
// Include session check
require_once "session_check.php";
// Verify user is lecturer
check_login("lecturer");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lecturer Dashboard</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <style>
    .navbar {
      margin-bottom: 20px;
    }
    .dashboard-card {
      transition: transform 0.3s;
    }
    .dashboard-card:hover {
      transform: translateY(-5px);
    }
  </style>
</head>
<body>
<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <div class="container">
    <a class="navbar-brand" href="#">Lecturer Portal</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="lecturer_dashboard.php">Dashboard</a>
        </li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
          <span class="nav-link">Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?></span>
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
  <div class="jumbotron">
    <h1 class="display-4">Welcome to Lecturer Dashboard</h1>
    <p class="lead">Manage your courses and student information here.</p>
  </div>

  <div class="row">
    <div class="col-md-4 mb-4">
      <div class="card dashboard-card">
        <div class="card-body text-center">
          <i class="fas fa-chalkboard-teacher fa-3x mb-3 text-success"></i>
          <h5 class="card-title">My Courses</h5>
          <p class="card-text">Manage your course materials and syllabus.</p>
          <a href="#" class="btn btn-success">Manage Courses</a>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4">
      <div class="card dashboard-card">
        <div class="card-body text-center">
          <i class="fas fa-users fa-3x mb-3 text-primary"></i>
          <h5 class="card-title">Students</h5>
          <p class="card-text">View and manage student enrollments.</p>
          <a href="#" class="btn btn-primary">View Students</a>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4">
      <div class="card dashboard-card">
        <div class="card-body text-center">
          <i class="fas fa-clipboard-check fa-3x mb-3 text-danger"></i>
          <h5 class="card-title">Grading</h5>
          <p class="card-text">Grade student assignments and exams.</p>
          <a href="#" class="btn btn-danger">Grade Work</a>
        </div>
      </div>
    </div>
  </div>

  <div class="card mt-4">
    <div class="card-header bg-info text-white">
      <h5 class="mb-0">Recent Activity</h5>
    </div>
    <div class="card-body">
      <div class="alert alert-info">
        <h5>Welcome to the Lecturer Portal</h5>
        <p>This is a demo lecturer dashboard for the User Management System.</p>
        <p>In a real system, this would display recent course activities and notifications.</p>
      </div>
    </div>
  </div>
</div>
</body>
</html>
