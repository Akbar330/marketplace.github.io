<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Arahkan ke halaman login jika belum login
    exit();
}

include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart</title>
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
          <a class="nav-link" href="wishlist.php">
            <img src="https://img.icons8.com/ios-filled/50/000000/like.png" alt="Wishlist" class="icon">
            Wishlist
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container mt-5 pt-4">
    <div class="row mt-4">
      <div class="col-12">
        <h1 class="text-center">Your Cart</h1>
      </div>
    </div>

    <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) { ?>
      <div class="row mt-4">
        <div class="col-12">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $total = 0;
              foreach ($_SESSION['cart'] as $item) {
                $item_total = $item['harga'] * $item['qty'];
                $total += $item_total;
                ?>
                <tr>
                  <td><img src="<?php echo $item['gambar']; ?>" alt="<?php echo $item['nama_produk']; ?>" class="img-thumbnail" style="width: 100px;"></td>
                  <td><?php echo $item['nama_produk']; ?></td>
                  <td>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                  <td><?php echo $item['qty']; ?></td>
                  <td>Rp <?php echo number_format($item_total, 0, ',', '.'); ?></td>
                  <td><a href="remove_from_cart.php?id_produk=<?php echo $item['id_produk']; ?>" class="btn btn-danger">Remove</a></td>
                </tr>
              <?php } ?>
              <tr>
                <td colspan="4" class="text-right"><strong>Total:</strong></td>
                <td><strong>Rp <?php echo number_format($total, 0, ',', '.'); ?></strong></td>
                <td></td>
              </tr>
            </tbody>
          </table>
          <a href="checkout.php" class="btn btn-primary">Checkout</a>
        </div>
      </div>
    <?php } else { ?>
      <div class="row mt-4">
        <div class="col-12">
          <p class="text-center">Your cart is empty.</p>
        </div>
      </div>
    <?php } ?>
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
