<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Arahkan ke halaman login jika belum login
    exit();
}

include 'koneksi.php';

// Mendapatkan user_id dari tabel users
$username = $_SESSION['username'];
$sql_user = "SELECT user_id FROM users WHERE username='$username'";
$result_user = mysqli_query($conn, $sql_user);
if (!$result_user) {
    die("Error: " . mysqli_error($conn));
}
$user_data = mysqli_fetch_assoc($result_user);
$user_id = $user_data['user_id'];

// Mendapatkan data pelanggan yang sesuai dengan user_id
$sql_pelanggan = "SELECT * FROM pelanggan WHERE id_user='$user_id'";
$result_pelanggan = mysqli_query($conn, $sql_pelanggan);
if (!$result_pelanggan) {
    die("Error: " . mysqli_error($conn));
}
$pelanggan_data = mysqli_fetch_assoc($result_pelanggan);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
    
    // Update data pelanggan
    $sql_update = "UPDATE pelanggan 
                   SET nama='$nama', alamat='$alamat', jenis_kelamin='$jenis_kelamin', no_hp='$no_hp' 
                   WHERE id_user='$user_id'";
    
    if (mysqli_query($conn, $sql_update)) {
        $message = "Profil berhasil diperbarui.";
        // Update data pelanggan dalam session jika diperlukan
        $pelanggan_data['nama'] = $nama;
        $pelanggan_data['alamat'] = $alamat;
        $pelanggan_data['jenis_kelamin'] = $jenis_kelamin;
        $pelanggan_data['no_hp'] = $no_hp;
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Pastikan data pelanggan tidak kosong
$nama = isset($pelanggan_data['nama']) ? htmlspecialchars($pelanggan_data['nama']) : '';
$alamat = isset($pelanggan_data['alamat']) ? htmlspecialchars($pelanggan_data['alamat']) : '';
$jenis_kelamin = isset($pelanggan_data['jenis_kelamin']) ? htmlspecialchars($pelanggan_data['jenis_kelamin']) : '';
$no_hp = isset($pelanggan_data['no_hp']) ? htmlspecialchars($pelanggan_data['no_hp']) : '';

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil - Online Shop</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="index.php">Online Shop</a>
  </nav>

  <div class="container mt-5 pt-4">
    <h1 class="text-center">Profil</h1>
    <div class="row mt-4">
      <div class="col-md-6 offset-md-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Halo, <?php echo htmlspecialchars($_SESSION['username']); ?></h5>
            <p class="card-text">Here you can view and update your profile information.</p>
            <form method="POST" action="">
              <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>" required>
              </div>
              <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat; ?>" required>
              </div>
              <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                  <option value="Laki-laki" <?php if ($jenis_kelamin == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                  <option value="Perempuan" <?php if ($jenis_kelamin == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                </select>
              </div>
              <div class="form-group">
                <label for="no_hp">Nomor HP</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?php echo $no_hp; ?>" required>
              </div>
              <a href="create_produk.php" class="btn btn-primary">Tambah Produk</a>
              <a href="settings.php" class="btn btn-secondary mt-3">Settings</a>

              
              <?php if (isset($message)) echo "<div class='mt-2 alert alert-info'>$message</div>"; ?>
            </form>
            <a href="logout.php" class="btn btn-primary mt-3">Logout</a>

          </div>
        </div>
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
