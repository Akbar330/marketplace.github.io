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

// Periksa apakah data dari form ada
if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) &&
    isset($_POST['nama']) && isset($_POST['alamat']) && isset($_POST['jenis_kelamin']) && isset($_POST['no_hp'])) {

    // Mendapatkan data dari form
    $user = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $pass = md5($conn->real_escape_string($_POST['password'])); // Menggunakan MD5 untuk enkripsi password
    $nama = $conn->real_escape_string($_POST['nama']);
    $alamat = $conn->real_escape_string($_POST['alamat']);
    $jenis_kelamin = $conn->real_escape_string($_POST['jenis_kelamin']);
    $no_hp = $conn->real_escape_string($_POST['no_hp']);

    // Memeriksa apakah username sudah ada
    $sql = "SELECT * FROM users WHERE username='$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "Username already exists!";
    } else {
        // Memasukkan data ke database
        $sql = "INSERT INTO users (username, password, email) VALUES ('$user', '$pass', '$email')";
        
        if ($conn->query($sql) === TRUE) {
            // Ambil user_id yang baru dibuat
            $user_id = $conn->insert_id;

            // Masukkan data ke tabel pelanggan
            $sql_pelanggan = "INSERT INTO pelanggan (nama, alamat, jenis_kelamin, no_hp, id_user) 
                              VALUES ('$nama', '$alamat', '$jenis_kelamin', '$no_hp', '$user_id')";

            if ($conn->query($sql_pelanggan) === TRUE) {
                echo "Registration successful!";
                header("Location: login.php"); // Arahkan ke halaman login
                exit();
            } else {
                echo "Error: " . $sql_pelanggan . "<br>" . $conn->error;
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
} else {
    echo "Form data is missing!";
}

$conn->close();
?>
