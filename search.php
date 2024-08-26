<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "marketplace";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil query pencarian dari parameter GET
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Escape input untuk keamanan
$query = $conn->real_escape_string($query);

// Query untuk mencari produk
$sql = "SELECT * FROM produk WHERE nama_produk LIKE '%$query%'";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>Hasil Pencarian untuk "<?php echo htmlspecialchars($query); ?>"</h1>
    <?php if ($result->num_rows > 0): ?>
        <ul>
            <?php while ($row = $result->fetch_assoc()): ?>
                <li>
                    <h2><?php echo htmlspecialchars($row['nama_produk']); ?></h2>
                    <p>Harga: <?php echo htmlspecialchars($row['harga']); ?></p>
                    <p><?php echo htmlspecialchars($row['desk']); ?></p>
                    <img src="<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['nama_produk']); ?>">
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>Produk tidak ditemukan.</p>
    <?php endif; ?>

    <?php
    $conn->close();
    ?>
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
  <script src="js/script.js">
  </script>
</body>
</html>

