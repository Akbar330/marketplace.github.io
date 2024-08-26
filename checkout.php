<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Arahkan ke halaman login jika belum login
    exit();
}

include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    die("User ID tidak ditemukan. Silakan login ulang.");
}

$user_id = $_SESSION['user_id']; // Ambil user_id dari sesi

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $total_harga = $_POST['total_harga'];
    $tanggal_transaksi = date('Y-m-d H:i:s');

    // Mulai transaksi
    $conn->begin_transaction();

    try {
        // Insert transaksi
        $sql = "INSERT INTO transaksi (id_pelanggan, harga_total, metode_pembayaran) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param('ids', $user_id, $total_harga, $metode_pembayaran);
        $stmt->execute();
        if ($stmt->error) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        $transaksi_id = $stmt->insert_id; // Ambil id_transaksi yang baru saja diinsert

        // Insert detail transaksi
        foreach ($_SESSION['cart'] as $item) {
            // Ambil deskripsi produk
            $sql = "SELECT desk FROM produk WHERE id_produk = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $item['id_produk']);
            $stmt->execute();
            if ($stmt->error) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            $result = $stmt->get_result();
            $product = $result->fetch_assoc();
            $desk = $product['desk'];

            $item_total = $item['harga'] * $item['qty'];
            $sql = "INSERT INTO detail_transaksi (id_transaksi, id_produk, desk) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('iis', $transaksi_id, $item['id_produk'], $desk);
            $stmt->execute();
            if ($stmt->error) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
        }

        // Komit transaksi jika semua query berhasil
        $conn->commit();

        // Clear cart
        unset($_SESSION['cart']);

        header("Location: success.php"); // Arahkan ke halaman sukses
        exit();
    } catch (Exception $e) {
        // Rollback jika ada error
        $conn->rollback();
        die("Terjadi kesalahan: " . $e->getMessage());
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
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
        <h1 class="text-center">Checkout</h1>
      </div>
    </div>

    <form action="checkout.php" method="post">
      <input type="hidden" name="total_harga" value="<?php echo $total; ?>">
      <div class="form-group">
        <label for="metode_pembayaran">Metode Pembayaran:</label>
        <select class="form-control" id="metode_pembayaran" name="metode_pembayaran" required>
          <option value="Transfer Bank">Transfer Bank</option>
          <option value="Kartu Kredit">Kartu Kredit</option>
          <option value="PayPal">PayPal</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Proses Pembayaran</button>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
