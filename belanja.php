<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Arahkan ke halaman login jika belum login
    exit();
}
include 'koneksi.php';
$sql = "SELECT * FROM produk";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Belanja - Online Shop</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="index.html">Online Shop</a>
  </nav>

  <div class="container mt-5 pt-4">
    <h1 class="text-center">Belanja</h1>
    <div class="row mt-4">
      <div class="col-12">
        <div class="card mb-3">
        <?php if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
          <div class="col-12 col-md-3 mb-4">
            <div class="card">
              <img src="<?php echo $row['gambar']; ?>" class="card-img-top" alt="<?php echo $row['nama_produk']; ?>">
              <div class="card-body text-center">
                <h5 class="card-title"><?php echo $row['nama_produk']; ?></h5>
                <p class="card-text">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#productModal"
                        data-id="<?php echo $row['id_produk']; ?>"
                        data-name="<?php echo $row['nama_produk']; ?>"
                        data-description="<?php echo $row['desk']; ?>"
                        data-price="<?php echo $row['harga']; ?>"
                        data-image="<?php echo $row['gambar']; ?>">
                  Beli Sekarang
                </button>
                <a href="add_to_cart.php?id_produk=<?php echo $row['id_produk']; ?>" class="btn btn-secondary mt-2">
                  <img src="https://img.icons8.com/ios-filled/24/000000/shopping-cart.png" alt="Add to Cart"> Add to Cart
                </a>
              </div>
            </div>
          </div>
        <?php }
      } else { ?>
        <div class="col-12">
          <p class="text-center">Produk Tidak Ditemukan</p>
        </div>
      <?php } ?>
        </div>
        <!-- Add more product cards here -->
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
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
