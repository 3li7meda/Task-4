<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
  <div class="container d-flex justify-content-between align-items-center">
    
    <!..clic to return come bage..>
  <a class="navbar-brand fw-bold text-warning" href="index.php">Real Estate</a> 
    
    <div class="d-flex gap-2">
        <?php if (isset($_SESSION['id'])): ?> 
            <a href="user-inf.php" class="btn btn-outline-light btn-sm">Profile</a>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        <?php else: ?>
            <a href="login.php" class="btn btn-outline-light btn-sm">Login</a>
            <a href="register.php" class="btn btn-warning btn-sm">Register</a>
        <?php endif; ?>
    </div>
  </div>
</nav>


<main class="flex-grow-1">
    <div class="container">