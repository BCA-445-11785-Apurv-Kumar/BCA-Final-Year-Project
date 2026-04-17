<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Panel | iDiscuss</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Admin CSS -->
<link rel="stylesheet" href="/FORUM/admin/style.css">
</head>

<body class="bg-light d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="/FORUM/admin/index.php">iDiscuss Admin</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#adminNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="adminNavbar">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="/FORUM/admin/index.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="/FORUM/admin/users.php">Users</a></li>
        <li class="nav-item"><a class="nav-link" href="/FORUM/admin/categories.php">Categories</a></li>
        <li class="nav-item"><a class="nav-link" href="/FORUM/admin/threads.php">Threads</a></li>
        <li class="nav-item"><a class="nav-link" href="/FORUM/admin/comments.php">Comments</a></li>
        <li class="nav-item"><a class="nav-link" href="/FORUM/admin/contact_messages.php">Contact Messages</a></li>
      </ul>

      <div class="text-light d-flex align-items-center">
        <span class="me-3">
          Welcome, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
        </span>
        <a href="/FORUM/admin/logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
      </div>
    </div>
  </div>
</nav>

<!-- PAGE CONTENT START -->
<div class="container-fluid my-4 content">

