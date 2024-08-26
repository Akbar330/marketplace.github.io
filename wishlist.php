<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Arahkan ke halaman login jika belum login
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wishlist - Online Shop</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="#">Online Shop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">
            <img src="https://img.icons8.com/ios-filled/50/000000/home.png" alt="Home" class="icon">
            Home
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container mt-5 pt-4">
    <div class="row mt-4">
      <div class="col-12">
        <h1 class="text-center">Wishlist</h1>
      </div>
    </div>


    <nav class="navbar fixed-bottom navbar-light bg-light">
    <div class="container-fluid d-flex justify-content-around">
      <a class="nav-link text-center" href="index.php">
        <img src="https://img.icons8.com/ios-filled/50/000000/home.png" alt="Home" class="icon">
        <span class="d-block">Home</span>
      </a>
      <a class="nav-link text-center" href="datatransaksi.php">
        <img src="https://img.icons8.com/ios-filled/50/000000/transaction-list.png" alt="Data Transaksi" class="icon">
        <span class="d-block">Transaksi</span>
      </a>
      <a class="nav-link text-center" href="notification.php">
        <img src="https://img.icons8.com/ios-filled/50/000000/appointment-reminders.png" alt="Notification" class="icon">
        <span class="d-block">Notif</span>
      </a>
      <a class="nav-link text-center" href="profile.php">
        <img src="https://img.icons8.com/ios-filled/50/000000/user.png" alt="Profile" class="icon">
        <span class="d-block">Profile</span>
      </a>
    </div>
  </nav>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
