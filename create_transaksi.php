<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pelanggan = $_POST['id_pelanggan'];
    $id_produk = $_POST['id_produk'];
    $qty = $_POST['qty'];
    $harga_total = $_POST['harga_total'];
    $metode_pembayaran = $_POST['metode_pembayaran'];

    $sql = "INSERT INTO transaksi (id_pelanggan, id_produk, qty, harga_total, metode_pembayaran)
            VALUES ('$id_pelanggan', '$id_produk', '$qty', '$harga_total', '$metode_pembayaran')";

    if (mysqli_query($conn, $sql)) {
        echo "Transaksi berhasil dibuat.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
