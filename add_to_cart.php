<?php
session_start();
include 'koneksi.php';

if (isset($_GET['id_produk'])) {
    $id_produk = intval($_GET['id_produk']);
    
    // Cek jika cart sudah ada di session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Tambahkan produk ke dalam keranjang (tabel cart

    // Cek apakah produk sudah ada di cart
    if (!isset($_SESSION['cart'][$id_produk])) {
        // Ambil informasi produk
        $sql = "SELECT * FROM produk WHERE id_produk = $id_produk";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['cart'][$id_produk] = array(
                'id_produk' => $row['id_produk'],
                'nama_produk' => $row['nama_produk'],
                'harga' => $row['harga'],
                'gambar' => $row['gambar'],
                'qty' => 1
            );
        }
    } else {
        $_SESSION['cart'][$id_produk]['qty'] += 1;
    }

    header("Location: cart.php"); // Arahkan ke halaman cart
    exit();
}
?>
