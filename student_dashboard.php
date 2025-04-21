<?php
// Include session check
require_once "session_check.php";
// Verify user is student
check_login("student");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Dashboard</title>
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
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="#">Student Portal</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="student_dashboard.php">Dashboard</a>
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
    <h1 class="display-4">Welcome to Student Dashboard</h1>
    <p class="lead">Access your student resources and information here.</p>
  </div>

  <div class="row">
    <div class="col-md-4 mb-4">
      <div class="card dashboard-card">
        <div class="card-body text-center">
          <i class="fas fa-book fa-3x mb-3 text-primary"></i>
          <h5 class="card-title">Courses</h5>
          <p class="card-text">View your enrolled courses and course materials.</p>
          <a href="#" class="btn btn-primary">Go to Courses</a>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4">
      <div class="card dashboard-card">
        <div class="card-body text-center">
          <i class="fas fa-calendar-alt fa-3x mb-3 text-success"></i>
          <h5 class="card-title">Schedule</h5>
          <p class="card-text">Check your class schedule and upcoming events.</p>
          <a href="#" class="btn btn-success">View Schedule</a>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4">
      <div class="card dashboard-card">
        <div class="card-body text-center">
          <i class="fas fa-tasks fa-3x mb-3 text-warning"></i>
          <h5 class="card-title">Assignments</h5>
          <p class="card-text">View and submit your course assignments.</p>
          <a href="#" class="btn btn-warning">View Assignments</a>
        </div>
      </div>
    </div>
  </div>

  <div class="card mt-4">
    <div class="card-header bg-info text-white">
      <h5 class="mb-0">Announcements</h5>
    </div>
    <div class="card-body">
      <div class="alert alert-info">
        <h5>Welcome to the Student Portal</h5>
        <p>This is a demo student dashboard for the User Management System.</p>
        <p>In a real system, this would display important course announcements and updates.</p>
      </div>
    </div>
  </div>
</div>
</body>
</html>
