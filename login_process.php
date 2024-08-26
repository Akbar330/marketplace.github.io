<?php
session_start(); // Mulai sesi

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "marketplace";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mendapatkan data dari form
$user = $_POST['username'];
$email = $_POST['email'];
$pass = md5($_POST['password']); // Menggunakan MD5 untuk enkripsi password

// Memeriksa apakah username, password, dan email sesuai di tabel users
$sql = "SELECT user_id FROM users WHERE username='$user' AND password='$pass' AND email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Ambil user_id dari tabel users
    $user_data = $result->fetch_assoc();
    $user_id = $user_data['user_id'];

    // Dapatkan id_pelanggan dari tabel pelanggan
    $sql_pelanggan = "SELECT id_pelanggan FROM pelanggan WHERE id_user='$user_id'";
    $result_pelanggan = $conn->query($sql_pelanggan);

    if ($result_pelanggan->num_rows > 0) {
        $pelanggan_data = $result_pelanggan->fetch_assoc();
        $_SESSION['id_pelanggan'] = $pelanggan_data['id_pelanggan'];
    } else {
        $_SESSION['id_pelanggan'] = null; // Atau Anda bisa menambahkan logika lain di sini
    }

    // Simpan username ke dalam sesi
    $_SESSION['username'] = $user;
    header("Location: index.php"); // Arahkan ke halaman utama
    exit();
} else {
    // Jika username, password, atau email salah, arahkan kembali ke halaman login dengan pesan error
    header("Location: login.php?error=1");
    exit();
}

$conn->close();
?>
