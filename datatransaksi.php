<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Arahkan ke halaman login jika belum login
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "marketplace";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil id_pelanggan dari sesi
$id_pelanggan = $_SESSION['id_pelanggan'];

// Query untuk mengambil data transaksi
$sql_transaksi = "SELECT t.id_transaksi, t.harga_total
                  FROM transaksi t
                  WHERE t.id_pelanggan = '$id_pelanggan'";

$result_transaksi = $conn->query($sql_transaksi);

if (!$result_transaksi) {
    die("Query failed: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Transaksi - Online Shop</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="index.html">Online Shop</a>
  </nav>

  <div class="container mt-5 pt-4">
    <h1 class="text-center">Data Transaksi</h1>
    <div class="row mt-4">
      <div class="col-12">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Product</th>
              <th>Quantity</th>
              <th>Price</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result_transaksi->num_rows > 0) {
                $index = 1;
                while ($row_transaksi = $result_transaksi->fetch_assoc()) {
                    $id_transaksi = $row_transaksi['id_transaksi'];
                    $harga_total = $row_transaksi['harga_total'];

                    // Query untuk mengambil detail transaksi
                    $sql_detail = "SELECT d.id_produk, d.desk, p.nama_produk
                                   FROM detail_transaksi d
                                   JOIN produk p ON d.id_produk = p.id_produk
                                   WHERE d.id_transaksi = '$id_transaksi'";
                                   
                    $result_detail = $conn->query($sql_detail);

                    if (!$result_detail) {
                        die("Query failed: " . $conn->error);
                    }

                    while ($row_detail = $result_detail->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$index}</td>";
                        echo "<td>{$row_detail['nama_produk']}</td>";
                        echo "<td>{$row_detail['desk']}</td>"; // Jika "desk" adalah kuantitas, ubah jika perlu
                        echo "<td>Rp" . number_format($harga_total, 0, ',', '.') . "</td>";
                        echo "</tr>";
                        $index++;
                    }
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>No transactions found</td></tr>";
            }
            ?>
          </tbody>
        </table>
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

<?php
$conn->close();
?>
