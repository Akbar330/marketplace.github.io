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
  <title>Bayar Tagihan - Online Shop</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <div class="container mt-5 pt-4">
    <h1 class="text-center">Bayar Tagihan</h1>
    <div class="row mt-4">
      <div class="col-12">
        <form>
          <div class="form-group">
            <label for="billId">Bill ID</label>
            <input type="text" class="form-control" id="billId" placeholder="Enter bill ID">
          </div>
          <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" class="form-control" id="amount" placeholder="Enter amount">
          </div>
          <button type="submit" class="btn btn-primary">Pay</button>
        </form>
      </div>
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

