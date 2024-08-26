<?php
// Mulai sesi
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
$host = 'localhost'; // Ganti dengan host database Anda
$db = 'marketplace'; // Ganti dengan nama database Anda
$user = 'root'; // Ganti dengan username database Anda
$pass = ''; // Ganti dengan password database Anda

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tambah profil toko
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_POST['id_user'];
    $nama_toko = $_POST['nama_toko'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $poto = $_POST['poto'];

    $sql = "INSERT INTO profil_toko (id_user, nama_toko, alamat, no_hp, poto) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $id_user, $nama_toko, $alamat, $no_hp, $poto);

    if ($stmt->execute()) {
        echo "Profil toko berhasil ditambahkan!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Profil Toko</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Tambah Profil Toko</h1>
        <form action="create_profil_toko.php" method="POST">
            <div class="form-group">
                <label for="id_user">ID User</label>
                <input type="number" class="form-control" id="id_user" name="id_user" required>
            </div>
            <div class="form-group">
                <label for="nama_toko">Nama Toko</label>
                <input type="text" class="form-control" id="nama_toko" name="nama_toko" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="no_hp">No HP</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp" required>
            </div>
            <div class="form-group">
                <label for="poto">Poto</label>
                <input type="text" class="form-control" id="poto" name="poto" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Profil</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
