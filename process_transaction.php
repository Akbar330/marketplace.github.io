<?php
session_start(); // Pastikan sesi dimulai

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "marketplace";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pastikan id_pelanggan ada dalam sesi
if (!isset($_SESSION['id_pelanggan'])) {
    die("Anda Harus Login dulu.");
}

$id_pelanggan = $_SESSION['id_pelanggan'];
$id_produk = $_POST['id_produk'];
$qty = $_POST['qty'];
$harga_total = $_POST['harga_total'];
$metode_pembayaran = $_POST['metode_pembayaran'];

// Memulai transaksi untuk memastikan konsistensi data
$conn->begin_transaction();

try {
    // 1. Masukkan data transaksi ke tabel `transaksi`
    $sql_transaksi = "INSERT INTO transaksi (id_pelanggan, id_produk, qty, harga_total, metode_pembayaran)
                      VALUES ('$id_pelanggan', '$id_produk', '$qty', '$harga_total', '$metode_pembayaran')";
    
    if ($conn->query($sql_transaksi) === TRUE) {
        // Ambil ID transaksi yang baru dimasukkan
        $id_transaksi = $conn->insert_id;

        // 2. Ambil deskripsi produk dari tabel `produk`
        $sql_produk = "SELECT desk FROM produk WHERE id_produk = '$id_produk'";
        $result_produk = $conn->query($sql_produk);

        if ($result_produk->num_rows > 0) {
            $row_produk = $result_produk->fetch_assoc();
            $desk_produk = $row_produk['desk'];

            // 3. Masukkan data detail transaksi ke tabel `detail_transaksi`
            $sql_detail = "INSERT INTO detail_transaksi (id_transaksi, id_produk, desk)
                           VALUES ('$id_transaksi', '$id_produk', '$desk_produk')";
            
            if ($conn->query($sql_detail) === TRUE) {
                // Komit transaksi jika semua query berhasil
                $conn->commit();
                echo "Transaksi berhasil dibuat.";
            } else {
                throw new Exception("Error: " . $sql_detail . "<br>" . $conn->error);
            }
        } else {
            throw new Exception("Error: Produk tidak ditemukan.");
        }
    } else {
        throw new Exception("Error: " . $sql_transaksi . "<br>" . $conn->error);
    }
} catch (Exception $e) {
    // Rollback jika ada error
    $conn->rollback();
    echo "Terjadi kesalahan: " . $e->getMessage();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
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
</body>
</html>
